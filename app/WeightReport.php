<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WeightReport extends Model
{
    protected $connection = 'mysql';

    protected $table = 'report';

    protected $fillable = [
        'id', 'datetime', 'prod_name', 'cus_name', 
        'weight_st', 'weight_read', 'weight_check',
        'code1_st', 'code1_read', 'code1_check',
        'code2_st', 'code2_read', 'code2_check', 
        'overall_status'
    ];

    public function canConnect(){
        //$pdo = DB::connection($this->connection)->table(DB::raw('DUAL'))->first([DB::raw(1)]);
       // var_dump($pdo);

        if (DB::connection($this->connection)->table(DB::raw('DUAL'))->first([DB::raw(1)])) {
            return true;
        } else {
            return false;
        }
    }
}
