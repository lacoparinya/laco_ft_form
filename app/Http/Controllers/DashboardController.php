<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FtLog;
use App\StdProcess;
use App\Product;
use App\Planning;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function home(){
        $current_date = date('Y-m-d');
        $rawdata = DB::table('ft_logs')
                        ->join('products','products.id','=','ft_logs.product_id')
                        ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
                        ->select(DB::raw('ft_logs.process_date,ft_logs.product_id,
                        products.name,
                        sum(ft_logs.input_kg) as suminput,
                        sum(ft_logs.output_kg) as sumoutput,
                        sum(ft_logs.output_kg)*100/sum(ft_logs.input_kg) as yeilds'))
                        ->where('ft_logs.process_date', $current_date)
                        ->groupBy(DB::raw('ft_logs.process_date,ft_logs.product_id,
                        products.name'))
                        ->get();
        return view('dashboards.home', compact('rawdata', 'current_date'));
    }

    public function datechart($selecteddate)
    {
        $current_date = $selecteddate;
        $rawdata = DB::table('ft_logs')
            ->join('products', 'products.id', '=', 'ft_logs.product_id')
            ->select(DB::raw('ft_logs.process_date,ft_logs.product_id,
                        products.name,
                        sum(ft_logs.input_kg) as suminput,
                        sum(ft_logs.output_kg) as sumoutput,
                        sum(ft_logs.output_kg)*100/sum(ft_logs.input_kg) as yeilds'))
            ->where('ft_logs.process_date', $selecteddate)
            ->groupBy(DB::raw('ft_logs.process_date,ft_logs.product_id,
                        products.name'))
            ->get();
        return view('dashboards.chart', compact('rawdata', 'current_date'));
    }

    public function timechart($selecteddate)
    {
        $current_date = $selecteddate;
        $rawdata = DB::table('ft_logs')
            ->join('products', 'products.id', '=', 'ft_logs.product_id')
            ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
            ->select(DB::raw('ft_logs.process_date,
                        ft_logs.process_time,
                        timeslots.name as tname,
                        timeslots.gap as tgap,
                        timeslots.seq as tseq,
                        ft_logs.product_id,
                        products.name,
                        ft_logs.num_classify,
                        ft_logs.input_kg,
                        ft_logs.output_kg'))
            ->where('ft_logs.process_date', $selecteddate)
            ->orderBy(DB::raw('ft_logs.process_date,timeslots.seq'))
            ->get();
        $rawdata2 = DB::table('ft_logs')
            ->join('products', 'products.id', '=', 'ft_logs.product_id')
            ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
            ->select(DB::raw('
                        max(ft_logs.input_kg) as inmax,
                        max(ft_logs.output_kg) as outmax'))
            ->where('ft_logs.process_date', $selecteddate)
            ->get();
        return view('dashboards.charttime', compact('rawdata', 'rawdata2', 'current_date'));
    }

    public function timechartandproduct($selecteddate,$product_id)
    {
        $current_date = $selecteddate;

        $productGroup = Product::findOrFail($product_id);

        $stdprocess = StdProcess::where('product_id', $productGroup->product_group_id)->where('status', true)->first();

       // $stdprocess = StdProcess::where('product_id', $product_id)->first();

        $rawdata = DB::table('ft_logs')
            ->join('products', 'products.id', '=', 'ft_logs.product_id')
            ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
            ->join('shifts', 'shifts.id', '=', 'ft_logs.shift_id')
            ->join('units', 'units.id', '=', 'ft_logs.line_classify_unit')
            ->join('std_processes', 'std_processes.id', '=', 'ft_logs.std_process_id')
            ->select(DB::raw('ft_logs.process_date,
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
                DB::raw( 'max(ft_logs.input_kg) as inmax,
                        max(ft_logs.output_kg) as outmax,
                        max(std_processes.std_rate) as maxstd,
                        max((ft_logs.output_kg/ft_logs.num_classify)/timeslots.gap) as maxstp
                        ')
            )
            ->where('ft_logs.process_date', $selecteddate)
            ->where('ft_logs.product_id', $product_id)
            ->get();

        return view('dashboards.charttimeproduct', compact('rawdata', 'rawdata2', 'current_date', 'stdprocess'));
    }

    public function summary($date){

        $rawdata2 = DB::table('ft_logs')
                ->select(DB::raw('ft_logs.product_id'))
                ->where('ft_logs.process_date', $date)
                ->groupBy(DB::raw('ft_logs.product_id'))
                ->get();

        foreach ( $rawdata2 as $itm) {
            $chk = Planning::where('plan_date', $date)->where( 'product_id', $itm->product_id)->first();

            if (empty($chk)) {
                $tmp['job_id'] = 1;
                $tmp['plan_date'] = $date;
                $tmp[ 'product_id'] = $itm->product_id;
                $tmp['target_man'] = 1;
                $tmp['target_value'] = 1;
                Planning::create($tmp);
            }
        }
/*
        $chk = Planning::where('plan_date',$date)->first();

        if(empty($chk)){
            $tmp['job_id'] = 1;
            $tmp['plan_date'] = $date;
            $tmp['plan_date'] = $date;
            $tmp['target_man'] = 1;
            $tmp['target_value'] = 1;
            Planning::create( $tmp);
        }
*/
        $rawdata = DB::table('ft_logs')
            ->join('plannings', function ($join) {
                $join->on('plannings.job_id', '=', 'ft_logs.job_id')
                ->on( 'plannings.plan_date', '=', 'ft_logs.process_date')
                ->on( 'plannings.product_id', '=', 'ft_logs.product_id');
            })
            ->join('jobs', 'jobs.id', '=', 'ft_logs.job_id')
            ->join('products', 'products.id', '=', 'ft_logs.product_id')
            ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
            ->select(
                DB::raw( 'jobs.name,
                ft_logs.product_id,
                        products.name as productname,
                        ft_logs.process_date,
                        floor(sum(ft_logs.num_classify)/sum(timeslots.gap)) as man_act,
                        plannings.id,
                        plannings.target_man as man_target,
                        floor(sum(ft_logs.output_kg)/sum(timeslots.gap)) as value_act,
                        floor(plannings.target_value*(sum(ft_logs.num_classify)/sum(timeslots.gap) / plannings.target_man)) as value_cal,
                        plannings.target_value as value_target,
                        sum(ft_logs.output_kg) as sum_act,
                        round(sum(timeslots.gap)*(plannings.target_value*(sum(ft_logs.num_classify)/sum(timeslots.gap) / plannings.target_man)),0) as sum_cal,
                        plannings.target_value*sum(timeslots.gap) as sum_target,
                        round(sum(timeslots.gap)*(plannings.target_value*(sum(ft_logs.num_classify)/sum(timeslots.gap) / plannings.target_man)),0) - 
                        plannings.target_value*sum(timeslots.gap) as gap,
                        plannings.note,
                        sum(timeslots.gap) as sum_hr')
            )
            ->where('ft_logs.process_date', $date)
            ->groupBy(DB::raw( 'jobs.name,ft_logs.product_id,products.name,ft_logs.process_date,plannings.target_man,plannings.id,plannings.target_value,plannings.note'))
            ->get();
        return view('dashboards.summary', compact('rawdata'));
    }

    public function main()
    {
        $current_date = date('Y-m-d');
        $rawdata = DB::table('ft_logs')
            ->join('products', 'products.id', '=', 'ft_logs.product_id')
            ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
            ->select(DB::raw('ft_logs.process_date,ft_logs.product_id,
                        products.name,
                        sum(ft_logs.input_kg) as suminput,
                        sum(ft_logs.output_kg) as sumoutput,
                        sum(ft_logs.output_kg)*100/sum(ft_logs.input_kg) as yeilds'))
            ->groupBy(DB::raw('ft_logs.process_date,ft_logs.product_id,
                        products.name'))
            ->orderBy(DB::raw('ft_logs.process_date DESC,
                        products.name'))
            ->get();
        return view('dashboards.main', compact('rawdata', 'current_date'));
    }
}
