<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    protected $fillable = [
        'name', 'gap', 'seq'
    ];
}
