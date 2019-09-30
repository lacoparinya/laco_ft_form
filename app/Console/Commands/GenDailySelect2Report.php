<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\LogSelectM;

class GenDailySelect2Report extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailyselectreport {shift_id} {diff}';

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
    {;
        $fileList2 = array();

        $shiftObj = Shift::findOrFail($shiftId);

        $loopData = LogSelectM::where('process_date', $current_date)->select('id')->toArray();

        foreach ($loopData as $valueLoop) {

            $logselectm = LogSelectM::findOrFail($valueLoop['id']);

            //var_dump($rawdata);
            $data1y = array();
            $data2y = array();
            $data3y = array();
            $data1x = array();
            $sum = 0;
            foreach ($rawdata as $valueObj) {
                $sum += $valueObj->output_kg;
                $data1y[] = $valueObj->output_kg;
                $data2y[] = $sum;
                $data1x[] = $valueObj->tname;
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
                $b2plot = new \LinePlot($data2y);


                $graph->title->Set($productGroup->name . " อัตราการคัดสะสม " . $selecteddate . " กะ " . $shiftObj->name);
                $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);

                $graph->Add($b1plot);
                $graph->AddY(0, $b2plot);
                $graph->ynaxis[0]->SetColor('black');
                $graph->ynaxis[0]->title->Set('Y-title');

                $b1plot->SetColor("white");
                $b1plot->SetFillColor("#22ff11");
                $b1plot->value->SetFormat('%d');
                $b1plot->value->Show();

                //$b2plot->SetBarCenter();
                $b2plot->SetColor("red");
                //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

                $b2plot->mark->SetType(MARK_X, '', 1.0);
                $b2plot->mark->setColor("red");
                $b2plot->value->SetFormat('%d');
                $b2plot->value->Show();
                $b2plot->value->SetColor('red');

                $b2plot->mark->setFillColor("red");

                $date = date('ymdHis');

                $filename = "graph/selects/ft_log_select_" . $current_date . "-" . $shiftId . "-" . $product_id . "-" . $date . ".jpg";

                $filename1 = public_path() . "/graph/selects/ft_log_select_" . $current_date . "-" . $shiftId . "-" . $product_id . "-" . $date . ".jpg";


                $graph->Stroke($filename1);

                //$image1 = file_get_contents($filename1);
                //if ($image1 !== false) {
                //    $fileList[] = 'data:image/jpg;base64,' . base64_encode( $image1);
                //}

                $fileList[] = $filename;
            }

            $rawdata = DB::table('ft_logs')
                ->join('products', 'products.id', '=', 'ft_logs.product_id')
                ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
                ->join('shifts', 'shifts.id', '=', 'ft_logs.shift_id')
                ->join('units', 'units.id', '=', 'ft_logs.line_classify_unit')
                ->join('std_processes', 'std_processes.id', '=', 'ft_logs.std_process_id')
                ->select(
                    DB::raw('ft_logs.process_date,
                        ft_logs.process_time,
                        shifts.name as shname,
                        timeslots.name as tname,
                        timeslots.gap as tgap,
                        timeslots.seq as tseq,
                        ft_logs.product_id,
                        products.name,
                        ft_logs.num_classify,
                        ft_logs.input_kg,
                        ft_logs.output_kg,
                        ft_logs.sum_kg,
                        ft_logs.yeild_percent,
                        ft_logs.num_pk,
                        ft_logs.num_pf,
                        ft_logs.num_pst,
                        ft_logs.line_a,
                        ft_logs.line_b,
                        ft_logs.line_classify,
                        units.name as line_unit,
                        ft_logs.grade,
                        ft_logs.ref_note,
                        std_processes.std_rate
                        ')
                )
                ->where('ft_logs.process_date', $selecteddate)
                ->where('ft_logs.product_id', $product_id)
                ->orderBy(DB::raw('ft_logs.process_date,timeslots.seq'))
                ->get();

            $rawdata2 = DB::table('ft_logs')
                ->join('products', 'products.id', '=', 'ft_logs.product_id')
                ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
                ->join('shifts', 'shifts.id', '=', 'ft_logs.shift_id')
                ->join('units', 'units.id', '=', 'ft_logs.line_classify_unit')
                ->join('std_processes', 'std_processes.id', '=', 'ft_logs.std_process_id')
                ->select(
                    DB::raw('max(ft_logs.input_kg) as inmax,
                        max(ft_logs.output_kg) as outmax,
                        max(std_processes.std_rate) as maxstd,
                        max((ft_logs.output_kg/ft_logs.num_classify)/timeslots.gap) as maxstp
                        ')
                )
                ->where('ft_logs.process_date', $selecteddate)
                ->where('ft_logs.product_id', $product_id)
                ->get();

            //var_dump($rawdata);
            $data1y = array();
            $data2y = array();
            $data1x = array();
            $sum = 0;
            foreach ($rawdata as $valueObj) {
                $sum += $valueObj->output_kg;
                $data1y[] = $valueObj->output_kg;
                $data2y[] = $sum;
                $data1x[] = $valueObj->tname;
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
                $b2plot = new \LinePlot($data2y);


                $graph->title->Set($productGroup->name . " อัตราการคัดสะสมทั้งหมด " . $selecteddate);
                $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);

                $graph->Add($b1plot);
                $graph->AddY(0, $b2plot);
                $graph->ynaxis[0]->SetColor('black');
                $graph->ynaxis[0]->title->Set('Y-title');

                $b1plot->SetColor("white");
                $b1plot->SetFillColor("#22ff11");
                $b1plot->value->SetFormat('%d');
                $b1plot->value->Show();

                //$b2plot->SetBarCenter();
                $b2plot->SetColor("red");
                //$b2plot->legend->SetFont(FF_FONT2, FS_NORMAL);

                $b2plot->mark->SetType(MARK_X, '', 1.0);
                $b2plot->mark->setColor("red");
                $b2plot->value->SetFormat('%d');
                $b2plot->value->Show();
                $b2plot->value->SetColor('red');

                $b2plot->mark->setFillColor("red");

                $date = date('ymdHis');

                $filename2 = "graph/selects/ft_log_select_all_" . $current_date . "-" . $product_id . "-" . $date . ".jpg";

                $filename11 = public_path() . "/graph/selects/ft_log_select_all_" . $current_date . "-" . $product_id . "-" . $date . ".jpg";


                $graph->Stroke($filename11);

                //$image2 = file_get_contents($filename11);
                //if ( $image2 !== false) {
                //   $fileList2[] = 'data:image/jpg;base64,' . base64_encode( $image2);
                //}

                $fileList2[] = $filename2;
            }
        }

        $ftStaff = config('myconfig.emaillist');

        $mailObj['graph'] = $fileList;
        $mailObj['graph2'] = $fileList2;
        $mailObj['shift'] = $shiftObj;
        $mailObj['subject'] = " อัตราการคัดสะสม " . $selecteddate;

        Mail::to($ftStaff)->send(new FtDataEmail($mailObj));
    }
}
