<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PlanRptM;
use App\PlanRptD;
use App\PlanGroup;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use App\Mail\DeliveryPlanMail;

class GenDailyPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:dailyplan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Daily Plan per Day';

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
        $monthlist = array(
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec'
        );
        $filename = array();

        $current = PlanRptM::where('month', date('m'))
            ->where('year', date('Y'))
            ->where('status', 'Active')
            ->first();
        $prevmonth = date('m')-1;
        $prevyear = date('Y');
        if(date('m') == 1){
            $prevmonth = 12;
            $prevyear = date('Y')-1;
        }
        
        $prev = PlanRptM::where('month', $prevmonth)
            ->where('year', $prevyear)
            ->where('status', 'Active')
            ->first();

        require_once app_path() . '/jpgraph/jpgraph.php';
        require_once app_path() . '/jpgraph/jpgraph_bar.php';


        $plangrouplist = PlanGroup::where('status', 'Active')->pluck('name', 'id');

        $data = array();
        $data2 = array();
        $data2x = array();
        $dataprev2 = array();
        $datacurrent2 = array();
        $allshipments = 0;
        foreach ($current->planrptds as $planrptdObj) {
            $data2x[] = "บรรจุได้ (".$planrptdObj->plangroup->name.")";
            $datacurrent2[]  = $planrptdObj->num_packed;
            $allshipments += $planrptdObj->num_packed;
            if(isset($data['current']['num_delivery_plan'])){
                $data['current']['num_delivery_plan'] +=  $planrptdObj->num_delivery_plan;
            }else{
                $data['current']['num_delivery_plan'] =  $planrptdObj->num_delivery_plan;    
            }
            if (isset($data['current']['num_confirm'])) {
                $data['current']['num_confirm'] +=  $planrptdObj->num_confirm;
            } else {
                $data['current']['num_confirm'] =  $planrptdObj->num_confirm;
            }
            if (isset($data['current']['num_packed'])) {
                $data['current']['num_packed'] +=  $planrptdObj->num_packed;
            } else {
                $data['current']['num_packed'] =  $planrptdObj->num_packed;
            }
            if (isset($data['current']['num_wait'])) {
                $data['current']['num_wait'] +=  $planrptdObj->num_packed;
            } else {
                $data['current']['num_wait'] =  $planrptdObj->num_wait;
            }
        }
        foreach ($prev->planrptds as $planrptdObj) {
            //$data2['prev'][$planrptdObj->plangroup->name] = $planrptdObj->num_delivery_plan;
            $dataprev2[]  = $planrptdObj->num_packed;
            if (isset($data['prev']['num_delivery_plan'])) {
                $data['prev']['num_delivery_plan'] +=  $planrptdObj->num_delivery_plan;
            } else {
                $data['prev']['num_delivery_plan'] =  $planrptdObj->num_delivery_plan;
            }
            if (isset($data['prev']['num_confirm'])) {
                $data['prev']['num_confirm'] +=  $planrptdObj->num_confirm;
            } else {
                $data['prev']['num_confirm'] =  $planrptdObj->num_confirm;
            }
            if (isset($data['prev']['num_packed'])) {
                $data['prev']['num_packed'] +=  $planrptdObj->num_packed;
            } else {
                $data['prev']['num_packed'] =  $planrptdObj->num_packed;
            }
            if (isset($data['prev']['num_wait'])) {
                $data['prev']['num_wait'] +=  $planrptdObj->num_packed;
            } else {
                $data['prev']['num_wait'] =  $planrptdObj->num_wait;
            }
        }

       // dd($data);
        $data1x = array('Delivery plan','บรรจุได้', "ค้างบรรจุ", "สินค้าบรรจุเสร็จรอส่งมอบ" );

        $dataprev = array($data['prev']['num_delivery_plan'], $data['prev']['num_packed'], $data['prev']['num_delivery_plan'] - $data['prev']['num_packed'], $data['prev']['num_wait']);
        $datacurrent = array($data['current']['num_delivery_plan'], $data['current']['num_packed'], $data['current']['num_delivery_plan'] - $data['current']['num_packed'], $data['current']['num_wait']);
        
        $graph = new \Graph(900, 400);
        $graph->SetScale("intlin");

        $theme_class = new \UniversalTheme;
        $graph->SetTheme($theme_class);
        $graph->xaxis->SetFont(FF_ANGSA, FS_BOLD, 18);

        //$graph->yaxis->SetTickPositions(array(0, 30, 60, 90, 120, 150), array(15, 45, 75, 105, 135));
        $graph->SetBox(false);

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($data1x);
        $graph->xaxis->SetLabelAlign('left', 'center');
        $graph->xaxis->title->SetFont(FF_BROWA, FS_BOLD, 14);
        $graph->yaxis->SetColor("#000000");
        $graph->yaxis->HideLine(true);
        $graph->yaxis->HideTicks(false, false);

        // Create the bar plots
        $b1plot = new \BarPlot($dataprev);
        $b2plot = new \BarPlot($datacurrent);

        // Create the grouped bar plot
        $gbplot = new \GroupBarPlot(array($b1plot, $b2plot));
        // ...and add it to the graPH
        $graph->Add($gbplot);


        $b1plot->SetColor("white");
        $b1plot->SetFillColor("#4169E1");
        $b1plot->SetLegend($monthlist[$prevmonth]. ' '. $prevyear);
        $b1plot->value->SetFormat('%d');
        $b1plot->value->SetColor("#000000");
        $b1plot->value->Show();

        $b2plot->SetColor("white");
        $b2plot->SetFillColor("#ff6347");
        $b2plot->SetLegend($monthlist[date('m')] . ' ' . date('Y'));
        $b2plot->value->SetFormat('%d');
        $b2plot->value->SetColor("#000000");
        
        $b2plot->value->Show();

        $graph->ygrid->Show(false);

        $graph->legend->SetFrameWeight(1);
        $graph->legend->SetColumns(2);
        $graph->legend->SetColor('#4E4E4E', '#00A78A');
        $graph->legend->SetPos(0.8, 0.05, 'center', 'top');
       
        $graph->SetBackgroundImage( public_path() . "/images/plandt.png", BGIMG_FILLFRAME);
        $graph->SetMargin(30, 10, 40, 20);

        $path = public_path() . '/graph/'.date('Y'). "/" . date('m') . '/dplan';
        if (!File::exists($path)) {
            File::makeDirectory($path,  0777, true, true);
        }

        $date = date('ymdHis');

        $filename['all']['link'] = "graph/".date('Y'). "/" . date('m') . "/dplan/ft_plan_rpt_" .  $date . ".jpg";

        $filename['all']['path'] = public_path() . "/graph/" . date('Y') . "/" . date('m') . "/dplan/ft_plan_rpt_" .  $date . ".jpg";
        $graph->Stroke($filename['all']['path']);


        $graph2 = new \Graph(900, 400);
        $graph2->SetScale("intlin");

        $theme_class = new \UniversalTheme;
        $graph2->SetTheme($theme_class);
        

        //$graph->yaxis->SetTickPositions(array(0, 30, 60, 90, 120, 150), array(15, 45, 75, 105, 135));
        $graph2->SetBox(false);

        $graph2->ygrid->SetFill(false);
        $graph2->xaxis->SetTickLabels($data2x);
        $graph2->xaxis->SetFont(FF_ANGSA, FS_BOLD, 18);
        $graph2->xaxis->SetLabelAlign('left', 'center');
        $graph2->xaxis->title->SetFont(FF_ANGSA, FS_BOLD, 14);
        $graph2->yaxis->SetColor("#000000");
        $graph2->yaxis->HideLine(true);
        $graph2->yaxis->HideTicks(false, false);

        // Create the bar plots
        $b1plot2 = new \BarPlot($dataprev2);
        $b2plot2 = new \BarPlot($datacurrent2);

        // Create the grouped bar plot
        $gbplot2 = new \GroupBarPlot(array($b1plot2, $b2plot2));
        // ...and add it to the graPH
        $graph2->Add($gbplot2);

        $b1plot2->SetColor("white");
        $b1plot2->SetFillColor("#4169E1");
        $b1plot2->SetLegend($monthlist[$prevmonth] . ' ' . $prevyear);
        $b1plot2->value->SetFormat('%d');
        $b1plot2->value->SetColor("#000000");
        $b1plot2->value->Show();

        $b2plot2->SetColor("white");
        $b2plot2->SetFillColor("#ff6347");
        $b2plot2->SetLegend($monthlist[date('m')] . ' ' . date('Y'));
        $b2plot2->value->SetFormat('%d');
        $b2plot2->value->SetColor("#000000");
        $b2plot2->value->Show();

        $graph2->ygrid->Show(false);

        $graph2->legend->SetFrameWeight(1);
        $graph2->legend->SetColumns(2);
        $graph2->legend->SetColor('#4E4E4E', '#00A78A');
        $graph2->legend->SetPos(0.8, 0.05, 'center', 'top');

        $graph2->title->Set($allshipments." Shipments");
        $graph2->SetMargin(30, 10, 40, 20);

        $filename['region']['link'] = "graph/" . date('Y') . "/" . date('m') . "/dplan/ft_plan_rpt_rg_" .  $date . ".jpg";

        $filename['region']['path'] = public_path() . "/graph/" . date('Y') . "/" . date('m') . "/dplan/ft_plan_rpt_rg_" .  $date . ".jpg";
        $graph2->Stroke($filename['region']['path']);

        $ftStaff = config('myconfig.emaillist');

        $maindata['prev'] = $dataprev;
        $maindata['current'] = $datacurrent;
        $maindata['rawprev'] = $prev;
        $maindata['rawcurrent'] = $current;

        $mailObj['graph'] = $filename;
        $mailObj['data'] = $maindata;
        $mailObj['subject'] = " Update จำนวน Shipment ประจำวันที่  " . date('d/M/Y');

        $testemail = array(
            'WT' => 'Wichchan@Lannaagro.com',
            'PC' => 'Pimchanok@Lannaagro.com',
            'JPT' => 'Jittranuch@Lannaagro.com',
            'PKP' => 'parinya.k@lannaagro.com',
        );

        Mail::to($testemail)->send(new DeliveryPlanMail($mailObj));
    }
}