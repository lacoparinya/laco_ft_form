<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StampD extends Model
{
    protected $fillable = [
        'stamp_m_id', 'process_datetime', 'workhours', 'output', 'outputSum', 'staff_actual', 'note', 'problem',
        'img_path'
    ];

    public function stampm()
    {
        return $this->hasOne('App\StampM', 'id', 'stamp_m_id');
    }

    public function recalculate($stamp_m_id)
    {
        $data = self::where('stamp_m_id', $stamp_m_id)
            ->orderBy('process_datetime', 'asc')
            ->get();

        if (!($data->isEmpty())) {
            $sumOutputAll = 0;
            foreach ($data as $dataObj) {
                $sumOutputAll += $dataObj->output;
                $tmp = $dataObj;
                $tmp->outputSum = $sumOutputAll;

                $tmp->update();
            }
        }
    }
}
