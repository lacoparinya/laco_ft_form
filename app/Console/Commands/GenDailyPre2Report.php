<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\LogPrepareM;
use App\Shift;
use App\PreProd;
use App\Mail\FtPreRptMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class GenDailyPre2Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailypre2report {diff}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Daily Prepare Report';


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
        $diff = $this->argument('diff');

        $selecteddate = date('Y-m-d');
        if ($diff == 'Y') {
            $selecteddate = date('Y-m-d', strtotime("-1 days"));
        }

        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        $current_date = $selecteddate;

        $fileList = array();

        $loopData = LogPrepareM::where('process_date', $current_date)->get();
        /*
        $loopData = FtLogPre::where('process_date', $current_date)
            ->select('shift_id', 'pre_prod_id')
            ->groupBy('shift_id', 'pre_prod_id')
            ->orderBy( 'shift_id', 'asc')
            ->orderBy( 'pre_prod_id', 'asc')
            ->get();
        */

        foreach ($loopData as $logpreparem) {
            //echo $mpObj->shift_id." - ". $mpObj->pre_prod_id;
            $detailData = $logpreparem->logprepared()->orderBy('process_datetime')->get();

            $totalTime = 0;
            $remainTime = 0;
            $totalinput = 0;
            $totaloutput = 0;
            $totalsum = 0;
            $ratePerHr = 0;
            foreach ($detailData as $key => $value) {
                $totalTime += $value->workhours;
                $totalinput += $value->input;
                $totaloutput += $value->output;
            }

            $remainTime = $logpreparem->target_workhours - $totalTime;
            $targetResult = $logpreparem->target_result;

            if ($remainTime > 0) {
                if ($totalinput > 0) {
                    $totalsum = $totalinput;
                    $ratePerHr = ($targetResult - $totalinput) / $remainTime;
                } else {

                    $totalsum = $totaloutput;
                    $ratePerHr = ($targetResult - $totaloutput) / $remainTime;
                }
            }

            $loop = 0;
            $loopSum = $totalsum;
            $estimateData = array();
            while ($loop < $remainTime) {
                $tmpArray = array();

                if (($remainTime - $loop) > 1) {
                    $loop++;
                    $tmpArray['time'] = $loop;
                    $tmpArray['realrate'] = $ratePerHr;
                    $loopSum += $ratePerHr;
                    $tmpArray['realtotal'] = $loopSum;
                    $estimateData[] = $tmpArray;
                } else {
                    if (($remainTime - $loop) > 0) {
                        $tmpArray['realrate'] = $targetResult - $loopSum;

                        $loop = $remainTime;
                        $tmpArray['time'] = $remainTime;



                        $tmpArray['realtotal'] = $targetResult;
                        $estimateData[] = $tmpArray;
                    }
                }
            }

            $data1y = array();
            $data2y = array();
            $data3y = array();
            $data4y = array();
            $data1x = array();

            foreach ($logpreparem->logprepared()->orderBy('process_datetime')->get() as $item){
                $data1x[] = date('H:i', strtotime($item->process_datetime));
                $data1y[] = $item->targets;
                if ($item->input > 0){
                    $data2y[] = $item->input;
                }else{
                    $data2y[] = $item->output;
                }
                $data3y[] = 0;
                if($item->input_sum > 0) {
                    $data4y[] = $item->input_sum;
                }else{
                    $data4y[] = $item->output_sum;
                }

            }

            foreach ($estimateData as $item2){
                $data1x[] = "ชม.ที่". $item2['time'];
                $data1y[] = 0;
                $data2y[] = 0;
                $data3y[] = $item2['realrate'];
                $data4y[] = $item2['realtotal'];
            }


/*

            foreach ($rawdata as $rptObj) {
                $data1x[] = date("H:i", strtotime($item->process_datetime));
                if($rptObj->input > 0){
                    $data1y[] = $rptObj->input;
                    $data2y[] = $rptObj->input_sum;
                }else{
                    $data1y[] = $rptObj->output;
                    $data2y[] = $rptObj->output_sum;
                }

               // $data3y[] = $rptObj->output;
               // $data4y[] = $rptObj->output_sum;
                
                
                $dataty[] = $rptObj->targets;
            }
            */

            $graph = new \Graph(900, 400);
            $graph->SetScale('intlin');
            $graph->SetYScale(0, 'lin');

            $theme_class = new \UniversalTheme;
            $graph->SetTheme($theme_class);

            $graph->SetBox(false);

            $graph->xaxis->SetTickLabels($data1x);

            $graph->xaxis->SetLabelSide(SIDE_BOTTOM);
            $graph->xaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);
            $graph->xaxis->SetTitle('เวลา', 'center');
            $graph->xaxis->SetFont(FF_CORDIA, FS_NORMAL, 14);
            $graph->xaxis->SetTitleMargin(30);
            $graph->yaxis->SetTitle('ปริมาณ');
            $graph->yaxis->SetTitleMargin(3);
            $graph->yaxis->HideZeroLabel();
            $graph->yaxis->SetTitlemargin(-10);
            $graph->yaxis->SetTitleSide(SIDE_RIGHT);
            $graph->yaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);

            $b1plot = new \BarPlot($data1y);
            $b2plot = new \BarPlot($data2y);
            $b3plot = new \BarPlot($data3y);
            $l1plot = new \LinePlot($data4y);

            $gbplot = new \GroupBarPlot(array($b3plot,$b1plot));

            $graph->title->Set($logpreparem->preprod->name . " - อัตราการเตรียมการ วันที่ " . $selecteddate);
            $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);


            $graph->Add( $gbplot);

            $graph->AddY(0, $l1plot);
            $graph->ynaxis[0]->SetColor('black');
            $graph->ynaxis[0]->title->Set('Y-title');


            $l1plot->SetColor("red");
            //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

            $l1plot->mark->SetType(MARK_X, '', 1.0);
            $l1plot->mark->setColor("red");
            $l1plot->value->SetFormat('%d');
            $l1plot->value->Show();
            $l1plot->value->SetColor('red');

            $l1plot->mark->setFillColor("red");
            $l1plot->SetLegend("Sum");

            $gbplot->SetColor("white");
            $gbplot->SetFillColor("#22ff11");

            $b3plot->value->Show();
            $b3plot->value->SetFormat('%d');
            $b3plot->value->SetColor('black', 'darkred');
            $b3plot->SetLegend("Target");
            $b2plot->value->Show();
            $b2plot->value->SetFormat('%d');
            $b2plot->value->SetColor('black', 'darkred');
            $b3plot->SetLegend("Input or Output");
            $b1plot->value->Show();
            $b1plot->value->SetFormat('%d');
            $b1plot->value->SetColor('black', 'darkred');
            $b1plot->SetLegend("Input or Output");

            

            $graph->legend->SetPos(0.4, 0.05, 'left', 'top');
            $graph->legend->SetColumns(3);

            $date = date('ymdHis');

            $filename = "graph/prepare/ft_log_pre_" . $current_date . "-" . $logpreparem->preprod->name . "-" . $logpreparem->id . "-" . $date . ".jpg";

            $filename1 = public_path() . "/graph/prepare/ft_log_pre_" . $current_date . "-" . $logpreparem->preprod->name . "-" . $logpreparem->id . "-" . $date . ".jpg";


            $graph->Stroke($filename1);

            $fileList[] = $filename;
        }

        if(!empty( $fileList)){
            $ftStaff = config( 'myconfig.emaillist');

            $mailObj['graph'] = $fileList;
            $mailObj['subject'] = " อัตราการเตรียมการสะสม " . $selecteddate;

            Mail::to($ftStaff)->send(new FtPreRptMail($mailObj));
        }
    }
}
