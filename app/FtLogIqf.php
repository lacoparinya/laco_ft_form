<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtLogIqf extends Model
{
    protected $fillable = [
        'process_date', 'timeslot_id', 'time_seq', 'workhours', 'shift_id', 
        'mechine_id', 'iqf_job_id', 'input_kg', 'output_kg', 'num_man', 'manhours', 
        'productivity', 'note', 'std_iqf_id'
    ];

    public function timeslot()
    {
        return $this->hasOne('App\Timeslot', 'id', 'timeslot_id');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

    public function mechine()
    {
        return $this->hasOne('App\Mechine', 'id', 'mechine_id');
    }

    public function iqfjob()
    {
        return $this->hasOne('App\IqfJob', 'id', 'iqf_job_id');
    }

    public function stdiqf()
    {
        return $this->hasOne('App\StdIqf', 'id', 'std_iqf_id');
    }

}
