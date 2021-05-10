<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Weight2Report extends Model
{
    protected $connection = 'dbweight1';

    protected $table = 'report';

    protected $fillable = [
        'id', 'datetime', 'prod_name', 'cus_name', 
        'weight_st', 'weight_read', 'weight_check',
        'code1_st', 'code1_read', 'code1_check',
        'code2_st', 'code2_read', 'code2_check', 
        'overall_status'
    ];
}
