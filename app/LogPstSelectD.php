<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPstSelectD extends Model
{
    protected $fillable = [
        'log_pst_select_m_id', 'process_datetime', 'workhours', 'input_kg', 'output_kg',
        'sum_in_kg', 'sum_kg', 'yeild_percent', 'num_classify', 'grade', 'ref_note', 'note',
        'problem', 'img_path'
    ];

    public function logpstselectm()
    {
        return $this->hasOne('App\LogPstSelectM', 'id', 'log_pst_select_m_id');
    }

    public function recalculate($log_pst_select_m_id)
    {

    $data = self::where('log_pst_select_m_id', $log_pst_select_m_id)
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
