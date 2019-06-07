<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\jpgraph\jpgraph;
use App\jpgraph\jpgraph_bar;
use App\jpgraph\jpgraph_line;
use App\Product;
use App\StdProcess;
use Illuminate\Support\Facades\DB;
use App\FtLog;
use App\Mail\FtDataEmail;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function test(){

        // Create the Pie Graph.

        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        




        $data1y = array(115, 130, 135, 130, 110, 130, 130, 150, 130, 130, 150, 120);
        //bar2
        $data2y = array(180, 200, 220, 190, 170, 195, 190, 210, 200, 205, 195, 150);
        //bar3
        $data3y = array(220, 230, 210, 175, 185, 195, 200, 230, 200, 195, 180, 130);
        $data4y = array(40, 45, 70, 80, 50, 75, 70, 70, 80, 75, 80, 50);
        //line1
        $data6y = array(50, 58, 60, 58, 53, 58, 57, 60, 58, 58, 57, 50);
        foreach ($data6y as &$y) {
            $y -= 10;
        }

        // Create the graph. These two calls are always required
        $graph = new \Graph(750, 320, 'auto');
        $graph->SetScale("textlin");
        $graph->SetY2Scale("lin", 0, 90);
        $graph->SetY2OrderBack(false);

        $theme_class = new \UniversalTheme;
        $graph->SetTheme($theme_class);

        $graph->SetMargin(40, 20, 46, 80);

        $graph->yaxis->SetTickPositions(array(0, 50, 100, 150, 200, 250, 300, 350), array(25, 75, 125, 175, 275, 325));
        $graph->y2axis->SetTickPositions(array(30, 40, 50, 60, 70, 80, 90));

        $months = $gDateLocale->GetShortMonth();
        $months = array_merge(array_slice($months, 3, 9), array_slice($months, 0, 3));
        $graph->SetBox(false);

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels(array('A', 'B', 'C', 'D'));
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
        // Setup month as labels on the X-axis
        $graph->xaxis->SetTickLabels($months);

        // Create the bar plots
        $b1plot = new \BarPlot($data1y);
        $b2plot = new \BarPlot($data2y);

        $b3plot = new \BarPlot($data3y);
        $b4plot = new \BarPlot($data4y);

        $lplot = new \LinePlot($data6y);

        // Create the grouped bar plot
        $gbbplot = new \AccBarPlot(array($b3plot));
        $gbplot = new \GroupBarPlot(array($b2plot, $gbbplot));

        // ...and add it to the graPH
        $graph->Add($gbplot);
        $graph->AddY2($lplot);

        $b1plot->SetColor("#0000CD");
        $b1plot->SetFillColor("#0000CD");
        $b1plot->SetLegend("Cliants");

        $b2plot->SetColor("#B0C4DE");
        $b2plot->SetFillColor("#B0C4DE");
        $b2plot->SetLegend("Machines");

        $b3plot->SetColor("#8B008B");
        $b3plot->SetFillColor("#8B008B");
        $b3plot->SetLegend("First Track");

        $b4plot->SetColor("#DA70D6");
        $b4plot->SetFillColor("#DA70D6");
        $b4plot->SetLegend("All");


        $lplot->SetBarCenter();
        $lplot->SetColor("yellow");
        $lplot->SetLegend("Houses");
        $lplot->mark->SetType(MARK_X, '', 1.0);
        $lplot->mark->SetWeight(2);
        $lplot->mark->SetWidth(8);
        $lplot->mark->setColor("yellow");
        $lplot->mark->setFillColor("yellow");

       // $graph->legend->SetFrameWeight(1);
       // $graph->legend->SetColumns(6);
     //   $graph->legend->SetColor('#4E4E4E', '#00A78A');

        $band = new \PlotBand(VERTICAL, BAND_RDIAG, 11, "max", 'khaki4');
        $band->ShowFrame(true);
        $band->SetOrder(DEPTH_BACK);
        $graph->Add($band);

        $graph->title->Set("Combineed Line and Bar plots");

        // Display the graph
        //$graph->Stroke('D:\test.jpg');
        $graph->Stroke();
    }

    public function gengraph( $selecteddate, $product_id){
        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';
        require_once app_path() . '/jpgraph/jpgraph_line.php';

        $current_date = $selecteddate;

        $fileList = array();

        $loopData = FtLog::where( 'process_date', $current_date)->select('product_id')->groupBy( 'product_id')->get()->toArray();

        //var_dump($loopData);

        foreach ( $loopData as $valueLoop) {

            $product_id = $valueLoop[ 'product_id'];

        $productGroup = Product::findOrFail($product_id);

        $stdprocess = StdProcess::where('product_id', $productGroup->product_group_id)->where('status', true)->first();

        // $stdprocess = StdProcess::where('product_id', $product_id)->first();



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
        foreach ( $rawdata as $valueObj) {
            $sum += $valueObj->output_kg;
            $data1y[] = $valueObj->output_kg;
            $data2y[] = $sum;
            $data1x[] = $valueObj->tname;
        }
        //var_dump($data1y);
        //var_dump($data2y);
        //var_dump($data1x);
        //$data1y = Hash::extract( $rawdata)

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
        $graph->xaxis->SetLabelSide( SIDE_BOTTOM);
        $graph->xaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);
        $graph->xaxis->SetTitle( 'เวลา', 'center');
        $graph->xaxis->SetTitleMargin(30);
        $graph->yaxis->SetTitle('ปริมาณ');
        $graph->yaxis->SetTitleMargin(3);
        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->SetTitlemargin(-10);
        $graph->yaxis->SetTitleSide( SIDE_RIGHT); 
        $graph->yaxis->title->SetFont(FF_CORDIA, FS_NORMAL, 14);
      //  $graph->yaxis->HideLine(false);
        //$graph->yaxis->HideTicks(false, false);

        $b1plot = new \BarPlot($data1y);
        $b2plot = new \LinePlot($data2y);


        $graph->title->Set($productGroup->name . " อัตราการผลิตสะสม " . $selecteddate);
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
            // $gbplot = new \GroupBarPlot(array($b1plot));

            // ...and add it to the graPH


            // $b1plot->SetBarCenter();

            $date = date('ymdHis');

        $filename = "graph/ft_log_select_" . $current_date."-".$product_id."-". $date.".jpg";

        $graph->Stroke($filename);

            $fileList[] = $filename;

        }

        $ftStaff = config('myconfig.emaillist');

        $mailObj['graph'] = $fileList;
        $mailObj['subject'] = " อัตราการผลิตสะสม " . $selecteddate;

        Mail::to( $ftStaff)->send(new FtDataEmail($mailObj));
    
    }
}
