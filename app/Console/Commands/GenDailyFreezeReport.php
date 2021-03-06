<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\FtLogFreeze;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\FreezeRptMail;

class GenDailyFreezeReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailyfreezereport {diff}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Daily Freeze Report';

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
        //$selecteddate = '2019-06-17';
        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        $current_date = $selecteddate;

        $fileList = array();

        $loopData = FtLogFreeze::where('process_date',$current_date)
            ->select('master_code')
            ->groupBy('master_code')
            ->get();

        //echo "Number OF Loop" . $loopData->count() . "\n\r";

        foreach ( $loopData as $loopObj) {
            //echo "Test".$loopObj->master_code."\n\r";
            $rawdata = DB::table('ft_log_freezes')
                ->join('iqf_jobs', 'iqf_jobs.id', '=', 'ft_log_freezes.iqf_job_id')
                ->select(DB::raw('ft_log_freezes.process_date, ft_log_freezes.process_time, ft_log_freezes.output_sum, ft_log_freezes.output_all_sum, ft_log_freezes.current_RM, iqf_jobs.name as iqf_job_name'))
                ->where('ft_log_freezes.master_code', $loopObj->master_code)
                ->orderBy(DB::raw('process_date, process_time'))
                ->get();

            $data1y = array();
            $data2y = array();
            $data3y = array();
            $data1x = array();
            $sumAll = 0;
            $sumRemain = $rawdata[0]->current_RM + $rawdata[0]->output_sum;
            $productName = $rawdata[0]->iqf_job_name;
            foreach ( $rawdata as $rptObj) {
                $sumAll += $rptObj->output_sum;
                $sumRemain -= $rptObj->output_sum;
                $data1x[] = substr($rptObj->process_time,0,5);
                $data1y[] = $rptObj->output_sum;
                $data2y[] = $sumAll;
                $data3y[] = $sumRemain;
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
            $graph->xaxis->SetTitle('????????????', 'center');
            $graph->xaxis->SetTitleMargin(30);
            $graph->yaxis->SetTitle('??????????????????');
            $graph->yaxis->SetTitleMargin(3);
            $graph->yaxis->HideZeroLabel();
            $graph->yaxis->SetTitlemargin(-10);
            $graph->yaxis->SetTitleSide(SIDE_RIGHT);
            $graph->yaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);

            $b1plot = new \BarPlot($data1y);
            $l1plot = new \LinePlot($data2y);
            $l2plot = new \LinePlot($data3y);




           // $gbplot = new \GroupBarPlot(array($b1plot, $b2plot));

            $graph->title->Set( $productName . " - ???????????????????????????????????????????????? " . $selecteddate );
            $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);


            $graph->Add($b1plot);
            $graph->AddY(0, $l1plot);
            $graph->AddY(0, $l2plot);
            $graph->ynaxis[0]->SetColor('black');
            $graph->ynaxis[0]->title->Set('Y-title');

            
            //$gbplot->value->SetFormat( '%01.0f');
            //$gbplot->value->Show();

            $l1plot->SetColor("red");
            //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

            $l1plot->mark->SetType(MARK_X, '', 1.0);
            $l1plot->mark->setColor("red");
            $l1plot->value->SetFormat('%d');
            $l1plot->value->Show();
            $l1plot->value->SetColor('red');

            $l1plot->mark->setFillColor("red");
            $l1plot->SetLegend("Freeze Summary");

            $l2plot->SetColor( "green");
            //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

            $l2plot->mark->SetType(MARK_X, '', 1.0);
            $l2plot->mark->setColor("green");
            $l1plot->value->SetFormat('%d');
            $l2plot->value->Show();
            $l2plot->value->SetColor( 'green');

            $l2plot->mark->setFillColor( "green");
            $l2plot->SetLegend("RM Remain");

            $b1plot->value->Show();
            $b1plot->SetColor("#61a9f3");
            $b1plot->SetFillColor( "#61a9f3");
            $b1plot->value->SetFormat('%d');
            $b1plot->value->SetColor('black', 'darkred');
            $b1plot->SetLegend("Freeze");

            $graph->legend->SetPos(0.6, 0.05, 'left', 'top');

            $date = date('ymdHis');

            $filename = "graph/freezes/ft_log_freeze_" . $current_date . "-" . md5($loopObj->master_code) . "-" . $date . ".jpg";

            $filename1 = public_path() . "/graph/freezes/ft_log_freeze_" . $current_date . "-" . md5($loopObj->master_code) . "-" . $date . ".jpg";


            $graph->Stroke($filename1);

            $fileList[] = $filename;

        }

        if(!empty($fileList)){
            $ftStaff = config('myconfig.emaillist');

            $mailObj['graph'] = $fileList;
            $mailObj['subject'] = " ???????????????????????????????????????????????? " . $selecteddate;

            Mail::to($ftStaff)->send(new FreezeRptMail($mailObj));
        }

        


        

    }
}
