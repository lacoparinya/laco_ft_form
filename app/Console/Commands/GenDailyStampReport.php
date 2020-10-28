<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Mail\StampRptMail;
use App\StampM;

class GenDailyStampReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailystampreport {diff} {shift_id} {plan_flag}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Daily Stamp Report';

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

        //$selecteddate = '2020-10-23';

        $plan_flag = "Y";

        //PL Part
        $datapl = array();
        if ($plan_flag == 'Y') {
            $datapl = DB::table('stamp_ms')
                ->leftjoin('stamp_ds', 'stamp_ms.id', '=', 'stamp_ds.stamp_m_id')
                ->leftjoin('stamp_machines', 'stamp_machines.id', '=', 'stamp_ms.stamp_machine_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'stamp_ms.shift_id')
                ->leftjoin('mat_packs', 'mat_packs.id', '=', 'stamp_ms.mat_pack_id')
                ->select(DB::raw("stamp_ms.process_date,
            shifts.name as shiftname,
    stamp_machines.name as 'stampmachinename',
    mat_packs.matname as 'matname',
    mat_packs.packname as 'packname',
    stamp_ms.staff_target as 'staff_target',
    stamp_ms.staff_operate as 'staff_operate',
    stamp_ms.staff_actual  as 'staff_actual',
    ISNULL(stamp_ms.staff_actual,0)
    - ISNULL(stamp_ms.staff_target,0)
    as 'staff_diff',
    stamp_ms.targetperjob,
    sum(stamp_ds.output) as Actual,
    sum(stamp_ds.output) - stamp_ms.targetperjob as diff,
    stamp_ms.note as 'Remark'"))
                ->where('stamp_ms.process_date', $selecteddate)
                ->where('stamp_ms.shift_id', $shiftId)
                ->groupBy(DB::raw('stamp_ms.process_date,
            shifts.name,
    stamp_machines.name ,
    mat_packs.matname ,
    mat_packs.packname,
    stamp_ms.staff_target ,
    stamp_ms.staff_operate ,
    stamp_ms.staff_actual ,
    stamp_ms.targetperjob,
    stamp_ms.note'))
                ->get();
        }

        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        $current_date = $selecteddate;

        $fileList = array();

        $resultList = array();

        $loopData = StampM::where('process_date', $current_date)
            ->get();

        foreach ($loopData as $mpObj) {
            $stampm = StampM::findOrFail($mpObj->id);

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

            if ($stampm->stampd->count() > 0) {
                foreach ($stampm->stampd()->orderBy('process_datetime')->get() as $valueObj) {
                    $totalTime += $valueObj->workhours;
                    $sum += $valueObj->output;
                    $data1y[] = $stampm->rateperhr * $valueObj->workhours;
                    $data2y[] = $valueObj->output;
                    $data3y[] = 0;
                    $data4y[] = $sum;
                    $data1x[] = date('H:i', strtotime($valueObj->process_datetime));

                    $totalPlan += $stampm->rateperhr * $valueObj->workhours;
                    $totalAct += $valueObj->output;

                    if (!empty($valueObj->problem)) {
                        $resultar['problem'][] = date('H:i', strtotime($valueObj->process_datetime)) . " - " . $valueObj->problem;
                    }

                    if (!empty($valueObj->img_path)) {
                        $resultar['problem_img'][] = $valueObj->img_path;
                    }
                }

                if ($totalPlan <= $stampm->targetperjob) {
                    if ($totalPlan == $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:yellow;">ผลิตได้ตามป้าหมาย</span>';
                    } elseif ($totalPlan > $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:red;">ผลิตได้ต่ำกว่าเป้าหมาย ' . round(((($totalPlan - $totalAct) * 100) / $totalPlan), 2) . "%</span>";
                    } else {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:green;">ผลิตได้มากกว่าเป้าหมาย ' . round(((($totalAct - $totalPlan) * 100) / $totalPlan), 2) . "%</span>";
                    }
                } else {
                    if ($stampm->targetperjob == $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:yellow;">ผลิตได้ตามป้าหมาย</span>';
                    } elseif ($stampm->targetperjob > $totalAct) {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:red;">ผลิตได้ต่ำกว่าเป้าหมาย ' . round(((($stampm->targetperjob - $totalAct) * 100) / $stampm->targetperjob), 2) . "%</span>";
                    } else {
                        $resultar['txt'] = 'สรุปได้ว่า <span style="background-color:green;">ผลิตได้มากกว่าเป้าหมาย ' . round(((($totalAct - $stampm->targetperjob) * 100) / $stampm->targetperjob), 2) . "%</span>";
                    }
                }

                $remainTime = ceil($stampm->targetperjob / $stampm->rateperhr) - $totalTime;
                $targetResult = $stampm->targetperjob;
                $totaloutputpack = $sum;

                if ($remainTime > 0) {
                    $totalsum = $sum;
                    $ratePerHr = ($targetResult - $totaloutputpack) / $remainTime;
                }

                $loop = 0;
                $loopSum = $totalsum;
                if ($totalsum > 0 && $ratePerHr > 0) {
                    while ($loop < $remainTime) {
                        if (($remainTime - $loop) > 1) {
                            $loop++;
                            $loopSum += $ratePerHr;
                            $data1x[] = "Hour " . $loop;
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

                $graph->title->Set($stampm->stampmachine->name . " - " . $stampm->matpack->matname . " อัตราการStampสะสม " . $selecteddate . " กะ " . $stampm->shift->name);
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

                $path = public_path() . '/graph/' . date('Ym') . '/stamps';
                if (!File::exists($path)) {
                    File::makeDirectory($path,  0777, true, true);
                }

                $filename = 'graph/' . date('Ym') . "/stamps/ft_stamp_" . $current_date . "-" . $stampm->shift->id . "-" . $stampm->stamp_machine_id . "-" . $stampm->mat_pack_id . "-" . $date . ".jpg";

                $filename1 = $path . "/ft_stamp_" . $current_date . "-" . $stampm->shift->id . "-" . $stampm->stamp_machine_id . "-" . $stampm->mat_pack_id . "-" . $date . ".jpg";


                $graph->Stroke($filename1);

                $fileList[$stampm->stamp_machine_id][$stampm->matpack_id][] = $filename;

                $resultList[$stampm->stamp_machine_id][$stampm->matpack_id][] = $resultar;
            }
        }

        if (!empty($fileList)) {
            $ftStaff = config('myconfig.emaillist');

            $mailObj['graph'] = $fileList;
            $mailObj['result'] = $resultList;
            $mailObj['datapl'] = $datapl;

            //var_dump($datapl);
            $mailObj['subject'] = "อัตราการStampสะสม " . $selecteddate;

            Mail::to($ftStaff)->send(new StampRptMail($mailObj));
        }
    }
}
