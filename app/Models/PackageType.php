<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PackageType extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['name', 'desc', 'status'];

    public function packages()
    {
        return $this->hasMany('App\Models\Package', 'package_type_id');
    }
}
