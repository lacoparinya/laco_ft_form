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
use App\LogPstSelectM;
use App\StampM;
use App\Method;
use App\WeightReport;
use App\Weight1Report;
use App\Weight2Report;
use App\Weight3Report;
use App\CheckWeightData;
use App\SeedDropPack;
use App\SeedDropSelect;
use App\Shift;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\IqfMapCol;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daily()
    {
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

    public function dailypst()
    {
        return view('reports.dailypst');
    }

    public function reportAction(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = FtLog::where('process_date', $requestData['process_date'])->orderBy('time_seq')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyexport')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
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
            $data = FtLogPack::where('process_date', $requestData['process_date'])->orderBy('time_seq')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypackexport')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FtLogPack::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->orderBy('time_seq')->get();

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
            $data = FtLogFreeze::where('process_date', $requestData['process_date'])->orderBy('process_time')->get();

            $filename = "ft_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data, $iqfmapcollist) {
                $excel->sheet('งานFreeze', function ($sheet) use ($data, $iqfmapcollist) {
                    $sheet->loadView('exports.dailyfreezeexport')->with('data', $data)->with('iqfmapcollist', $iqfmapcollist);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = FtLogFreeze::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->orderBy('process_date')->orderBy('process_time')->get();

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
                $excel->sheet('งานเตรียมการ', function ($sheet) use ($data) {
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
        return view('reports.rangepreprod');
    }

    public function rangepst()
    {
        return view('reports.rangepst');
    }

    public function orderreport()
    {

        $perPage = 25;

        $data = DB::table('ft_log_packs')
            ->join('orders', 'orders.id', '=', 'ft_log_packs.order_id')
            ->join('packages', 'packages.id', '=', 'ft_log_packs.package_id')
            ->select(DB::raw('orders.order_no, packages.name as packagename, sum([ft_log_packs].output_pack) as sumbox, sum([ft_log_packs].output_kg) as sumkg'))
            ->groupBy(DB::raw('orders.order_no, packages.name'))
            ->orderBy('orders.order_no', 'asc')
            ->orderBy('packages.name', 'asc')
            ->paginate($perPage);

        return view('reports.orderreport', compact('data'));
    }

    public function packOrderAction(Request $request)
    {

        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $data = DB::table('ft_log_packs')
                ->join('orders', 'orders.id', '=', 'ft_log_packs.order_id')
                ->join('packages', 'packages.id', '=', 'ft_log_packs.package_id')
                ->select(DB::raw('orders.order_no, packages.name as packagename, sum([ft_log_packs].output_pack) as sumbox, sum([ft_log_packs].output_kg) as sumkg'))
                ->where('orders.order_no', 'like', '%' . $keyword . '%')
                ->groupBy(DB::raw('orders.order_no, packages.name'))
                ->orderBy('orders.order_no', 'asc')
                ->orderBy('packages.name', 'asc')
                ->paginate($perPage);
        } else {

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

    public function reportSelect2Action(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = LogSelectM::where('process_date', $requestData['process_date'])->get();

            $filename = "ft_select_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyselect2export')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = LogSelectM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->get();

            $filename = "ft_select_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานคัด', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailyselect2export')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function reportPstAction(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {

            $data = LogPstSelectM::where('process_date', $requestData['process_date'])->get();

            $filename = "ft_pst_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานpst', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypstexport')->with('data', $data);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = LogPstSelectM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->get();

            $filename = "ft_pst_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานpst', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypstexport')->with('data', $data);
                });
            })->export('xlsx');
        }
    }

    public function reportPL($type)
    {

        return view('reports.report_pl', compact('type'));
    }

    public function reportPLAction($type, Request $request)
    {
        $requestData = $request->all();

        if ($type == 'pk') {
            $dataPack = DB::table('log_pack_ms')
                ->join('shifts', 'shifts.id', '=', 'log_pack_ms.shift_id')
                ->join('methods', 'methods.id', '=', 'log_pack_ms.method_id')
                ->join('packages', 'packages.id', '=', 'log_pack_ms.package_id')
                ->join('orders', 'orders.id', '=', 'log_pack_ms.order_id')
                ->join('std_packs', 'std_packs.id', '=', 'log_pack_ms.std_pack_id')
                ->join('log_pack_ds', 'log_pack_ds.log_pack_m_id', '=', 'log_pack_ms.id')
                ->select(DB::raw("
            log_pack_ms.process_date,
            shifts.name as shiiftname,
    methods.name as 'methodname',
    log_pack_ms.staff_target ,
    log_pack_ms.staff_operate,
    log_pack_ms.staff_pk,
    log_pack_ms.staff_pf,
    log_pack_ms.staff_pst,
    ISNULL(log_pack_ms.staff_target,0) - (ISNULL(log_pack_ms.staff_pk,0)+ISNULL(log_pack_ms.staff_pf,0)+ISNULL(log_pack_ms.staff_pst,0))  as 'staff_diff',
    packages.name as 'packagename',
    '-' as 'unit',
    log_pack_ms.targetperday as 'Plan',
    sum(log_pack_ds.[output_pack]) as 'Actual',
    log_pack_ms.targetperday - sum(log_pack_ds.[output_pack]) as diff,
    orders.order_no as 'Shipment',
    log_pack_ms.note as 'Remark'"))
                ->whereBetween('log_pack_ms.process_date', [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('log_pack_ms.process_date,shifts.name,methods.name,packages.name,orders.order_no,
    log_pack_ms.targetperday,packages.kgsperpack,log_pack_ms.note,
    log_pack_ms.staff_target,log_pack_ms.staff_operate,
    log_pack_ms.staff_pf,log_pack_ms.staff_pk,log_pack_ms.staff_pst'))
                ->orderBy('shifts.name', 'asc')
                ->orderBy('methods.name', 'asc')
                ->orderBy('packages.name', 'asc')
                ->get();

            $dataSelect = DB::table('log_select_ms')
                ->join('shifts', 'shifts.id', '=', 'log_select_ms.shift_id')
                ->join('products', 'products.id', '=', 'log_select_ms.product_id')
                ->join('log_select_ds', 'log_select_ds.log_select_m_id', '=', 'log_select_ms.id')
                ->select(DB::raw("
            log_select_ms.process_date,
            shifts.name as shiiftname,
            '-' as 'methodname',
            log_select_ms.staff_target,
            log_select_ms.staff_operate,
            (select top 1 pk.num_pk from log_select_ds as pk where pk.log_select_m_id = log_select_ms.id order by pk.process_datetime)  as 'staff_pk',
            (select top 1 pf.num_pf from log_select_ds as pf where pf.log_select_m_id = log_select_ms.id order by pf.process_datetime)   as 'staff_pf',
            (select top 1 pst.num_pst from log_select_ds as pst where pst.log_select_m_id = log_select_ms.id order by pst.process_datetime)  as 'staff_pst',
            ISNULL(log_select_ms.staff_target,0) - 
            (ISNULL((select top 1 pk.num_pk from log_select_ds as pk where pk.log_select_m_id = log_select_ms.id order by pk.process_datetime),0)
            +ISNULL((select top 1 pf.num_pf from log_select_ds as pf where pf.log_select_m_id = log_select_ms.id order by pf.process_datetime),0)
            +ISNULL((select top 1 pst.num_pst from log_select_ds as pst where pst.log_select_m_id = log_select_ms.id order by pst.process_datetime),0)) 
            as 'staff_diff',
            products.name as 'packagename',
            '-' as 'unit',
            log_select_ms.targetperday as 'Plan',
            sum(log_select_ds.output_kg) as 'Actual',
            log_select_ms.targetperday - sum(log_select_ds.output_kg) as diff,
            '-' as 'Shipment',
            log_select_ms.note as 'Remark'"))
                ->whereBetween('log_select_ms.process_date', [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('log_select_ms.process_date,
            shifts.name,
            log_select_ms.id,
            log_select_ms.staff_target,log_select_ms.staff_operate,
            log_select_ms.targetperday,
            log_select_ms.note,
            products.name'))
                ->orderBy('shifts.name', 'asc')
                ->orderBy('products.name', 'asc')
                ->get();

            $data = array();

            foreach ($dataPack as $dataPackObj) {
                $data[$dataPackObj->process_date]['Pack'][] = $dataPackObj;
            }

            foreach ($dataSelect as $dataSelectObj) {
                $data[$dataSelectObj->process_date]['Select'][] = $dataSelectObj;
            }


            $filename = "ft_pl_pk_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานpst', function ($sheet) use ($data) {
                    $sheet->loadView('exports.pl_pk_export')->with('data', $data);
                });
            })->export('xlsx');

            //return view('exports.pl_pk_export', compact('data'));
        }
    }

    public function dailypreprod3()
    {
        return view('reports.dailypreprod3');
    }

    public function rangepreprod3()
    {
        return view('reports.rangepreprod3');
    }

    public function reportPreprod3Action(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = LogPrepareM::where('process_date', $requestData['process_date'])->get();

            $dataSum = DB::table('log_prepare_ms')
                ->join('log_prepare_ds', 'log_prepare_ms.id', '=', 'log_prepare_ds.log_prepare_m_id')
                ->join('pre_prods', 'pre_prods.id', '=', 'log_prepare_ms.pre_prod_id')
                ->join('shifts', 'shifts.id', '=', 'log_prepare_ds.shift_id')
                ->select(DB::raw("log_prepare_ms.process_date,
            shifts.name as shiftname,
            pre_prods.name as preprodname,
            max(log_prepare_ds.input_sum) as inputsum,
            max(log_prepare_ds.output_sum) as outputsum,
            CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END as resultsum,
            sum(log_prepare_ds.workhours) as sumworkhours,
            sum((log_prepare_ds.num_iqf + log_prepare_ds.num_pre)*log_prepare_ds.workhours) as sumMH"))
                ->where('log_prepare_ms.process_date', $requestData['process_date'])
                ->groupBy(DB::raw('log_prepare_ms.process_date,
            shifts.name,
            pre_prods.name'))
                ->orderBy('log_prepare_ms.process_date', 'asc')
                ->orderBy('shifts.name', 'asc')
                ->orderBy('pre_prods.name', 'asc')
                ->get();


            $filename = "ft_preprod_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data, $dataSum) {
                $excel->sheet('งานเตรียมการ', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypreprodexport3')->with('data', $data);
                });
                $excel->sheet('งานเตรียมการสรุป', function ($sheet) use ($dataSum) {
                    $sheet->loadView('exports.dailypreprodsumexport3')->with('dataSum', $dataSum);
                });
            })->export('xlsx');
        } elseif ($requestData['action_type'] == 'range') {
            $data = LogPrepareM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->get();

            $dataSum = DB::table('log_prepare_ms')
                ->join('log_prepare_ds', 'log_prepare_ms.id', '=', 'log_prepare_ds.log_prepare_m_id')
                ->join('pre_prods', 'pre_prods.id', '=', 'log_prepare_ms.pre_prod_id')
                ->join('shifts', 'shifts.id', '=', 'log_prepare_ds.shift_id')
                ->select(DB::raw("log_prepare_ms.process_date,
            shifts.name as shiftname,
            pre_prods.name as preprodname,
            max(log_prepare_ds.input_sum) as inputsum,
            max(log_prepare_ds.output_sum) as outputsum,
            CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END as resultsum,
            sum(log_prepare_ds.workhours) as sumworkhours,
            sum((log_prepare_ds.num_iqf + log_prepare_ds.num_pre)*log_prepare_ds.workhours) as sumMH"))
                ->whereBetween('log_prepare_ms.process_date', [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('log_prepare_ms.process_date,
            shifts.name,
            pre_prods.name'))
                ->orderBy('log_prepare_ms.process_date', 'asc')
                ->orderBy('shifts.name', 'asc')
                ->orderBy('pre_prods.name', 'asc')
                ->get();

            $filename = "ft_preprod_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data, $dataSum) {
                $excel->sheet('งานเตรียมการ', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailypreprodexport3')->with('data', $data);
                });
                $excel->sheet('งานเตรียมการสรุป', function ($sheet) use ($dataSum) {
                    $sheet->loadView('exports.dailypreprodsumexport3')->with('dataSum', $dataSum);
                });
            })->export('xlsx');
        }
    }

    public function dailystamp()
    {
        return view('reports.dailystamp');
    }

    public function rangestamp()
    {
        return view('reports.rangestamp');
    }

    public function reportStampAction(Request $request)
    {
        $requestData = $request->all();

        if ($requestData['action_type'] == 'daily') {
            $data = StampM::where('process_date', $requestData['process_date'])->get();

            $filename = "ft_stamp_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานStamp', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailystampexport')->with('data', $data);
                });
            })->export('xlsx');

            ///return view('exports.dailystampexport',compact('data'));     
        } elseif ($requestData['action_type'] == 'range') {
            $data = StampM::whereBetween('process_date', [$requestData['from_date'], $requestData['to_date']])->get();

            $filename = "ft_stamp_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานStamp', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailystampexport')->with('data', $data);
                });
            })->export('xlsx');

            //return view('exports.dailystampexport', compact('data'));            
        }
    }

    public function plreportdaily()
    {
        return view('reports.plreportdaily');
    }

    public function plreportrang()
    {
        return view('reports.plreportrang');
    }

    public function plreportaction(Request $request)
    {

        $requestData = $request->all();

        $data = array();

        $dataplfreeze = array();
        $dataplprepare = array();
        $dataplselect = array();
        $dataplpack = array();
        $dataplstamp = array();

        if ($requestData['action_type'] == 'daily') {

            // Freeze 
            $dataplfreeze = DB::table('freeze_ms')
                ->leftjoin('freeze_ds', 'freeze_ms.id', '=', 'freeze_ds.freeze_m_id')
                ->leftjoin('iqf_jobs', 'iqf_jobs.id', '=', 'freeze_ms.iqf_job_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'freeze_ds.shift_id')
                ->select(DB::raw("freeze_ms.process_date,
            shifts.name as shiftname,
            freeze_ms.staff_target,
            freeze_ms.staff_operate,
            freeze_ms.staff_pf,
            freeze_ms.staff_pk,
            freeze_ms.staff_pst, 
            (ISNULL(freeze_ms.staff_pk,0)+ISNULL(freeze_ms.staff_pf,0)+ISNULL(freeze_ms.staff_pst,0)) 
            - ISNULL(freeze_ms.staff_target,0)
            as 'staff_diff',   
            iqf_jobs.name as productname,
            freeze_ms.targets * sum(freeze_ds.workhour)  as 'Plan',
            sum(freeze_ds.output_sum) as 'Actual',
            (freeze_ms.targets * sum(freeze_ds.workhour)) - sum(freeze_ds.output_sum) as 'diff',
            freeze_ms.note as Remark"))
                ->where('freeze_ms.process_date', $requestData['process_date'])
                ->groupBy(DB::raw('freeze_ms.process_date,
            shifts.name,
            freeze_ms.staff_target,
            freeze_ms.staff_operate,
            freeze_ms.staff_pf,
            freeze_ms.staff_pk,
            freeze_ms.staff_pst,
            iqf_jobs.name,
            freeze_ms.targets,
            freeze_ms.note'))
                ->get();

            //Prepare
            $dataplprepare = DB::table('log_prepare_ms')
                ->leftjoin('log_prepare_ds', 'log_prepare_ms.id', '=', 'log_prepare_ds.log_prepare_m_id')
                ->leftjoin(
                    'pre_prods',
                    'pre_prods.id',
                    '=',
                    'log_prepare_ms.pre_prod_id'
                )
                ->leftjoin('shifts', 'shifts.id', '=', 'log_prepare_ds.shift_id')
                ->select(DB::raw("log_prepare_ms.process_date,
            shifts.name as shiftname,
            log_prepare_ms.staff_target,
            log_prepare_ms.staff_operate,
            log_prepare_ms.staff_pf,
            log_prepare_ms.staff_pk,
            log_prepare_ms.staff_pst,
            (ISNULL(log_prepare_ms.staff_pk,0)+ISNULL(log_prepare_ms.staff_pf,0)+ISNULL(log_prepare_ms.staff_pst,0)) 
            - ISNULL(log_prepare_ms.staff_target,0)
            as 'staff_diff',   
            pre_prods.name as productname,
            log_prepare_ms.targetperhr * sum(log_prepare_ds.workhours) as 'Plan',
            CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END as 'Actual',
            CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END - (log_prepare_ms.targetperhr * sum(log_prepare_ds.workhours)) as 'diff',
            log_prepare_ms.note as Remark"))
                ->where('log_prepare_ms.process_date',  $requestData['process_date'])
                ->groupBy(DB::raw('log_prepare_ms.process_date,
            shifts.name,
            log_prepare_ms.staff_target,
            log_prepare_ms.staff_operate,
            log_prepare_ms.staff_pf,
            log_prepare_ms.staff_pk,
            log_prepare_ms.staff_pst,
            pre_prods.name,
            log_prepare_ms.targetperhr,
            log_prepare_ms.note'))
                ->get();

            //Select 
            $dataplselect = DB::table('log_select_ms')
                ->leftjoin('log_select_ds', 'log_select_ms.id', '=', 'log_select_ds.log_select_m_id')
                ->leftjoin('products', 'products.id', '=', 'log_select_ms.product_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'log_select_ms.shift_id')
                ->select(DB::raw("log_select_ms.process_date,
                shifts.name as shiiftname,
                '-' as jobtype,
                log_select_ms.staff_target as staff_target,
                log_select_ms.staff_operate as staff_operate,
                (select top 1 pk.num_pk from log_select_ds as pk where pk.log_select_m_id = log_select_ms.id order by pk.process_datetime)  as staff_pk,
                (select top 1 pf.num_pf from log_select_ds as pf where pf.log_select_m_id = log_select_ms.id order by pf.process_datetime)   as staff_pf,
                (select top 1 pst.num_pst from log_select_ds as pst where pst.log_select_m_id = log_select_ms.id order by pst.process_datetime)  as staff_pst,
                (
                (ISNULL((select top 1 pk.num_pk from log_select_ds as pk where pk.log_select_m_id = log_select_ms.id order by pk.process_datetime),0)
                +ISNULL((select top 1 pf.num_pf from log_select_ds as pf where pf.log_select_m_id = log_select_ms.id order by pf.process_datetime),0)
                +ISNULL((select top 1 pst.num_pst from log_select_ds as pst where pst.log_select_m_id = log_select_ms.id order by pst.process_datetime),0)) 
                ) - ISNULL(log_select_ms.staff_target,0) as staff_diff,
                products.name as productname,
                'kg' as unit,
                log_select_ms.targetperday as 'Plan',
                sum(log_select_ds.output_kg) as Actual,
                sum(log_select_ds.output_kg) - log_select_ms.targetperday as diff,
                '-'  as Shipment,
                log_select_ms.note as Remark"))
                ->where('log_select_ms.process_date', $requestData['process_date'])
                ->groupBy(DB::raw('log_select_ms.process_date,
                shifts.name,
                log_select_ms.id,
                log_select_ms.staff_target,log_select_ms.staff_operate,
                log_select_ms.targetperday,
                log_select_ms.note,
                products.name'))
                ->get();

            //Pack
            $dataplpack = DB::table('log_pack_ms')
                ->leftjoin('log_pack_ds', 'log_pack_ms.id', '=', 'log_pack_ds.log_pack_m_id')
                ->leftjoin('methods', 'methods.id', '=', 'log_pack_ms.method_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'log_pack_ms.shift_id')
                ->leftjoin('packages', 'packages.id', '=', 'log_pack_ms.package_id')
                ->leftjoin('orders', 'orders.id', '=', 'log_pack_ms.order_id')
                ->leftjoin('std_packs', 'std_packs.id', '=', 'log_pack_ms.std_pack_id')
                ->select(DB::raw("log_pack_ms.process_date,
            shifts.name as 'shiftname',
            methods.name as 'methodname',
            log_pack_ms.staff_target as 'staff_target',
            log_pack_ms.staff_operate as 'staff_operate',
            log_pack_ms.staff_pk  as 'staff_pk',
            log_pack_ms.staff_pf  as 'staff_pf',
            log_pack_ms.staff_pst  as 'staff_pst',
            (ISNULL(log_pack_ms.staff_pk,0)+ISNULL(log_pack_ms.staff_pf,0)+ISNULL(log_pack_ms.staff_pst,0)) 
            - ISNULL(log_pack_ms.staff_target,0)
            as 'staff_diff',
            packages.name as 'packagename',
            '-' as 'unit',
            log_pack_ms.targetperday as 'Plan',
            sum(log_pack_ds.[output_pack]) as 'Actual',
            sum(log_pack_ds.[output_pack]) - log_pack_ms.targetperday as 'diff',
            orders.order_no as 'Shipment',
            log_pack_ms.note as 'Remark'"))
                ->where('log_pack_ms.process_date', $requestData['process_date'])
                ->groupBy(DB::raw('log_pack_ms.process_date,
            shifts.name,methods.name,packages.name,orders.order_no,
            log_pack_ms.targetperday,packages.kgsperpack,log_pack_ms.note,
            log_pack_ms.staff_target,log_pack_ms.staff_operate,
            log_pack_ms.staff_pf,log_pack_ms.staff_pk,log_pack_ms.staff_pst'))
                ->get();

            //Stamp
            $dataplstamp = DB::table('stamp_ms')
                ->leftjoin('stamp_ds', 'stamp_ms.id', '=', 'stamp_ds.stamp_m_id')
                ->leftjoin('stamp_machines', 'stamp_machines.id', '=', 'stamp_ms.stamp_machine_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'stamp_ms.shift_id')
                ->leftjoin('mat_packs', 'mat_packs.id', '=', 'stamp_ms.mat_pack_id')
                ->select(DB::raw("stamp_ms.process_date,
            shifts.name as shiftname,
    stamp_machines.name as 'stampmachinename',
    mat_packs.matname as 'matname',
    mat_packs.packname as 'packname',
    stamp_ms.staff_target as 'staff_target',
    stamp_ms.staff_operate as 'staff_operate',
    stamp_ms.staff_actual  as 'staff_actual',
    ISNULL(stamp_ms.staff_target,0)
    - ISNULL(stamp_ms.staff_actual,0)
    as 'staff_diff',
    stamp_ms.targetperjob,
    sum(stamp_ds.output) as Actual,
    stamp_ms.targetperjob -
    sum(stamp_ds.output) as diff,
    stamp_ms.note as 'Remark'"))
                ->where('stamp_ms.process_date', $requestData['process_date'])
                ->groupBy(DB::raw('stamp_ms.process_date,
            shifts.name,
    stamp_machines.name ,
    mat_packs.matname ,
    mat_packs.packname,
    stamp_ms.staff_target ,
    stamp_ms.staff_operate ,
    stamp_ms.staff_actual ,
    stamp_ms.targetperjob,
    stamp_ms.note'))
                ->get();
        } elseif ($requestData['action_type'] == 'range') {

            // Freeze 
            $dataplfreeze = DB::table('freeze_ms')
                ->leftjoin('freeze_ds', 'freeze_ms.id', '=', 'freeze_ds.freeze_m_id')
                ->leftjoin('iqf_jobs', 'iqf_jobs.id', '=', 'freeze_ms.iqf_job_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'freeze_ds.shift_id')
                ->select(DB::raw("freeze_ms.process_date,
            shifts.name as shiftname,
            freeze_ms.staff_target,
            freeze_ms.staff_operate,
            freeze_ms.staff_pf,
            freeze_ms.staff_pk,
            freeze_ms.staff_pst, 
            (ISNULL(freeze_ms.staff_pk,0)+ISNULL(freeze_ms.staff_pf,0)+ISNULL(freeze_ms.staff_pst,0)) 
            - ISNULL(freeze_ms.staff_target,0)
            as 'staff_diff',   
            iqf_jobs.name as productname,
            freeze_ms.targets * sum(freeze_ds.workhour)  as 'Plan',
            sum(freeze_ds.output_sum) as 'Actual',
            (freeze_ms.targets * sum(freeze_ds.workhour)) - sum(freeze_ds.output_sum) as 'diff',
            freeze_ms.note as Remark"))
                ->whereBetween('freeze_ms.process_date', [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('freeze_ms.process_date,
            shifts.name,
            freeze_ms.staff_target,
            freeze_ms.staff_operate,
            freeze_ms.staff_pf,
            freeze_ms.staff_pk,
            freeze_ms.staff_pst,
            iqf_jobs.name,
            freeze_ms.targets,
            freeze_ms.note'))
                ->get();

            //Prepare
            $dataplprepare = DB::table('log_prepare_ms')
                ->leftjoin('log_prepare_ds', 'log_prepare_ms.id', '=', 'log_prepare_ds.log_prepare_m_id')
                ->leftjoin(
                    'pre_prods',
                    'pre_prods.id',
                    '=',
                    'log_prepare_ms.pre_prod_id'
                )
                ->leftjoin('shifts', 'shifts.id', '=', 'log_prepare_ds.shift_id')
                ->select(DB::raw("log_prepare_ms.process_date,
            shifts.name as shiftname,
            log_prepare_ms.staff_target,
            log_prepare_ms.staff_operate,
            log_prepare_ms.staff_pf,
            log_prepare_ms.staff_pk,
            log_prepare_ms.staff_pst,
            (ISNULL(log_prepare_ms.staff_pk,0)+ISNULL(log_prepare_ms.staff_pf,0)+ISNULL(log_prepare_ms.staff_pst,0)) 
            - ISNULL(log_prepare_ms.staff_target,0)
            as 'staff_diff',   
            pre_prods.name as productname,
            log_prepare_ms.targetperhr * sum(log_prepare_ds.workhours) as 'Plan',
            CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END as 'Actual',
            CASE WHEN max(log_prepare_ds.input_sum) > 0 THEN max(log_prepare_ds.input_sum) ELSE max(log_prepare_ds.output_sum) END - (log_prepare_ms.targetperhr * sum(log_prepare_ds.workhours)) as 'diff',
            log_prepare_ms.note as Remark"))
                ->whereBetween('log_prepare_ms.process_date',  [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('log_prepare_ms.process_date,
            shifts.name,
            log_prepare_ms.staff_target,
            log_prepare_ms.staff_operate,
            log_prepare_ms.staff_pf,
            log_prepare_ms.staff_pk,
            log_prepare_ms.staff_pst,
            pre_prods.name,
            log_prepare_ms.targetperhr,
            log_prepare_ms.note'))
                ->get();

            //select
            $dataplselect = DB::table('log_select_ms')
                ->leftjoin('log_select_ds', 'log_select_ms.id', '=', 'log_select_ds.log_select_m_id')
                ->leftjoin('products', 'products.id', '=', 'log_select_ms.product_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'log_select_ms.shift_id')
                ->select(DB::raw("log_select_ms.process_date,
                shifts.name as shiiftname,
                '-' as jobtype,
                log_select_ms.staff_target as staff_target,
                log_select_ms.staff_operate as staff_operate,
                (select top 1 pk.num_pk from log_select_ds as pk where pk.log_select_m_id = log_select_ms.id order by pk.process_datetime)  as staff_pk,
                (select top 1 pf.num_pf from log_select_ds as pf where pf.log_select_m_id = log_select_ms.id order by pf.process_datetime)   as staff_pf,
                (select top 1 pst.num_pst from log_select_ds as pst where pst.log_select_m_id = log_select_ms.id order by pst.process_datetime)  as staff_pst,
                (
                (ISNULL((select top 1 pk.num_pk from log_select_ds as pk where pk.log_select_m_id = log_select_ms.id order by pk.process_datetime),0)
                +ISNULL((select top 1 pf.num_pf from log_select_ds as pf where pf.log_select_m_id = log_select_ms.id order by pf.process_datetime),0)
                +ISNULL((select top 1 pst.num_pst from log_select_ds as pst where pst.log_select_m_id = log_select_ms.id order by pst.process_datetime),0)) 
                ) - ISNULL(log_select_ms.staff_target,0) as staff_diff,
                products.name as productname,
                'kg' as unit,
                log_select_ms.targetperday as 'Plan',
                sum(log_select_ds.output_kg) as Actual,
                sum(log_select_ds.output_kg) - log_select_ms.targetperday as diff,
                '-'  as Shipment,
                log_select_ms.note as Remark"))
                ->whereBetween('log_select_ms.process_date', [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('log_select_ms.process_date,
                shifts.name,
                log_select_ms.id,
                log_select_ms.staff_target,log_select_ms.staff_operate,
                log_select_ms.targetperday,
                log_select_ms.note,
                products.name'))
                ->get();

            //Pack
            $dataplpack = DB::table('log_pack_ms')
                ->leftjoin('log_pack_ds', 'log_pack_ms.id', '=', 'log_pack_ds.log_pack_m_id')
                ->leftjoin('methods', 'methods.id', '=', 'log_pack_ms.method_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'log_pack_ms.shift_id')
                ->leftjoin('packages', 'packages.id', '=', 'log_pack_ms.package_id')
                ->leftjoin('orders', 'orders.id', '=', 'log_pack_ms.order_id')
                ->leftjoin('std_packs', 'std_packs.id', '=', 'log_pack_ms.std_pack_id')
                ->select(DB::raw("log_pack_ms.process_date,
            shifts.name as 'shiftname',
            methods.name as 'methodname',
            log_pack_ms.staff_target as 'staff_target',
            log_pack_ms.staff_operate as 'staff_operate',
            log_pack_ms.staff_pk  as 'staff_pk',
            log_pack_ms.staff_pf  as 'staff_pf',
            log_pack_ms.staff_pst  as 'staff_pst',
            (ISNULL(log_pack_ms.staff_pk,0)+ISNULL(log_pack_ms.staff_pf,0)+ISNULL(log_pack_ms.staff_pst,0)) 
            - ISNULL(log_pack_ms.staff_target,0)
            as 'staff_diff',
            packages.name as 'packagename',
            '-' as 'unit',
            log_pack_ms.targetperday as 'Plan',
            sum(log_pack_ds.[output_pack]) as 'Actual',
            sum(log_pack_ds.[output_pack]) - log_pack_ms.targetperday as 'diff',
            orders.order_no as 'Shipment',
            log_pack_ms.note as 'Remark'"))
                ->whereBetween('log_pack_ms.process_date',  [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('log_pack_ms.process_date,
            shifts.name,methods.name,packages.name,orders.order_no,
            log_pack_ms.targetperday,packages.kgsperpack,log_pack_ms.note,
            log_pack_ms.staff_target,log_pack_ms.staff_operate,
            log_pack_ms.staff_pf,log_pack_ms.staff_pk,log_pack_ms.staff_pst'))
                ->get();

            //Stamp
            $dataplstamp = DB::table('stamp_ms')
                ->leftjoin('stamp_ds', 'stamp_ms.id', '=', 'stamp_ds.stamp_m_id')
                ->leftjoin('stamp_machines', 'stamp_machines.id', '=', 'stamp_ms.stamp_machine_id')
                ->leftjoin('shifts', 'shifts.id', '=', 'stamp_ms.shift_id')
                ->leftjoin('mat_packs', 'mat_packs.id', '=', 'stamp_ms.mat_pack_id')
                ->select(DB::raw("stamp_ms.process_date,
            shifts.name as shiftname,
    stamp_machines.name as 'stampmachinename',
    mat_packs.matname as 'matname',
    mat_packs.packname as 'packname',
    stamp_ms.staff_target as 'staff_target',
    stamp_ms.staff_operate as 'staff_operate',
    stamp_ms.staff_actual  as 'staff_actual',
    ISNULL(stamp_ms.staff_actual,0) -
    ISNULL(stamp_ms.staff_target,0)
    as 'staff_diff',
    stamp_ms.targetperjob,
    sum(stamp_ds.output) as Actual,
    sum(stamp_ds.output) - 
    stamp_ms.targetperjob
    as diff,
    stamp_ms.note as 'Remark'"))
                ->whereBetween('stamp_ms.process_date', [$requestData['from_date'], $requestData['to_date']])
                ->groupBy(DB::raw('stamp_ms.process_date,
            shifts.name,
    stamp_machines.name ,
    mat_packs.matname ,
    mat_packs.packname,
    stamp_ms.staff_target ,
    stamp_ms.staff_operate ,
    stamp_ms.staff_actual ,
    stamp_ms.targetperjob,
    stamp_ms.note'))
                ->get();
        }

        foreach ($dataplfreeze as $item) {
            $data[$item->process_date]["freeze"][] = $item;
        }
        foreach ($dataplprepare as $item) {
            $data[$item->process_date]["prepare"][] = $item;
        }
        foreach ($dataplselect as $item) {
            $data[$item->process_date]["select"][] = $item;
        }
        foreach ($dataplpack as $item) {
            $data[$item->process_date]["pack"][] = $item;
        }
        foreach ($dataplstamp as $item) {
            $data[$item->process_date]["stamp"][] = $item;
        }


        ksort($data);


        $filename = "ft_pl_report_" . date('ymdHi');

        Excel::create($filename, function ($excel) use ($data) {
            $excel->sheet('งานFT', function ($sheet) use ($data) {
                $sheet->loadView('exports.plsumexport')->with('data', $data);
            });
        })->export('xlsx');
    }

    public function checkweightreportdaily()
    {
        return view('reports.checkweightreportdaily');
    }

    public function checkweightreportrang()
    {
        return view('reports.checkweightreportrang');
    }

    public function checkweightreportaction(Request $request)
    {

        $requestData = $request->all();

        $data = array();

        $dataplfreeze = array();
        $dataplprepare = array();
        $dataplselect = array();
        $dataplpack = array();
        $dataplstamp = array();

        if ($requestData['action_type'] == 'daily') {
            //$data = StampM::where('datetime', $requestData['process_date'])->get();\
            $data = CheckWeightData::whereBetween('datetime', [$requestData['process_date'] . " 00:00:00", $requestData['process_date'] . " 23:59:59"])
                ->orderBy('mcheckweight_id', 'ASC')
                ->orderBy('datetime', 'ASC')
                ->orderBy('cus_name', 'ASC')
                ->orderBy('prod_name', 'ASC')
                ->get();

            $filename = "ft_checkweight_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานStamp', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailycheckweightexport')
                        ->with('data', $data);
                });
            })->export('xlsx');

            //return view('exports.dailycheckweightexport',compact('data'));
        } else {
            $data = CheckWeightData::whereBetween('datetime', [$requestData['from_date'] . " 00:00:00", $requestData['to_date'] . " 23:59:59"])
                ->orderBy('mcheckweight_id', 'ASC')
                ->orderBy('datetime', 'ASC')
                ->orderBy('cus_name', 'ASC')
                ->orderBy('prod_name', 'ASC')
                ->get();


            $filename = "ft_checkweight_report_" . date('ymdHi');

            Excel::create($filename, function ($excel) use ($data) {
                $excel->sheet('งานStamp', function ($sheet) use ($data) {
                    $sheet->loadView('exports.dailycheckweightexport')
                        ->with('data', $data);
                });
            })->export('xlsx');

            //return view('exports.dailycheckweightexport', compact('data'));
        }
    }

    public function seedDropPackReport()
    {
        return view('reports.seed-drop-pack-rpt');
    }

    public function seedDropPackReportAction(Request $request)
    {
        $requestData = $request->all();
        

        $dataRw = SeedDropPack::whereBetween('check_date', [$requestData['from_date'], $requestData['to_date']])->get();

        $data = array();
        foreach ($dataRw as $dataObj) {
            $data[$dataObj->check_date][$dataObj->shift_id][$dataObj->method_id] = $dataObj;
        }

        $methodlist = Method::where('seed_drop_pack_flag', '>', 0)->orderBy('seed_drop_pack_flag')->pluck('name', 'id');
        $shiftlist = Shift::pluck('name', 'id');

        $filename = "ft_seeddroppack_report_" . date('ymdHi');

        Excel::create($filename, function ($excel) use ($data, $methodlist, $shiftlist) {
            $excel->sheet('งานถัวตกไลน์แพ๊ค', function ($sheet) use ($data, $methodlist, $shiftlist) {
                $sheet->loadView('exports.dailyseeddroppackexport')
                ->with('data', $data)
                ->with('methodlist', $methodlist)
                ->with('shiftlist', $shiftlist);
            });
        })->export('xlsx');


        //return view('exports.dailyseeddroppackexport', compact('data', 'methodlist', 'shiftlist'));
    }

    public function seedDropSelectReport()
    {
        return view('reports.seed-drop-select-rpt');
    }

    public function seedDropSelectReportAction(Request $request)
    {
        $requestData = $request->all();

        $data = SeedDropSelect::whereBetween('check_date', [$requestData['from_date'], $requestData['to_date']])->get();
        $shiftlist = Shift::pluck('name', 'id');

        $filename = "ft_seeddropselect_report_" . date('ymdHi');

        Excel::create($filename, function ($excel) use ($data, $shiftlist) {
            $excel->sheet('งานถัวตกไลน์คัด', function ($sheet) use ($data, $shiftlist) {
                $sheet->loadView('exports.dailyseeddropselectexport')
                ->with('data', $data)
                    ->with('shiftlist', $shiftlist);
            });
        })->export('xlsx');


        //return view('exports.dailyseeddropselectexport', compact('data', 'shiftlist'));
    }
}
