<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreezeD extends Model
{
    protected $fillable = [
        'freeze_m_id', 'workhour', 'process_datetime', 'iqf_job_id', 'current_RM', 'use_RM', 'output_custom1', 'output_custom2', 
        'output_custom3', 'output_custom4', 'output_custom5', 'output_custom6', 'output_custom7', 'output_custom8', 
        'output_sum', 'output_all_sum', 'note' 
    ];

    public function freezem()
    {
        return $this->hasOne('App\FreezeM', 'id', 'freeze_m_id');
    }

    public function iqfjob()
    {
        return $this->hasOne('App\IqfJob', 'id', 'iqf_job_id');
    }

    public function recalculate($master_code,$start_rm)
    {
        $data = self::where('freeze_m_id', $master_code)
            ->orderBy('process_datetime', 'asc')
            ->get();

        if (!($data->isEmpty())) {
            $sumAll = 0;
            $remainAll = $start_rm;
            foreach ($data as $dataObj) {
                $sumAll += $dataObj->output_sum;
                $remainAll -= $dataObj->output_sum;
                $tmp = $dataObj;
                $tmp->output_all_sum = $sumAll;
                $tmp->current_RM = $remainAll;

                $tmp->update();
            }
        }
    }
}
