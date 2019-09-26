<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogSelectD extends Model
{
    protected $fillable = [
        'log_select_m_id', 'process_datetime', 'workhours', 'input_kg', 'output_kg', 
        'sum_in_kg', 'sum_kg', 'yeild_percent', 'num_pk', 'num_pf', 'num_pst', 'num_classify', 
        'line_a', 'line_b', 'line_classify', 'line_classify_unit', 'grade', 'ref_note', 'note'
    ];

    public function logpreparem()
    {
        return $this->hasOne('App\LogSelectM', 'id', 'log_select_m_id');
    }

    public function recalculate($log_select_m_id)
    {
        $data = self::where('log_select_m_id', $log_select_m_id)
            ->orderBy('process_datetime', 'asc')
            ->get();

        if (!($data->isEmpty())) {
            $sumInputAll = 0;
            $sumOutputAll = 0;
            foreach ($data as $dataObj) {
                $sumInputAll += $dataObj->input_kg;
                $sumOutputAll += $dataObj->output_kg;
                $tmp = $dataObj;
                $tmp->sum_in_kg = $sumInputAll;
                $tmp->sum_kg = $sumOutputAll;

                $tmp->update();
            }
        }
    }
}
