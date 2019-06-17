<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtLogFreeze extends Model
{
    protected $fillable = [
        'job_id', 'process_date', 'process_time', 'workhours', 'targets', 
        'start_RM', 'current_RM', 'use_RM', 'recv_RM', 'output_custom1', 
        'output_custom2', 'output_custom3', 'output_custom4', 'output_custom5', 
        'output_custom6', 'output_custom7', 'output_custom8', 'output_sum', 'output_all_sum', 'iqf_job_id'
    ];

    public function iqfjob()
    {
        return $this->hasOne('App\IqfJob', 'id', 'iqf_job_id');
    }
}
