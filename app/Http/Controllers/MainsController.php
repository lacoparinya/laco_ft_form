<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\FreezeM;
use App\WeightReport;

class MainsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($date){

        

        if($date == 'today'){
            $date = date('Y-m-d');
        }

        $rawfreezedata = DB::table('freeze_ms')
                        ->join('iqf_jobs', 'iqf_jobs.id','=', 'freeze_ms.iqf_job_id')
                        ->join('freeze_ds', 'freeze_ds.freeze_m_id', '=', 'freeze_ms.id')
                        ->select(DB::raw(
                'freeze_ms.process_date,
                            freeze_ms.iqf_job_id,
                            iqf_jobs.name,
                            freeze_ms.start_RM,
                            freeze_ms.targets,
                            freeze_ms.target_hr,
                            sum(freeze_ds.output_custom1) as IQF1_2,
                            sum(freeze_ds.output_custom2) as IQF_3,
                            sum(freeze_ds.output_sum) as SUM_Total,
                            freeze_ms.start_RM - sum(freeze_ds.output_custom1) as Remain,
                            sum(freeze_ds.workhour) as actual_hour,
                            freeze_ms.status')
                        )
                        ->where('freeze_ms.process_date',$date)
                        ->groupBy(DB::raw(
                'freeze_ms.process_date,
                            freeze_ms.iqf_job_id,
                            iqf_jobs.name,
                            freeze_ms.start_RM,
                            freeze_ms.targets,
                            freeze_ms.target_hr,
                            freeze_ms.status')
                        )
                        ->get();

        $rawpreparedata = DB::table('log_prepare_ms')
            ->join('log_prepare_ds', 'log_prepare_ds.log_prepare_m_id', '=', 'log_prepare_ms.id')
            ->join('pre_prods', 'log_prepare_ms.pre_prod_id', '=', 'pre_prods.id')
            ->join('std_pre_prods', 'log_prepare_ms.std_pre_prod_id', '=', 'std_pre_prods.id')
            ->select(
                DB::raw(
                'log_prepare_ms.process_date,
                log_prepare_ms.pre_prod_id,
                pre_prods.name,
                log_prepare_ms.std_pre_prod_id,
                std_pre_prods.std_rate_per_h_m,
                log_prepare_ms.target_result,
                log_prepare_ms.target_workhours,
                log_prepare_ms.targetperhr,
                sum(log_prepare_ds.input) as input,
                sum(log_prepare_ds.output) as output,
                avg(log_prepare_ds.num_pre) as numpre,
                avg(log_prepare_ds.num_iqf) as numiqf,
                avg(log_prepare_ds.num_pre) + avg(log_prepare_ds.num_iqf) as numall,
                sum(log_prepare_ds.workhours) as acthour,
                CASE 
                    WHEN sum(log_prepare_ds.input) > 0 THEN log_prepare_ms.target_result - sum(log_prepare_ds.input)
                    ELSE log_prepare_ms.target_result - sum(log_prepare_ds.output)
                END as remain,
                log_prepare_ms.target_workhours - sum(log_prepare_ds.workhours) as remainhr,
                log_prepare_ms.status'
                )
            )
            ->where('log_prepare_ms.process_date', $date)
            ->groupBy(
                DB::raw(
                'log_prepare_ms.process_date,
                log_prepare_ms.pre_prod_id,
                pre_prods.name,
                log_prepare_ms.std_pre_prod_id,
                std_pre_prods.std_rate_per_h_m,
                log_prepare_ms.target_result,
                log_prepare_ms.target_workhours,
                log_prepare_ms.targetperhr,
                log_prepare_ms.status'
                )
            )
            ->get();

        $rawselectdata = DB::table('log_select_ms')
            ->join('products', 'log_select_ms.product_id', '=', 'products.id')
            ->join('log_select_ds', 'log_select_ds.log_select_m_id', '=', 'log_select_ms.id')
            ->join('std_processes', 'log_select_ms.std_process_id', '=', 'std_processes.id')
            ->select(
                DB::raw(
                '
                log_select_ms.process_date,
                products.id as product_id,
                products.name as product_name,
                log_select_ms.hourperday,
                log_select_ms.targetperday,
                std_processes.std_rate,
                log_select_ms.status,
                sum(log_select_ds.workhours) as sum_use_hour,
                sum(log_select_ds.input_kg) as sum_kg_input,
                sum(log_select_ds.output_kg) as sum_kg_output,
                sum(log_select_ds.output_kg) /sum(log_select_ds.input_kg) as avg_yeild,
                log_select_ms.hourperday - sum(log_select_ds.workhours) as diffhour,
                log_select_ms.targetperday - sum(log_select_ds.output_kg) as difftraget,
                avg(log_select_ds.num_classify) as avg_selected'
                )
            )
            ->where('log_select_ms.process_date', $date)
            ->groupBy(
                DB::raw(
                'log_select_ms.process_date,
                products.id,
                products.name,
                log_select_ms.hourperday,
                log_select_ms.targetperday,
                std_processes.std_rate,
                log_select_ms.status'
                )
            )
            ->get();

        $rawpackdata = DB::table('log_pack_ms')
            ->join('methods', 'log_pack_ms.method_id', '=', 'methods.id')
            ->join('packages', 'log_pack_ms.package_id', '=', 'packages.id')
            ->join('orders', 'log_pack_ms.order_id', '=', 'orders.id')
            ->join('std_packs', 'log_pack_ms.std_pack_id', '=', 'std_packs.id')
            ->join('shifts', 'log_pack_ms.shift_id', '=', 'shifts.id')
            ->join('log_pack_ds', 'log_pack_ds.log_pack_m_id', '=', 'log_pack_ms.id')
            ->select(
                DB::raw(
                'log_pack_ms.process_date,
                log_pack_ms.method_id,
                methods.name as methode_name,
                log_pack_ms.package_id,
                packages.name as package_name,
                log_pack_ms.order_id,
                orders.order_no,
                log_pack_ms.shift_id,
                shifts.name as shift_name,
                log_pack_ms.std_pack_id,
                log_pack_ms.hourperday,
                log_pack_ms.targetperday,
                log_pack_ms.status,
                SUM(log_pack_ds.input_kg) as sum_input_kg,
                SUM(log_pack_ds.output_kg) as sum_output_kg,
                SUM(log_pack_ds.output_pack) as sum_output_pack,
                SUM(log_pack_ds.output_kg) * 100 / SUM(log_pack_ds.input_kg) as yeild,
                avg(log_pack_ds.productivity) as avg_productivity,
                avg(log_pack_ds.num_pack) as avg_numpack,
                sum(log_pack_ds.workhours) as sum_hour,
                log_pack_ms.hourperday - sum(log_pack_ds.workhours) as diffhour,
                log_pack_ms.targetperday - sum(log_pack_ds.output_pack) as difftarget'
                )
            )
            ->where('log_pack_ms.process_date', $date)
            ->groupBy(
                DB::raw(
                'log_pack_ms.process_date,
                log_pack_ms.method_id,
                methods.name,
                log_pack_ms.package_id,
                packages.name,
                log_pack_ms.order_id,
                orders.order_no,
                log_pack_ms.shift_id,
                shifts.name,
                log_pack_ms.std_pack_id,
                log_pack_ms.hourperday,
                log_pack_ms.targetperday,
                log_pack_ms.status'
                )
            )
            ->get();

        return view('mains.index', compact('rawfreezedata', 'rawpreparedata', 'rawselectdata', 'rawpackdata', 'date'));
    }

    public function weightindex($date)
    {
        $last = WeightReport::orderBy('id', 'DESC')->first();

        if ($date == 'today') {
            $date = date('Y-m-d');
        }

       

        $dataRw = WeightReport::whereBetween('datetime',[$date." 00:00:00", $date . " 23:59:59"])
        ->where('prod_name','!=','')
        ->groupBy('prod_name','cus_name','overall_status')
        ->select('prod_name', 'cus_name', 'overall_status',db::raw('count(id) as num'))

        ->get();

        $data = array();
        foreach ($dataRw as $dataObj) {
            $data[$dataObj->prod_name][$dataObj->cus_name][$dataObj->overall_status] = $dataObj->num;
        }
        return view('mains.weight', compact('last', 'data', 'date'));
 
    }
}
