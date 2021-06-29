<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeedDropPack extends Model
{
    protected $fillable = [
        'method_id',
        'shift_id',
        'check_date',
        'cabin',
        'belt_start',
        'belt_Intralox',
        'weight_head',
        'pack_part',
        'shaker',
        'table',
        'note'
    ];

    public function method()
    {
        return $this->hasOne('App\Method', 'id', 'method_id');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift', 'id', 'shift_id');
    }
}
