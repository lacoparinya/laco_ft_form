<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IqfJob extends Model
{
    protected $fillable = [
        'name', 'desc',
    ];
}