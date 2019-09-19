<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPackD extends Model
{
    protected $fillable = [
        'log_pack_m_id', 'shift_id', 'process_datetime', 'workhours',
        'output_pack', 'output_pack_sum', 'input_kg', 'output_kg', 'input_kg_sum', 'output_kg_sum', 'productivity',
        'yeild_percent', 'num_pack', 'note',
    ];

    public function logpackm()
    {
        return $this->hasOne('App\LogPackM', 'log_pack_m_id');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

    public function recalculate($log_pack_m_id)
    {
        $data = self::where('log_pack_m_id', $log_pack_m_id)
            ->orderBy('process_datetime', 'asc')
            ->get();

        if (!($data->isEmpty())) {
            $sumInputAll = 0;
            $sumOutputAll = 0;
            $sumOutputPackAll = 0;
            foreach ($data as $dataObj) {
                $sumInputAll += $dataObj->input_kg;
                $sumOutputAll += $dataObj->output_kg;
                $sumOutputPackAll += $dataObj->output_pack;
                $tmp = $dataObj;
                $tmp->input_kg_sum = $sumInputAll;
                $tmp->output_kg_sum = $sumOutputAll;
                $tmp->output_pack_sum = $sumOutputPackAll;

                $tmp->update();
            }
        }
    }
}
