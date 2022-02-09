<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PackageExp extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['packaging_id', 'package_id', 'stamp_type'];

    
}
