<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPrepareM extends Model
{
    protected $fillable = [
        'pre_prod_id', 'std_pre_prod_id', 'process_date',
        'targetperhr', 'target_result', 'target_workhours',
        'note', 'status'
    ];

    public function preprod()
    {
        return $this->hasOne('App\PreProd', 'id', 'pre_prod_id');
    }

    public function stdpreprod()
    {
        return $this->hasOne('App\StdPreProd', 'id', 'std_pre_prod_id');
    }

    public function logprepared()
    {
        return $this->hasMany('App\LogPrepareD', 'log_prepare_m_id');
    }

    
}
