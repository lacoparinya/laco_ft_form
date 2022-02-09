<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanGroup extends Model
{
    protected $fillable = [
        'name', 'desc', 'status'
    ];
}
