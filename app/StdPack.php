<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StdPack extends Model
{
    protected $fillable = [
        'method_id', 'package_id', 'std_rate', 'kgsperpack', 'packperhour', 'status',
    ];

    public function method()
    {
        return $this->hasOne('App\Method', 'id', 'method_id');
    }

    public function package()
    {
        return $this->hasOne('App\Package', 'id', 'package_id');
    }
}
