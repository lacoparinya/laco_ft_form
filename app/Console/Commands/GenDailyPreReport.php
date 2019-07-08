<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\FtLogPre;
use App\Shift;
use App\PreProd;
use App\Mail\FtPreRptMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class GenDailyPreReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailyprereport {diff}';

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

        $loopData = FtLogPre::where('process_date', $current_date)
            ->select('shift_id', 'pre_prod_id')
            ->groupBy('shift_id', 'pre_prod_id')
            ->orderBy( 'shift_id', 'asc')
            ->orderBy( 'pre_prod_id', 'asc')
            ->get();

        foreach ($loopData as $mpObj) {
            //echo $mpObj->shift_id." - ". $mpObj->pre_prod_id;
            $shiftObj = Shift::findOrFail( $mpObj->shift_id);
            $preProdObj = PreProd::findOrFail($mpObj->pre_prod_id);

            $rawdata = DB::table('ft_log_pres')
                ->select(DB::raw('ft_log_pres.process_date, ft_log_pres.process_time, ft_log_pres.output, ft_log_pres.output_sum'))
                ->where('ft_log_pres.process_date', $current_date)
                ->where('ft_log_pres.pre_prod_id', $mpObj->pre_prod_id)
                ->where('ft_log_pres.shift_id', $mpObj->shift_id)
                ->orderBy(DB::raw('process_date, process_time'))
                ->get();

            $data1y = array();
            $data2y = array();
            $data1x = array();
            foreach ($rawdata as $rptObj) {
                $data1x[] = date('H:i', strtotime( $rptObj->process_time));
                $data1y[] = $rptObj->output;
                $data2y[] = $rptObj->output_sum;
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
            $l1plot = new \LinePlot($data2y);

            $graph->title->Set($preProdObj->name . " - อัตราการเตรียมการ กะ " . $shiftObj->name . " วันที่ " . $selecteddate);
            $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);


            $graph->Add($b1plot);
            $graph->AddY(0, $l1plot);
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
            $l1plot->SetLegend("Prepare Summary");

            $b1plot->value->Show();
            $b1plot->SetColor("#61a9f3");
            $b1plot->SetFillColor("#61a9f3");
            $b1plot->value->SetFormat('%d');
            $b1plot->value->SetColor('black', 'darkred');
            $b1plot->SetLegend( "Prepare");

            $graph->legend->SetPos(0.6, 0.05, 'left', 'top');

            $date = date('ymdHis');

            $filename = "graph/prepare/ft_log_freeze_" . $current_date . "-" . $preProdObj->name . "-" . $shiftObj->name . "-" . $date . ".jpg";

            $filename1 = public_path() . "/graph/prepare/ft_log_freeze_" . $current_date . "-" . $preProdObj->name . "-" . $shiftObj->name . "-" . $date . ".jpg";


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
