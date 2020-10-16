<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\FreezeM;
use App\FreezeD;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\Freeze2RptMail;
use Illuminate\Support\Facades\File;


class GenDailyFreeze2Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailyfreeze2report {diff} {shift_id} {plan_flag}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New Ver Generate Daily Freeze Report';

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
        //$selecteddate = '2020-10-07';
        $loopData = FreezeM::where('process_date', $selecteddate)->get();
        $current_date = $selecteddate;
        if ($diff == 'Y') {
            $selecteddate2 = date('Y-m-d', strtotime("-1 days"));
            $loopData = FreezeM::whereBetween('process_date', [$selecteddate2, $selecteddate])->get();
            $current_date = $selecteddate2." - ".$selecteddate;
        }

        $datapl = array();
        if ($plan_flag == 'Y') {
            if ($diff == 'Y') {

                $selecteddate2 = date('Y-m-d', strtotime("-1 days"));
                    $datapl = DB::table('freeze_ms')
                    ->leftjoin('freeze_ds', 'freeze_ms.id', '=', 'freeze_ds.freeze_m_id')
                    ->leftjoin('iqf_jobs', 'iqf_jobs.id', '=', 'freeze_ms.iqf_job_id')
                    ->leftjoin('shifts', 'shifts.id', '=', 'freeze_ds.shift_id')
                    ->select(DB::raw("freeze_ms.process_date,
                    shifts.name as shiftname,
                    freeze_ms.staff_target,
                    freeze_ms.staff_operate,
                    freeze_ms.staff_pf,
                    freeze_ms.staff_pk,
                    freeze_ms.staff_pst,
                    (ISNULL(freeze_ms.staff_pk,0)+ISNULL(freeze_ms.staff_pf,0)+ISNULL(freeze_ms.staff_pst,0)) 
                    - ISNULL(freeze_ms.staff_target,0)
                     as 'staff_diff',   
                    iqf_jobs.name as productname,
                    freeze_ms.targets * sum(freeze_ds.workhour)  as 'Plan',
                    sum(freeze_ds.output_sum) as 'Actual',
                    (freeze_ms.targets * sum(freeze_ds.workhour)) - sum(freeze_ds.output_sum) as 'diff',
                    freeze_ms.note as Remark"))
                                ->whereBetween('freeze_ms.process_date', [$selecteddate2, $selecteddate])
                                    ->where('freeze_ds.shift_id', $shiftId)
                                    ->groupBy(DB::raw('freeze_ms.process_date,
                    shifts.name,
                    freeze_ms.staff_target,
                    freeze_ms.staff_operate,
                    freeze_ms.staff_pf,
                    freeze_ms.staff_pk,
                    freeze_ms.staff_pst,
                    iqf_jobs.name,
                    freeze_ms.targets,
                    freeze_ms.note'))
                    ->get();
            }else{
                $datapl = DB::table('freeze_ms')
                ->leftjoin('freeze_ds', 'freeze_ms.id', '=', 'freeze_ds.freeze_m_id')
                ->leftjoin('iqf_jobs', 'iqf_jobs.id', '=', 'freeze_ms.iqf_job_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'freeze_ds.shift_id')
                ->select(DB::raw("freeze_ms.process_date,
shifts.name as shiftname,
freeze_ms.staff_target,
freeze_ms.staff_operate,
freeze_ms.staff_pf,
freeze_ms.staff_pk,
freeze_ms.staff_pst, 
(ISNULL(freeze_ms.staff_pk,0)+ISNULL(freeze_ms.staff_pf,0)+ISNULL(freeze_ms.staff_pst,0)) 
- ISNULL(freeze_ms.staff_target,0)
 as 'staff_diff',   
iqf_jobs.name as productname,
freeze_ms.targets * sum(freeze_ds.workhour)  as 'Plan',
sum(freeze_ds.output_sum) as 'Actual',
(freeze_ms.targets * sum(freeze_ds.workhour)) - sum(freeze_ds.output_sum) as 'diff',
freeze_ms.note as Remark"))
                ->where('freeze_ms.process_date', $selecteddate)
                ->where('freeze_ds.shift_id', $shiftId)
                ->groupBy(DB::raw('freeze_ms.process_date,
shifts.name,
freeze_ms.staff_target,
freeze_ms.staff_operate,
freeze_ms.staff_pf,
freeze_ms.staff_pk,
freeze_ms.staff_pst,
iqf_jobs.name,
freeze_ms.targets,
freeze_ms.note'))
                ->get();
            }
        }
        
        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        

        $fileList = array();
        $resultList = array();

        foreach ($loopData as $loopObj) {
            if($loopObj->freezed->count() > 0){
            $rawdata = $loopObj
                ->freezed()
                ->orderBy('process_datetime','asc')
                ->get();

            $data1y = array();
            $data2y = array();
            $data3y = array();
            $data4y = array();
            $data1x = array();
            $sumAll = 0;
            $sumRemain = 0;
            $totalAct = 0;
            $totalPlan = 0;
            $resultar = array();

            $rateperhour = $loopObj->targets;

            if(!empty($rawdata)){
                $sumRemain = $rawdata[0]->current_RM + $rawdata[0]->output_sum;
            }
            $productName = $loopObj->iqfjob->name;
            foreach ($rawdata as $rptObj) {
                $sumAll += $rptObj->output_sum;
                $sumRemain -= $rptObj->output_sum;
                $data1x[] =  \Carbon\Carbon::parse($rptObj->process_datetime)->format('H:i')."\n".$rptObj->iqfjob->name;
                $data1y[] = $rptObj->output_sum;
                $data2y[] = $sumAll;
                $data3y[] = $sumRemain;
                $data4y[] = $rptObj->workhour * $rateperhour;

                $totalAct += $rptObj->output_sum;
                $totalPlan += $rptObj->workhour * $rateperhour;

                if (!empty($rptObj->problem)) {
                    $resultar['problem'][] = \Carbon\Carbon::parse($rptObj->process_datetime)->format('H:i') . " - " . $rptObj->problem;
                }
                if (!empty($rptObj->img_path)) {
                    $resultar['problem_img'][] = $rptObj->img_path;
                }
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
            $graph->xaxis->SetTitleMargin(30);
            $graph->yaxis->SetTitle('ปริมาณ');
            $graph->yaxis->SetTitleMargin(3);
            $graph->yaxis->HideZeroLabel();
            $graph->yaxis->SetTitlemargin(-10);
            $graph->yaxis->SetTitleSide(SIDE_RIGHT);
            $graph->yaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);

            $b1plot = new \BarPlot($data1y);
            $b2plot = new \BarPlot($data4y);

            $l1plot = new \LinePlot($data2y);
            $l2plot = new \LinePlot($data3y);

            $gbplot = new \GroupBarPlot(array($b2plot, $b1plot));

            $graph->title->Set($productName . " - อัตราการฟรีสสะสม " . $current_date);
            $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);


            $graph->Add($gbplot);
            $graph->AddY(0, $l1plot);
            $graph->AddY(0, $l2plot);
            $graph->ynaxis[0]->SetColor('black');
            $graph->ynaxis[0]->title->Set('Y-title');

            $gbplot->SetColor("white");
            $gbplot->SetFillColor("#22ff11");

            $l1plot->SetColor("red");

            $l1plot->mark->SetType(MARK_X, '', 1.0);
            $l1plot->mark->setColor("red");
            $l1plot->value->SetFormat('%d');
            $l1plot->value->Show();
            $l1plot->value->SetColor('red');

            $l1plot->mark->setFillColor("red");
            $l1plot->SetLegend("Freeze Summary");

            $l2plot->SetColor("green");

            $l2plot->mark->SetType(MARK_X, '', 1.0);
            $l2plot->mark->setColor("green");
            $l1plot->value->SetFormat('%d');
            $l2plot->value->Show();
            $l2plot->value->SetColor('green');

            $l2plot->mark->setFillColor("green");
            $l2plot->SetLegend("RM Remain");

            $b2plot->value->Show();
            $b2plot->value->SetFormat('%d');
            $b2plot->value->SetColor('black', 'darkred');
            $b2plot->SetLegend("Planning");

            $b1plot->value->Show();
            //$b1plot->SetColor("#61a9f3");
            //$b1plot->SetFillColor("#61a9f3");
            $b1plot->value->SetFormat('%d');
            $b1plot->value->SetColor('black', 'darkred');
            $b1plot->SetLegend("Freeze");

            $graph->legend->SetPos(0.6, 0.05, 'left', 'top');
            $graph->legend->SetColumns(4);

            $date = date('ymdHis');

            $path = public_path() . '/graph/'. date('Ym'). '/freezes';
            if (!File::exists($path)) {
                File::makeDirectory($path,  0777, true, true);
            }

            $filename = "graph/".date('Ym')."/freezes/ft_log_freeze_" . $current_date . "-" . md5($loopObj->id) . "-" . $date . ".jpg";

            $filename1 = $path . "/ft_log_freeze_" . $current_date . "-" . md5($loopObj->id) . "-" . $date . ".jpg";


            $graph->Stroke($filename1);

            $fileList[] = $filename;
                $resultList[] = $resultar;
        }
        }

        if (!empty($fileList)) {
            $ftStaff = config('myconfig.emaillist');

            $mailObj['graph'] = $fileList;
            $mailObj['result'] = $resultList;
            $mailObj['datapl'] = $datapl;
            $mailObj['subject'] = "อัตราการฟรีสสะสม " . $current_date;

            Mail::to($ftStaff)->send(new Freeze2RptMail($mailObj));
        }
    }
}
