<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\LogPackM;

class GenDailyPack2Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailypack2report {diff}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate New Daily Pack Report';

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

        $loopData = LogPackM::where('process_date', $current_date)
            ->get();

        foreach ($loopData as $mpObj) {
            $logpackm = LogPackM::findOrFail($mpObj->id);

            $totalTime = 0;
            $totaloutputpack = 0;
            $data1y = array();
            $data2y = array();
            $data3y = array();
            $data4y = array();
            $data1x = array();
            $sum = 0;
            foreach ($logpackm->logpackd()->orderBy('process_datetime')->get() as $valueObj) {
                $totalTime += $valueObj->workhours;
                $sum += $valueObj->output_pack;
                $data1y[] = $logpackm->stdpack->packperhour * $valueObj->workhours;
                $data2y[] = $valueObj->output_pack;
                $data3y[] = 0;
                $data4y[] = $sum;
                $data1x[] = date('H:i',strtotime($valueObj->process_datetime));
            }

            $remainTime = $logpackm->hourperday - $totalTime;
            $targetResult = $logpackm->targetperday;
            $totaloutputpack = $sum;

            if ($remainTime > 0) {
                $totalsum = $sum;
                $ratePerHr = ($targetResult - $totaloutputpack) / $remainTime;
            }

            $loop = 0;
            $loopSum = $totalsum;
            $estimateData = array();
            while ($loop < $remainTime) {
                if (($remainTime - $loop) > 1) {
                    $loop++;
                    $loopSum += $ratePerHr;;
                    $data1x[] = "Hour ".$loop;
                    $data1y[] = 0;
                    $data2y[] = 0;
                    $data3y[] = $ratePerHr;
                    $data4y[] = $loopSum;
                } else {
                    if (($remainTime - $loop) > 0) {
                        $data3y[] = $targetResult - $loopSum;
                        $data1x[] = "Hour " . $remainTime;
                        $data1y[] = 0;
                        $data2y[] = 0;
                        $data4y[] = $targetResult;
                        $loop = $remainTime;
                    }
                }
            }


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
            $graph->xaxis->SetTitleMargin(30);
            $graph->yaxis->SetTitle('ปริมาณแพ็ค');
            $graph->yaxis->SetTitleMargin(3);
            $graph->yaxis->HideZeroLabel();
            $graph->yaxis->SetTitlemargin(-10);
            $graph->yaxis->SetTitleSide(SIDE_RIGHT);
            $graph->yaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);

            $b1plot = new \BarPlot($data1y);
            $b2plot = new \BarPlot($data2y);
            $b3plot = new \BarPlot($data3y);
            $l1plot = new \LinePlot($data4y);




            $gbplot = new \GroupBarPlot(array($b1plot, $b2plot, $b3plot));

            $graph->title->Set($logpackm->method->name . " - " . $logpackm->package->name . " อัตราการแพ็คสะสม " . $selecteddate . " กะ " . $logpackm->shift->name);
            $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);


            $graph->Add($gbplot);
            $graph->AddY(0, $l1plot);
            $graph->ynaxis[0]->SetColor('black');
            $graph->ynaxis[0]->title->Set('Y-title');

            $gbplot->SetColor("white");
            $gbplot->SetFillColor("#22ff11");
            //$gbplot->value->SetFormat( '%01.0f');
            //$gbplot->value->Show();

            $l1plot->SetColor("red");
            $l1plot->SetLegend("Sum");
            //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

            $l1plot->mark->SetType(MARK_X, '', 1.0);
            $l1plot->mark->setColor("red");
            $l1plot->value->SetFormat('%d');
            $l1plot->value->Show();
            $l1plot->value->SetColor('red');

            $l1plot->mark->setFillColor("red");

            $b1plot->value->Show();
            $b1plot->value->SetFormat('%d');
            $b1plot->value->SetColor('black', 'darkred');
            $b1plot->SetLegend("Planning");
            $b2plot->value->Show();
            $b2plot->value->SetFormat('%d');
            $b2plot->value->SetColor('black', 'darkred');
            $b2plot->SetLegend("Actual");
            $b3plot->value->Show();
            $b3plot->value->SetFormat('%d');
            $b3plot->value->SetColor('black', 'darkred');
            $b3plot->SetLegend("Forecast");

            $graph->legend->SetPos(0.4, 0.05, 'left', 'top');
            $graph->legend->SetColumns(4);

            $date = date('ymdHis');

            $filename = "graph/packs/ft_log_pack_" . $current_date . "-" . $logpackm->shift->id . "-" . $logpackm->method_id . "-" . $logpackm->package_id . "-" . $date . ".jpg";

            $filename1 = public_path() . "/graph/packs/ft_log_pack_" . $current_date . "-" . $logpackm->shift->id . "-" . $logpackm->method_id . "-" . $logpackm->package_id . "-" . $date . ".jpg";


            $graph->Stroke($filename1);

            $fileList[$logpackm->method_id][$logpackm->package_id][] = $filename;

            /* $image = file_get_contents( $filename1);
            if ($image !== false) {
                $fileList[$mpObj->method_id][$mpObj->package_id][] = 'data:image/jpg;base64,' . base64_encode($image);
            }*/

            // $fileList[$mpObj->method_id][$mpObj->package_id]['method'] = $methodObj;
            //$fileList[$mpObj->method_id][$mpObj->package_id]['method'] = $packageObj;
        }

        $ftStaff = config('myconfig.emaillist');

        $mailObj['graph'] = $fileList;
        $mailObj['subject'] = " อัตราการแพ็คสะสม " . $selecteddate;

       // Mail::to($ftStaff)->send(new PackRptMail($mailObj));//
    }
}
