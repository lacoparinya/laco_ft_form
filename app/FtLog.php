<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtLog extends Model
{
    protected $fillable = [
        'process_date', 'product_id', 'shift_id', 'process_time', 'input_kg', 'output_kg', 'sum_kg', 'yeild_percent', 'num_pk', 'num_pf',
        'num_pst', 'num_classify', 'line_a', 'line_b', 'line_classify', 'line_classify_unit', 'ref_note', 'note', 'grade', 'timeslot_id',
        'std_process_id', 'sum_in_kg', 'time_seq'
    ];

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

    public function classifyunit()
    {
        return $this->hasOne('App\Unit', 'id', 'line_classify_unit');
    }

    public function timeslot()
    {
        return $this->hasOne('App\Timeslot', 'id', 'timeslot_id');
    }

    public function stdprocess()
    {
        return $this->hasOne('App\StdProcess', 'id', 'std_process_id');
    }
}
