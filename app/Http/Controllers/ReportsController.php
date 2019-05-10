<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FtLog;
use App\FtLogPack;

use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function daily(){
        return view('reports.daily');
    }

    public function dailypack()
    {
        return view('reports.dailypack');
    }

    public function reportAction(Request $request){
        $requestData = $request->all();
        
        if($requestData['action_type'] == 'daily')
        {
            $data = FtLog::where('process_date', $requestData['process_date'])->orderBy('timeslot_id')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyexport')->with('data', $data);
                });
            })->export('xlsx');
        }elseif($requestData ['action_type'] == 'range'){
            $data = FtLog::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('timeslot_id')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyexport')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function reportPackAction(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = FtLogPack::where('process_date', $requestData['process_date'])->orderBy('timeslot_id')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypackexport')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FtLogPack::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('timeslot_id')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypackexport')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function rangepack()
    {
        return view('reports.rangepack');
    }
}
