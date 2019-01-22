<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    protected $fillable = [
        'name', 'gap', 'seq', 'shift_id'
    ];

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }

}
