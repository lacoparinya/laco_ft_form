<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\LogSelectM;
use App\Shift;
use App\Product;

use Illuminate\Support\Facades\Mail;
use App\Mail\FtSelect3DataEmail;

class GenDailySelect2Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailyselect2report {shift_id} {diff}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate New Daily Select Report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '256M');
        $shiftId = $this->argument('shift_id');
        $diff = $this->argument('diff');

        //echo $shiftId;

        $selecteddate = date('Y-m-d');
        if ($diff == 'Y') {
            $selecteddate = date('Y-m-d', strtotime("-1 days"));
        }
        //


        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        $current_date = $selecteddate;

        $fileList = array();
        $fileList2 = array();
        $resultList = array();

        $shiftObj = Shift::findOrFail($shiftId);

        $loopData = LogSelectM::where('process_date', $current_date)
            ->where('shift_id', $shiftId)
            ->select('id')
            ->get();

        foreach ($loopData as $valueLoop) {

            $logselectm = LogSelectM::findOrFail($valueLoop['id']);

            //var_dump($rawdata);
            $data1y = array();
            $data2y = array();
            $data3y = array();
            $data4y = array();
            $data1x = array();
            $sum = 0;
            $totalAct = 0;
            $totalPlan = 0;
            $resultar = array();
            $rateperhour = $logselectm->targetperday / $logselectm->hourperday;

            foreach ($logselectm->logselectd()->orderBy('process_datetime')->get() as $valueObj) {
                $sum += $valueObj->output_kg;
                $data1y[] = $valueObj->output_kg;
                $data2y[] = $sum;
                $data3y[] = $valueObj->workhours * ($rateperhour);
                $data1x[] = date('H:i',strtotime($valueObj->process_datetime));

                $totalAct += $valueObj->output_kg;
                $totalPlan += $valueObj->workhours * ($rateperhour);

                if (!empty($valueObj->problem)) {
                    $resultar['problem'][] = date('H:i', strtotime($valueObj->process_datetime)) . " - " . $valueObj->problem;
                }

            }

            if ($totalPlan == $totalAct) {
                $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:yellow;">ผลิตได้ตามป้าหมาย</span>';
            } elseif ($totalPlan > $totalAct) {
                $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:red;">ผลิตได้ต่ำกว่าเป้าหมาย ' . round(((($totalPlan - $totalAct) * 100) / $totalPlan), 2) . "%</span>";
            } else {
                $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:green;">ผลิตได้มากกว่าเป้าหมาย ' . round(((($totalAct - $totalPlan) * 100) / $totalPlan), 2) . "%</span>";
            }

            if (!empty($data1x)) {

                $graph = new \Graph(900, 400);
                $graph->SetScale('intlin');
                $graph->SetYScale(0, 'lin');
                //$graph->SetScale("textlin");
                $graph->SetShadow();

                $theme_class = new \UniversalTheme;
                $graph->SetTheme($theme_class);

                //$graph->yaxis->SetTickPositions(array(0, 30, 60, 90, 120, 150), array(15, 45, 75, 105, 135));
                $graph->SetBox(false);

                //$graph->ygrid->SetFill(false);
                $graph->xaxis->SetTickLabels($data1x);

                //$graph->xaxis->title->Set('เวลา');
                $graph->xaxis->SetLabelSide(SIDE_BOTTOM);
                $graph->xaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);
                $graph->xaxis->SetTitle('เวลา', 'center');
                $graph->xaxis->SetTitleMargin(30);
                $graph->yaxis->SetTitle('ปริมาณ');
                $graph->yaxis->SetTitleMargin(3);
                $graph->yaxis->HideZeroLabel();
                $graph->yaxis->SetTitlemargin(-10);
                $graph->yaxis->SetTitleSide(SIDE_RIGHT);
                $graph->yaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);
                //  $graph->yaxis->HideLine(false);
                //$graph->yaxis->HideTicks(false, false);

                $b1plot = new \BarPlot($data1y);
                $b3plot = new \BarPlot($data3y);
                $b2plot = new \LinePlot($data2y);

                $gbplot = new \GroupBarPlot(array( $b3plot, $b1plot));

                $graph->title->Set($logselectm->product->name . " อัตราการคัดสะสม " . $selecteddate . " กะ " . $shiftObj->name);
                $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);

                $graph->Add($gbplot);
                $graph->AddY(0, $b2plot);
                $graph->ynaxis[0]->SetColor('black');
                $graph->ynaxis[0]->title->Set('Y-title');

                $gbplot->SetColor("white");
                $gbplot->SetFillColor("#22ff11");

                $b3plot->value->Show();
                $b3plot->value->SetFormat('%d');
                $b3plot->value->SetColor('black', 'darkred');
                $b3plot->SetLegend("Planning");
                $b1plot->value->Show();
                $b1plot->value->SetFormat('%d');
                $b1plot->value->SetColor('black', 'darkred');
                $b1plot->SetLegend("Actual");

                //$b2plot->SetBarCenter();
                $b2plot->SetColor("red");
                //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

                $b2plot->mark->SetType(MARK_X, '', 1.0);
                $b2plot->mark->setColor("red");
                $b2plot->value->SetFormat('%d');
                $b2plot->value->Show();
                $b2plot->value->SetColor('red');
                $b2plot->SetLegend("Sum");

                $b2plot->mark->setFillColor("red");

                $graph->legend->SetPos(0.4, 0.05, 'left', 'top');
                $graph->legend->SetColumns(4);

                $date = date('ymdHis');

                $filename = "graph/selects/ft_log_select_" . $current_date . "-" . $shiftId . "-" . $logselectm->product_id . "-" . $date . ".jpg";

                $filename1 = public_path() . "/graph/selects/ft_log_select_" . $current_date . "-" . $shiftId . "-" . $logselectm->product_id . "-" . $date . ".jpg";


                $graph->Stroke($filename1);

                //$image1 = file_get_contents($filename1);
                //if ($image1 !== false) {
                //    $fileList[] = 'data:image/jpg;base64,' . base64_encode( $image1);
                //}

                $fileList[] = $filename;
                $resultList[] = $resultar;
            }
        }

        $loopData = LogSelectM::where('process_date', $current_date)
            ->select('process_date','product_id')
            ->groupBy('process_date', 'product_id')
            ->get();

        foreach ($loopData as $valueLoop) {

            $productObj = Product::findOrFail($valueLoop['product_id']);
            
            $logselectmA = LogSelectM::where('process_date',$valueLoop['process_date'])
                            ->where('product_id', $valueLoop['product_id'])
                            ->get();

                $data1y = array();
                $data2y = array();
                $data3y = array();
                $data4y = array();
                $data1x = array();
                $sum = 0;
           

            $totalTime = 0;
            $remainTime = 0;
            $totalinput = 0;
            $totaloutput = 0;
            $totalsum = 0;
            $ratePerHr = 0;

            $targetResult = 0;
            $sumtotalhruse = 0;

            foreach ($logselectmA as $logselectm) {

                $sumtotalhruse += $logselectm->hourperday;
                $targetResult += $logselectm->targetperday;

                foreach ($logselectm->logselectd()->orderBy('process_datetime')->get() as $valueObj) {
                    $sum += $valueObj->output_kg;
                    $data1y[] = $valueObj->output_kg;
                    $data2y[] = 0;
                    $data3y[] = $sum;
                    $data4y[] = $sum;
                    $data1x[] = date('H:i',strtotime($valueObj->process_datetime));

                    $totalTime += $valueObj->workhours;
                    $totalinput += $valueObj->input_kg;
                    $totaloutput += $valueObj->output_kg;
                }

            }

            $remainTime = $sumtotalhruse - $totalTime;
            

            if ($remainTime > 0) {
                $totalsum = $totaloutput;
                $ratePerHr = ($targetResult - $totaloutput) / $remainTime;
            }

            $loop = 0;
            $loopSum = $totalsum;
            $estimateData = array();
            while ($loop < $remainTime) {
                $tmpArray = array();

                if (($remainTime - $loop) > 1) {
                    $loop++;
                    $data1x[] = "Hr ".$loop;
                    $data1y[] = 0;
                    $data2y[] = $ratePerHr;
                    $loopSum += $ratePerHr;
                    $data3y[] = $loopSum;
                    $estimateData[] = $tmpArray;
                } else {
                    if (($remainTime - $loop) > 0) {
                        $data2y[] = $targetResult - $loopSum;

                        $loop = $remainTime;
                        $data1x[] = "Hr " . $remainTime;

                        $data1y[] = 0;

                        $data3y[] = $targetResult;
                        $estimateData[] = $tmpArray;
                    }
                }
            }


            if (!empty($data1x)) {

                $graph = new \Graph(900, 400);
                $graph->SetScale('intlin');
                $graph->SetYScale(0, 'lin');
                //$graph->SetScale("textlin");
                $graph->SetShadow();

                $theme_class = new \UniversalTheme;
                $graph->SetTheme($theme_class);

                //$graph->yaxis->SetTickPositions(array(0, 30, 60, 90, 120, 150), array(15, 45, 75, 105, 135));
                $graph->SetBox(false);

                //$graph->ygrid->SetFill(false);
                $graph->xaxis->SetTickLabels($data1x);

                //$graph->xaxis->title->Set('เวลา');
                $graph->xaxis->SetLabelSide(SIDE_BOTTOM);
                $graph->xaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);
                $graph->xaxis->SetTitle('เวลา', 'center');
                $graph->xaxis->SetTitleMargin(30);
                $graph->yaxis->SetTitle('ปริมาณ');
                $graph->yaxis->SetTitleMargin(3);
                $graph->yaxis->HideZeroLabel();
                $graph->yaxis->SetTitlemargin(-10);
                $graph->yaxis->SetTitleSide(SIDE_RIGHT);
                $graph->yaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);
                //  $graph->yaxis->HideLine(false);
                //$graph->yaxis->HideTicks(false, false);

                $b1plot = new \BarPlot($data1y);
                $b2plot = new \BarPlot($data2y);
                $b3plot = new \LinePlot($data3y);

                $gbplot = new \GroupBarPlot(array($b1plot, $b2plot));

                $graph->title->Set($productObj->name . " อัตราการคัดสะสมทั้งหมด " . $selecteddate);
                $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);

                $graph->Add($gbplot);
                $graph->AddY(0, $b3plot);
                $graph->ynaxis[0]->SetColor('black');
                $graph->ynaxis[0]->title->Set('Y-title');

                $b1plot->SetColor("white");
                $b1plot->SetFillColor("#00ff00");
                $b1plot->value->SetFormat('%d');
                $b1plot->value->Show();
                $b1plot->SetLegend("Actual");

                $b2plot->SetColor("white");
                $b2plot->SetFillColor("#ff0000");
                $b2plot->value->SetFormat('%d');
                $b2plot->value->Show();
                $b2plot->SetLegend("Forecast");

                //$b2plot->SetBarCenter();
                $b3plot->SetColor("red");
                //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

                $b3plot->mark->SetType(MARK_X, '', 1.0);
                $b3plot->mark->setColor("red");
                $b3plot->value->SetFormat('%d');
                $b3plot->value->Show();
                $b3plot->value->SetColor('red');
                $b3plot->SetLegend("Sum");

                $b3plot->mark->setFillColor("red");

                $graph->legend->SetPos(0.4, 0.05, 'left', 'top');
                $graph->legend->SetColumns(4);

                $date = date('ymdHis');

                $filename2 = "graph/selects/ft_log_select_all_" . $current_date . "-" . $productObj->id . "-" . $date . ".jpg";

                $filename11 = public_path() . "/graph/selects/ft_log_select_all_" . $current_date . "-" . $productObj->id . "-" . $date . ".jpg";


                $graph->Stroke($filename11);

                //$image2 = file_get_contents($filename11);
                //if ( $image2 !== false) {
                //   $fileList2[] = 'data:image/jpg;base64,' . base64_encode( $image2);
                //}

                $fileList2[] = $filename2;
            }
        }
        

        $ftStaff = config('myconfig.emailtestlist');

        $mailObj['graph'] = $fileList;
        $mailObj['graph2'] = $fileList2;
        $mailObj['shift'] = $shiftObj;
        $mailObj['result'] = $resultList;
        $mailObj['subject'] = " อัตราการคัดสะสม " . $selecteddate;

        Mail::to($ftStaff)->send(new FtSelect3DataEmail($mailObj));
    }
}
