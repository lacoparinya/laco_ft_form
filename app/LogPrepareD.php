<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPrepareD extends Model
{
    protected $fillable = [
        'log_prepare_m_id', 'pre_prod_id', 'process_datetime', 'shift_id',
        'workhours', 'targets', 'input', 'output', 'input_sum', 'output_sum', 'num_pre',
        'num_iqf', 'num_all', 'note','problem'
    ];

    public function preprod()
    {
        return $this->hasOne('App\PreProd', 'id', 'pre_prod_id');
    }

    
    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }
    
    public function logpreparem()
    {
        return $this->hasOne('App\LogPrepareM', 'id', 'log_prepare_m_id');
    }

    public function recalculate($log_prepare_m_id)
    {
        $data = self::where('log_prepare_m_id', $log_prepare_m_id)
            ->orderBy('process_datetime', 'asc')
            ->get();

        if (!($data->isEmpty())) {
            $sumInputAll = 0;
            $sumOutputAll = 0;
            foreach ($data as $dataObj) {
                $sumInputAll += $dataObj->input;
                $sumOutputAll += $dataObj->output;
                $tmp = $dataObj;
                $tmp->input_sum = $sumInputAll;
                $tmp->output_sum = $sumOutputAll;

                $tmp->update();
            }
        }
    }
}
