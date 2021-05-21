<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckWeightData extends Model
{
    protected $fillable = [
        'mcheckweight_id', 'report_id', 'datetime', 'prod_name', 'cus_name',
        'weight_st', 'weight_read', 'weight_check',
        'code1_st', 'code1_read', 'code1_check',
        'code2_st', 'code2_read', 'code2_check',
        'overall_status'
    ];

    public function mchckweight()
    {
        return $this->hasOne('App\Mcheckweight', 'id', 'mcheckweight_id');
    }
}
