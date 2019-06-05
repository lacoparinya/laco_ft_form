<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtLogPack extends Model
{
    protected $fillable = [
        'job_id', 'process_date', 'timeslot_id', 'shift_id', 'method_id', 'package_id', 'order_id', 'std_pack_id',
        'output_pack', 'output_pack_sum', 'input_kg', 'output_kg', 'input_kg_sum', 'output_kg_sum', 
        'productivity', 'yeild_percent', 'num_pack', 'note', 'time_seq', 'workhours'
    ];

    public function job()
    {
        return $this->hasOne('App\Job', 'id', 'job_id');
    }

    public function timeslot()
    {
        return $this->hasOne('App\Timeslot', 'id', 'timeslot_id');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

    public function method()
    {
        return $this->hasOne('App\Method', 'id', 'method_id');
    }

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }

    public function order()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }

    public function stdpack()
    {
        return $this->hasOne('App\StdPack', 'id', 'std_pack_id');
    }
}
