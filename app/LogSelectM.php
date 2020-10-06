<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogSelectM extends Model
{
    protected $fillable = [
        'process_date', 'product_id', 'shift_id', 'std_process_id', 'hourperday', 
        'targetperday', 'ref_note', 'note', 'status', 'staff_target' , 'staff_operate'
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

    public function stdprocess()
    {
        return $this->hasOne('App\StdProcess', 'id', 'std_process_id');
    }

    public function logselectd()
    {
        return $this->hasMany('App\LogSelectD', 'log_select_m_id');
    }
}
