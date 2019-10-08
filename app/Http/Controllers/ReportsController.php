<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FtLog;
use App\FtLogPack;
use App\FtLogFreeze;
use App\FtLogPre;
use App\FreezeM;
use App\LogPrepareM;
use App\LogPackM;
use App\LogSelectM;

use Illuminate\Support\Facades\DB;
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

    public function dailypack2()
    {
        return view('reports.dailypack2');
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

    public function reportPack2Action(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = LogPackM::where('process_date', $requestData['process_date'])->orderBy('process_date')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypackexport2')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = LogPackM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypackexport2')->with('data', $data);
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
            $data = FtLogPre::where('ft_log_pres.process_date', $requestData['process_date'])
                ->join('pre_prods', 'pre_prods.id', '=', 'ft_log_pres.pre_prod_id')
                ->orderBy('ft_log_pres.process_date')
                ->orderBy('pre_prods.name')
                ->orderBy('ft_log_pres.process_time')->get();

            $filename = "ft_preprod_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานเตรียมการ', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypreprodexport')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FtLogPre::whereBetween('ft_log_pres.process_date', [$requestData['from_date'], $requestData['to_date']])
                ->join('pre_prods', 'pre_prods.id', '=', 'ft_log_pres.pre_prod_id')
                ->orderBy('ft_log_pres.process_date')
                ->orderBy('pre_prods.name')
                ->orderBy('ft_log_pres.process_time')->get();

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

    public function rangepack2()
    {
        return view('reports.rangepack2');
    }

    public function rangefreeze()
    {
        return view('reports.rangefreeze');
    }

    public function rangepreprod()
    {
        return view( 'reports.rangepreprod');
    }

    public function orderreport(){

        $perPage = 25;

        $data = DB::table('ft_log_packs')
            ->join('orders', 'orders.id','=', 'ft_log_packs.order_id')
            ->join('packages', 'packages.id', '=', 'ft_log_packs.package_id')
            ->select(DB::raw('orders.order_no, packages.name as packagename, sum([ft_log_packs].output_pack) as sumbox, sum([ft_log_packs].output_kg) as sumkg'))
            ->groupBy(DB::raw('orders.order_no, packages.name'))
            ->orderBy('orders.order_no','asc')
            ->orderBy('packages.name', 'asc')
            ->paginate($perPage);

        return view('reports.orderreport',compact('data'));
    }

    public function packOrderAction(Request $request){

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $data = DB::table('ft_log_packs')
                ->join('orders', 'orders.id', '=', 'ft_log_packs.order_id')
                ->join('packages', 'packages.id', '=', 'ft_log_packs.package_id')
                ->select(DB::raw('orders.order_no, packages.name as packagename, sum([ft_log_packs].output_pack) as sumbox, sum([ft_log_packs].output_kg) as sumkg'))
                ->where('orders.order_no','like','%'.$keyword.'%')
                ->groupBy(DB::raw('orders.order_no, packages.name'))
                ->orderBy('orders.order_no', 'asc')
                ->orderBy('packages.name', 'asc')
                ->paginate($perPage);
        }else{

            $data = DB::table('ft_log_packs')
                ->join('orders', 'orders.id', '=', 'ft_log_packs.order_id')
                ->join('packages', 'packages.id', '=', 'ft_log_packs.package_id')
                ->select(DB::raw('orders.order_no, packages.name as packagename, sum([ft_log_packs].output_pack) as sumbox, sum([ft_log_packs].output_kg) as sumkg'))
                ->groupBy(DB::raw('orders.order_no, packages.name'))
                ->orderBy('orders.order_no', 'asc')
                ->orderBy('packages.name', 'asc')
                ->paginate($perPage);
        }

        return view('reports.orderreport', compact('data'));
    }


    public function reportFreeze2Action(Request $request)
    {
        $requestData = $request->all();

        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');

        if ($requestData['action_type'] == 'daily') {
            $data = FreezeM::where('process_date', $requestData['process_date'])->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data, $iqfmapcollist) {
                $excel->sheet('งานFreeze', function ($sheet) use ($data, $iqfmapcollist) {
                    $sheet->loadView('exports.dailyfreezeexport2')->with('data', $data)->with('iqfmapcollist', $iqfmapcollist);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FreezeM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data, $iqfmapcollist) {
                $excel->sheet('งานFreeze', function ($sheet) use ($data, $iqfmapcollist) {
                    $sheet->loadView('exports.dailyfreezeexport2')->with('data', $data)->with('iqfmapcollist', $iqfmapcollist);
                });
            })->export('xlsx');
        }
    }

    public function dailyfreeze2()
    {
        return view('reports.dailyfreeze2');
    }

    public function rangefreeze2()
    {
        return view('reports.rangefreeze2');
    }

    public function dailypreprod2()
    {
        return view('reports.dailypreprod2');
    }

    public function rangepreprod2()
    {
        return view('reports.rangepreprod2');
    }

    public function reportPreprod2Action(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = LogPrepareM::where('process_date', $requestData['process_date'])->get();

            $filename = "ft_preprod_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานเตรียมการ', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypreprodexport2')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = LogPrepareM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->get();

            $filename = "ft_preprod_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานเตรียมการ', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypreprodexport2')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function dailyselect2()
    {
        return view('reports.dailyselect2');
    }

    public function rangeselect2()
    {
        return view('reports.rangeselect2');
    }
    
    public function reportSelect2Action(Request $request){
        $requestData = $request->all();
        
        if($requestData['action_type'] == 'daily')
        {
            $data = LogSelectM::where('process_date', $requestData['process_date'])->get();

            $filename = "ft_select_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyselect2export')->with('data', $data);
                });
            })->export('xlsx');
        }elseif($requestData ['action_type'] == 'range'){
            $data = LogSelectM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->get();

            $filename = "ft_select_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyselect2export')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    

}
