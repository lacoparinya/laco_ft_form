<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\FtLog;


class PlannersController extends Controller
{
    public function __construct()
    {

    }

    public function dashboard(){
        
        $dataselect = DB::table('ft_logs')
            ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
            ->join('std_processes', 'std_processes.id', '=', 'ft_logs.std_process_id')
            ->select(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8) as process_month,
avg(ft_logs.num_classify) as avgperson,
avg((ft_logs.output_kg/ft_logs.num_classify)/timeslots.gap) as avgkgpersonhr,
sum(ft_logs.input_kg) as suminkg, 
sum(ft_logs.output_kg)  as sumoutkg, 
sum(ft_logs.output_kg)*100/sum(ft_logs.input_kg) as productivity'))
            ->groupBy(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8)'))
            ->orderBy(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8) '),'asc')
            ->get();
        
        return view('planners.dashboard',compact('dataselect'));
    }

    public function selectbyyearmonth($yearmonth,$type='product'){

        if($type=='product'){

        $dataselect = DB::table('ft_logs')
            ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
            ->join('std_processes', 'std_processes.id', '=', 'ft_logs.std_process_id')
            ->join('products', 'products.id', '=', 'ft_logs.product_id')
            ->select(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8) as process_month,
            products.name as productname,
avg(ft_logs.num_classify) as avgperson,
avg((ft_logs.output_kg/ft_logs.num_classify)/timeslots.gap) as avgkgpersonhr,
sum(ft_logs.input_kg) as suminkg, 
sum(ft_logs.output_kg)  as sumoutkg, 
sum(ft_logs.output_kg)*100/sum(ft_logs.input_kg) as productivity'))
            ->where(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8)'),'=', $yearmonth)
            ->groupBy(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8),products.name'))
            ->orderBy(DB::raw('products.name'))
            ->get();
        }elseif($type == 'date'){
            $dataselect = DB::table('ft_logs')
                ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
                ->join('std_processes', 'std_processes.id', '=', 'ft_logs.std_process_id')
                ->select(DB::raw('ft_logs.process_date,
avg(ft_logs.num_classify) as avgperson,
avg((ft_logs.output_kg/ft_logs.num_classify)/timeslots.gap) as avgkgpersonhr,
sum(ft_logs.input_kg) as suminkg, 
sum(ft_logs.output_kg)  as sumoutkg, 
sum(ft_logs.output_kg)*100/sum(ft_logs.input_kg) as productivity'))
                ->where(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8)'), '=', $yearmonth)
                ->groupBy(DB::raw('ft_logs.process_date'))
                ->orderBy(DB::raw('ft_logs.process_date'))
                ->get();
        } elseif ($type == 'shift') {
            $dataselect = DB::table('ft_logs')
                ->join('timeslots', 'timeslots.id', '=', 'ft_logs.timeslot_id')
                ->join('std_processes', 'std_processes.id', '=', 'ft_logs.std_process_id')
                ->join('shifts', 'shifts.id', '=', 'ft_logs.shift_id')
                ->select(DB::raw('shifts.name as shiftname,
avg(ft_logs.num_classify) as avgperson,
avg((ft_logs.output_kg/ft_logs.num_classify)/timeslots.gap) as avgkgpersonhr,
sum(ft_logs.input_kg) as suminkg, 
sum(ft_logs.output_kg)  as sumoutkg, 
sum(ft_logs.output_kg)*100/sum(ft_logs.input_kg) as productivity'))
                ->where(DB::raw('SUBSTRING( cast(ft_logs.process_date as varchar(12)),0,8)'), '=', $yearmonth)
                ->groupBy(DB::raw('shifts.name'))
                ->orderBy(DB::raw('shifts.name'))
                ->get();
        }
        return view('planners.selectbyyearmonth', compact('dataselect','type'));
    }
}
