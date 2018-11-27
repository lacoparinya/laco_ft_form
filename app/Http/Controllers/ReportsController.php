<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FtLog;

use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function daily(){
        return view('reports.daily');
    }

    public function reportAction(Request $request){
        $requestData = $request->all();
        
        if($requestData['action_type'] == 'daily')
        {
            $data = FtLog::where('process_date', $requestData['process_date'])->orderBy('process_time')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyexport')->with('data', $data);
                });
            })->export('xlsx');
        }elseif($requestData ['action_type'] == 'range'){
            $data = FtLog::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_time')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyexport')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function range()
    {
        return view('reports.range');
    }
}
