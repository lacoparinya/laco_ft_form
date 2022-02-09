<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanRptD extends Model
{
    protected $fillable = ['plan_rpt_m_id','plan_group_id','num_delivery_plan','num_confirm',
    'num_packed','num_wait','num_unconfirm','num_unpacked','note'];

    public function planrptm()
    {
        return $this->hasOne('App\PlanRptM', 'id', 'plan_rpt_m_id');
    }

    public function plangroup()
    {
        return $this->hasOne('App\PlanGroup', 'id', 'plan_group_id');
    }

}
