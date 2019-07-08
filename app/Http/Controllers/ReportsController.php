<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FtLog;
use App\FtLogPack;
use App\FtLogFreeze;
use App\FtLogPre;

use Maatwebsite\Excel\Facades\Excel;
use App\IqfMapCol;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function daily(){
        return view('reports.daily');
    }

    public function dailypack()
    {
        return view('reports.dailypack');
    }

    public function dailyfreeze()
    {
        return view('reports.dailyfreeze');
    }

    public function dailypreprod()
    {
        return view('reports.dailypreprod');
    }

    public function reportAction(Request $request){
        $requestData = $request->all();
        
        if($requestData['action_type'] == 'daily')
        {
            $data = FtLog::where('process_date', $requestData['process_date'])->orderBy('time_seq')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyexport')->with('data', $data);
                });
            })->export('xlsx');
        }elseif($requestData ['action_type'] == 'range'){
            $data = FtLog::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->orderBy('time_seq')->get();

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
            $data = FtLogPack::where('process_date', $requestData['process_date'])->orderBy( 'time_seq')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypackexport')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FtLogPack::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->orderBy( 'time_seq')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypackexport')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function reportFreezeAction(Request $request)
    {
        $requestData = $request->all();

        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');

        if ($requestData['action_type'] == 'daily') {
            $data = FtLogFreeze::where('process_date', $requestData['process_date'])->orderBy( 'process_time')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data, $iqfmapcollist) {
                $excel->sheet('งานFreeze', function ($sheet) use ($data, $iqfmapcollist) {
                    $sheet->loadView('exports.dailyfreezeexport')->with('data', $data)->with( 'iqfmapcollist', $iqfmapcollist);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FtLogFreeze::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->orderBy( 'process_time')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data, $iqfmapcollist) {
                $excel->sheet('งานFreeze', function ($sheet) use ($data, $iqfmapcollist) {
                    $sheet->loadView('exports.dailyfreezeexport')->with('data', $data)->with('iqfmapcollist', $iqfmapcollist);
                });
            })->export('xlsx');
        }
    }

    public function reportPreprodAction(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = FtLogPre::where('process_date', $requestData['process_date'])->orderBy('process_time')->get();

            $filename = "ft_preprod_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานเตรียมการ', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypreprodexport')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FtLogPre::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->orderBy('process_time')->get();

            $filename = "ft_preprod_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet( 'งานเตรียมการ', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypreprodexport')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function range()
    {
        return view('reports.range');
    }

    public function rangepack()
    {
        return view('reports.rangepack');
    }

    public function rangefreeze()
    {
        return view('reports.rangefreeze');
    }

    public function rangepreprod()
    {
        return view( 'reports.rangepreprod');
    }
}
