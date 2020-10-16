<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\LogPrepareM;
use App\Shift;
use App\PreProd;
use App\Mail\FtPre2RptMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GenDailyPre2Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailypre2report {diff} {shift_id} {plan_flag}';

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
        ini_set('memory_limit', '256M');
        $diff = $this->argument('diff');
        $shiftId = $this->argument('shift_id');
        $plan_flag = $this->argument('plan_flag');

        $selecteddate = date('Y-m-d');
        if ($diff == 'Y') {
            $selecteddate = date('Y-m-d', strtotime("-1 days"));
        }

        $datapl = array();
        if ($plan_flag == 'Y') {
            $datapl = DB::table('log_prepare_ms')
            ->leftjoin('log_prepare_ds', 'log_prepare_ms.id', '=', 'log_prepare_ds.log_prepare_m_id')
            ->leftjoin('pre_prods', 'pre_prods.id', '=', 'log_prepare_ms.pre_prod_id')
            ->leftjoin('shifts', 'shifts.id', '=', 'log_prepare_ds.shift_id')
            ->select(DB::raw("log_prepare_ms.process_date,
shifts.name as shiftname,
log_prepare_ms.staff_target,
log_prepare_ms.staff_operate,
log_prepare_ms.staff_pf,
log_prepare_ms.staff_pk,
log_prepare_ms.staff_pst,
(ISNULL(log_prepare_ms.staff_pk,0)+ISNULL(log_prepare_ms.staff_pf,0)+ISNULL(log_prepare_ms.staff_pst,0)) 
- ISNULL(log_prepare_ms.staff_target,0)
 as 'staff_diff',   
pre_prods.name as productname,
log_prepare_ms.targetperhr * sum(log_prepare_ds.workhours) as 'Plan',
CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END as 'Actual',
log_prepare_ms.targetperhr * sum(log_prepare_ds.workhours) - CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END as 'diff',
log_prepare_ms.note as Remark"))
            ->where('log_prepare_ms.process_date', $selecteddate)
                ->where('log_prepare_ds.shift_id', $shiftId)
                ->groupBy(DB::raw('log_prepare_ms.process_date,
shifts.name,
log_prepare_ms.staff_target,
log_prepare_ms.staff_operate,
log_prepare_ms.staff_pf,
log_prepare_ms.staff_pk,
log_prepare_ms.staff_pst,
pre_prods.name,
log_prepare_ms.targetperhr,
log_prepare_ms.note'))
                ->get();
        }

        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        $current_date = $selecteddate;

        $fileList = array();

        $resultList = array();

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
            $totalAct = 0;
            $totalPlan = 0;
            $resultar = array();
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
                $totalPlan += $item->targets;
                if ($item->input > 0){
                    $data2y[] = $item->input;
                    $totalAct += $item->input;
                }else{
                    $data2y[] = $item->output;
                    $totalAct += $item->output;
                }
                $data3y[] = 0;
                if($item->input_sum > 0) {
                    $data4y[] = $item->input_sum;
                }else{
                    $data4y[] = $item->output_sum;
                }
                if(!empty($item->problem)){
                    $resultar['problem'][] = date('H:i', strtotime($item->process_datetime)) . " - " . $item->problem;
                }
                if (!empty($item->img_path)) {
                    $resultar['problem_img'][] = $item->img_path;
                }
            }

            foreach ($estimateData as $item2){
                $data1x[] = "ชม.ที่". $item2['time'];
                $data1y[] = 0;
                $data2y[] = 0;
                $data3y[] = $item2['realrate'];
                $data4y[] = $item2['realtotal'];
            }

            if ($totalPlan == $totalAct) {
                $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:yellow;">ผลิตได้ตามป้าหมาย</span>';
            } elseif ($totalPlan > $totalAct) {
                $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:red;">ผลิตได้ต่ำกว่าเป้าหมาย ' . round(((($totalPlan - $totalAct) * 100) / $totalPlan), 2) . "%</span>";
            } else {
                $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:green;">ผลิตได้มากกว่าเป้าหมาย ' . round(((($totalAct - $totalPlan) * 100) / $totalPlan), 2) . "%</span>";
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

            $gbplot = new \GroupBarPlot(array($b1plot,$b2plot,$b3plot));

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
            $b3plot->SetLegend("Forecast");
            $b2plot->value->Show();
            $b2plot->value->SetFormat('%d');
            $b2plot->value->SetColor('black', 'darkred');
            $b2plot->SetLegend("Input or Output");
            $b1plot->value->Show();
            $b1plot->value->SetFormat('%d');
            $b1plot->value->SetColor('black', 'darkred');
            $b1plot->SetLegend("Target");

            

            $graph->legend->SetPos(0.4, 0.05, 'left', 'top');
            $graph->legend->SetColumns(4);

            $date = date('ymdHis');

            $path = public_path() . '/graph/' . date('Ym') . '/prepares';
            if (!File::exists($path)) {
                File::makeDirectory($path,  0777, true, true);
            }

            $filename = 'graph/' . date('Ym'). "/prepares/ft_log_pre_" . $current_date . "-" . $logpreparem->preprod->name . "-" . $logpreparem->id . "-" . $date . ".jpg";

            $filename1 = $path . "/ft_log_pre_" . $current_date . "-" . $logpreparem->preprod->name . "-" . $logpreparem->id . "-" . $date . ".jpg";


            $graph->Stroke($filename1);

            $fileList[] = $filename;
            $resultList[] = $resultar;
        }

        if(!empty( $fileList)){
            $ftStaff = config('myconfig.emaillist');

            $mailObj['graph'] = $fileList;
            $mailObj['result'] = $resultList;
            $mailObj['datapl'] = $datapl;
            $mailObj['subject'] = "อัตราการเตรียมการสะสม " . $selecteddate;

            Mail::to($ftStaff)->send(new FtPre2RptMail($mailObj));
        }
    }
}
