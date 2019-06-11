<?php

namespace App\Console\Commands;

use App\Shift;
use App\FtLogPack;
use App\Method;
use App\Package;
use App\Mail\PackRptMail;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class GenDailyPackReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailypackreport {shift_id} {diff}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Daily Pack Report';

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
        $shiftId = $this->argument('shift_id');
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

        $shiftObj = Shift::findOrFail($shiftId);

        $loopData = FtLogPack::where('process_date', $current_date)
        ->where( 'shift_id', $shiftId)
        ->select( 'method_id', 'package_id')
        ->groupBy( 'method_id', 'package_id')
        ->orderBy('method_id','asc')
        ->orderBy('package_id','asc')
        ->get();

        foreach ( $loopData as $mpObj) {
            $methodObj = Method::findOrFail($mpObj->method_id);
            $packageObj = Package::findOrFail($mpObj->package_id);

            $rawdata = DB::table('ft_log_packs')
                ->join( 'timeslots', 'timeslots.id', '=', 'ft_log_packs.timeslot_id')
                ->join( 'std_packs', 'std_packs.id', '=', 'ft_log_packs.std_pack_id')
                ->select(
                    DB::raw( 'timeslots.name as tname, ft_log_packs.output_kg as actual, std_packs.packperhour * ft_log_packs.workhours as planning')
                )
                ->where( 'ft_log_packs.process_date', $selecteddate)
                ->where( 'ft_log_packs.method_id', $mpObj->method_id)
                ->where( 'ft_log_packs.package_id', $mpObj->package_id)
                ->where( 'ft_log_packs.shift_id', $shiftId)
                ->orderBy(DB::raw('timeslots.seq'))
                ->get();

            $data1y = array();
            $data2y = array();
            $data3y = array();
            $data1x = array();
            $sum = 0;
            foreach ($rawdata as $valueObj) {
                $sum += $valueObj->actual;
                $data1y[] = $valueObj->planning;
                $data2y[] = $valueObj->actual;
                $data3y[] = $sum;
                $data1x[] = $valueObj->tname;
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
            $l1plot = new \LinePlot($data3y);

            


            $gbplot = new \GroupBarPlot(array( $b1plot, $b2plot));

            $graph->title->Set( $methodObj->name . " - ". $packageObj->name . " อัตราการแพ็คสะสม " . $selecteddate . " กะ " . $shiftObj->name);
            $graph->title->SetFont(FF_CORDIA, FS_BOLD, 14);
            

            $graph->Add( $gbplot);
            $graph->AddY(0, $l1plot);
            $graph->ynaxis[0]->SetColor('black');
            $graph->ynaxis[0]->title->Set('Y-title');

            $gbplot->SetColor("white");
            $gbplot->SetFillColor("#22ff11");
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

            $b1plot->value->Show();
            $b1plot->value->SetFormat('%d');
            $b1plot->value->SetColor('black', 'darkred');
            $b1plot->SetLegend("Planning");
            $b2plot->value->Show();
            $b2plot->value->SetFormat('%d');
            $b2plot->value->SetColor('black', 'darkred');
            $b2plot->SetLegend("Actual");

            $graph->legend->SetPos(0.8, 0.05, 'left', 'top');

            $date = date('ymdHis');

            $filename = "graph/ft_log_pack_" . $current_date . "-" . $shiftId . "-" . $mpObj->method_id . "-" . $mpObj->package_id . "-" . $date . ".jpg";

            $filename1 = public_path() . "/graph/ft_log_pack_" . $current_date . "-" . $shiftId . "-" . $mpObj->method_id . "-" . $mpObj->package_id . "-" . $date . ".jpg";


            $graph->Stroke($filename1);

            //$fileList[$mpObj->method_id][$mpObj->package_id][] = $filename;

            $image = file_get_contents( $filename1);
            if ($image !== false) {
                $fileList[$mpObj->method_id][$mpObj->package_id][] = 'data:image/jpg;base64,' . base64_encode($image);
            }

           // $fileList[$mpObj->method_id][$mpObj->package_id]['method'] = $methodObj;
            //$fileList[$mpObj->method_id][$mpObj->package_id]['method'] = $packageObj;
        }

        $ftStaff = config( 'myconfig.emailpacklist');

        $mailObj['graph'] = $fileList;
        $mailObj['shift'] = $shiftObj;
        $mailObj['subject'] = " อัตราการแพ็คสะสม " . $selecteddate;

        Mail::to($ftStaff)->send(new PackRptMail($mailObj));

    }
}
