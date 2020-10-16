<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StampMachine extends Model
{
    protected $fillable = [
        'name', 'desc', 'standardrate'
    ];
}
