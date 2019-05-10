<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StdPack extends Model
{
    protected $fillable = [
        'method_id', 'std_rate', 'status',
    ];

    public function method()
    {
        return $this->hasOne('App\Method', 'id', 'method_id');
    }
}
