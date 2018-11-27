<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FtLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function home(){
        $current_date = date('Y-m-d');
        $rawdata = DB::table('ft_logs')
                        ->join('products','products.id','=','ft_logs.product_id')
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
}
