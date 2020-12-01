<?php

namespace App\Console\Commands;

use App\LogPackM;

use App\Mail\Pack3RptMail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class GenDailyPack2Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailypack2report {diff} {shift_id} {plan_flag}';

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
        ini_set('memory_limit', '256M');

        $diff = $this->argument('diff');
        $shiftId = $this->argument('shift_id');
        $plan_flag = $this->argument('plan_flag');

        $selecteddate = date('Y-m-d');
        if ($diff == 'Y') {
            $selecteddate = date('Y-m-d', strtotime("-1 days"));
        }

        $plan_flag = "Y";

        //PL Part
        $datapl = array();
        if ($plan_flag == 'Y') {
            $datapl = DB::table('log_pack_ms')
            ->leftjoin('log_pack_ds', 'log_pack_ms.id', '=', 'log_pack_ds.log_pack_m_id')
            ->leftjoin('methods', 'methods.id', '=', 'log_pack_ms.method_id')
            ->leftjoin('shifts', 'shifts.id', '=', 'log_pack_ms.shift_id')
                ->leftjoin('packages', 'packages.id', '=', 'log_pack_ms.package_id')
                ->leftjoin('orders', 'orders.id', '=', 'log_pack_ms.order_id')
                ->leftjoin('std_packs', 'std_packs.id', '=', 'log_pack_ms.std_pack_id')
            ->select(DB::raw("log_pack_ms.process_date,
    shifts.name as 'shiftname',
    methods.name as 'methodname',
    log_pack_ms.staff_target as 'staff_target',
    log_pack_ms.staff_operate as 'staff_operate',
    log_pack_ms.staff_pk  as 'staff_pk',
    log_pack_ms.staff_pf  as 'staff_pf',
    log_pack_ms.staff_pst  as 'staff_pst',
    (ISNULL(log_pack_ms.staff_pk,0)+ISNULL(log_pack_ms.staff_pf,0)+ISNULL(log_pack_ms.staff_pst,0)) 
    - ISNULL(log_pack_ms.staff_target,0)
    as 'staff_diff',
    packages.name as 'packagename',
    '-' as 'unit',
    log_pack_ms.targetperday as 'Plan',
    sum(log_pack_ds.[output_pack]) as 'Actual',
    sum(log_pack_ds.[output_pack]) - log_pack_ms.targetperday as 'diff',
    orders.order_no as 'Shipment',
    log_pack_ms.note as 'Remark'"))
            ->where('log_pack_ms.process_date', $selecteddate)
            ->where('log_pack_ms.shift_id', $shiftId)
            ->groupBy(DB::raw('log_pack_ms.process_date,
    shifts.name,methods.name,packages.name,orders.order_no,
    log_pack_ms.targetperday,packages.kgsperpack,log_pack_ms.note,
    log_pack_ms.staff_target,log_pack_ms.staff_operate,
    log_pack_ms.staff_pf,log_pack_ms.staff_pk,log_pack_ms.staff_pst'))
            ->get();
        }

        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        $current_date = $selecteddate;

        $fileList = array();

        $resultList = array();

        $loopData = LogPackM::where('process_date', $current_date)
            ->where('shift_id', $shiftId)
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
            $totalsum = 0;
            $ratePerHr = 0;
            $totalAct = 0;
            $totalPlan = 0;
            $resultar = array();

            if($logpackm->logpackd->count() > 0){
                foreach ($logpackm->logpackd()->orderBy('process_datetime')->get() as $valueObj) {
                    $totalTime += $valueObj->workhours;
                    $sum += $valueObj->output_pack;
                    $data1y[] = $logpackm->stdpack->packperhour * $valueObj->workhours;
                    $data2y[] = $valueObj->output_pack;
                    $data3y[] = 0;
                    $data4y[] = $sum;
                    $data1x[] = date('H:i',strtotime($valueObj->process_datetime));

                    $totalPlan += $logpackm->stdpack->packperhour * $valueObj->workhours;
                    $totalAct += $valueObj->output_pack;

                    if(!empty($valueObj->problem)){
                        $resultar['problem'][] = date('H:i', strtotime($valueObj->process_datetime)) . " - " . $valueObj->problem;
                    }

                    if (!empty($valueObj->img_path)) {
                        $resultar['problem_img'][] = $valueObj->img_path;
                    }
                    
                }

                if ($totalPlan <= $logpackm->targetperday) {
                    if ($totalPlan == $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:yellow;">ผลิตได้ตามป้าหมาย</span>';
                    } elseif ($totalPlan > $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:red;">ผลิตได้ต่ำกว่าเป้าหมาย ' . round(((($totalPlan - $totalAct) * 100) / $totalPlan), 2) . "%</span>";
                    } else {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:green;">ผลิตได้มากกว่าเป้าหมาย ' . round(((($totalAct - $totalPlan) * 100) / $totalPlan), 2) . "%</span>";
                    }
                }else{
                    if ($logpackm->targetperday == $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:yellow;">ผลิตได้ตามป้าหมาย</span>';
                    } elseif ($logpackm->targetperday > $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:red;">ผลิตได้ต่ำกว่าเป้าหมาย ' . round(((($logpackm->targetperday - $totalAct) * 100) / $logpackm->targetperday), 2) . "%</span>";
                    } else {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:green;">ผลิตได้มากกว่าเป้าหมาย ' . round(((($totalAct - $logpackm->targetperday) * 100) / $logpackm->targetperday), 2) . "%</span>";
                    }
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
                if($totalsum > 0 && $ratePerHr > 0) {
                    while ($loop < $remainTime) {
                        if (($remainTime - $loop) > 1) {
                            $loop++;
                            $loopSum += $ratePerHr;
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

                $l1plot->SetColor("red");
                $l1plot->SetLegend("Sum");

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

                $path = public_path() . '/graph/' . date('Ym') . '/packs';
                if (!File::exists($path)) {
                    File::makeDirectory($path,  0777, true, true);
                }

                $filename = 'graph/' . date('Ym') . "/packs/ft_log_pack_" . $current_date . "-" . $logpackm->shift->id . "-" . $logpackm->method_id . "-" . $logpackm->package_id . "-" . $date . ".jpg";

                $filename1 = $path. "/ft_log_pack_" . $current_date . "-" . $logpackm->shift->id . "-" . $logpackm->method_id . "-" . $logpackm->package_id . "-" . $date . ".jpg";


                $graph->Stroke($filename1);

                $fileList[$logpackm->method_id][$logpackm->package_id][] = $filename;

                $resultList[$logpackm->method_id][$logpackm->package_id][] = $resultar;

            }
        }

        if (!empty($fileList)) {
            $ftStaff = config('myconfig.emaillist');

            $mailObj['graph'] = $fileList;
            $mailObj['result'] = $resultList;
            $mailObj['datapl'] = $datapl;

            //var_dump($datapl);
            $mailObj['subject'] = "อัตราการแพ็คสะสม " . $selecteddate;

            Mail::to($ftStaff)->send(new Pack3RptMail($mailObj));
        }
    }
}
