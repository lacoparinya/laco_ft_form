<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtDetail extends Model
{
    protected $fillable = [
        'ft_master_id', 'shift_id', 'process_time', 'input_kg' , 'output_kg', 'sum_kg', 'yeild_precent', 'num_pk', 'num_pf',
        'num_pst', 'num_classify', 'line_a', 'line_b', 'line_classify', 'line_classify_unit', 'note'
    ];

    public function ftmaster()
    {
        return $this->hasOne('App\FtMaster');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift');
    }

    public function classifyunit()
    {
        return $this->hasOne('App\Unit','id', 'line_classify_unit');
    }
}
