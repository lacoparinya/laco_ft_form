<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanRptM extends Model
{
    protected $fillable = ['enter_date','month','year','note','status'];

    public function planrptds()
    {
        return $this->hasMany('App\PlanRptD', 'plan_rpt_m_id');
    }
}
