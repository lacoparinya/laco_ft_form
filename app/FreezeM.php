<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreezeM extends Model
{
    protected $fillable = [
        'process_date', 'targets', 'iqf_job_id', 'start_RM', 'recv_RM', 'note','status',
        'target_hr', 'staff_target',
        'staff_operate', 'staff_pk', 'staff_pf', 'staff_pst'
    ];

    public function iqfjob()
    {
        return $this->hasOne('App\IqfJob', 'id', 'iqf_job_id');
    }

    public function freezed()
    {
        return $this->hasMany('App\FreezeD', 'freeze_m_id');
    }
}


