<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\FreezeM;

class MainsController extends Controller
{
    public function index($date){

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
            
        return view('mains.index', compact('rawfreezedata', 'rawpreparedata'));
    }
}
