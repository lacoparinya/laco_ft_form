<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PackMachine extends Model
{
    protected $connection = 'sqlpackagesrv';
    
    protected $fillable = ['name', 'desc', 'status'];

    public function packagings()
    {
        return $this->belongsToMany(
            'App\Models\Packaging',
            'packaging_pack_machines',            
            'pack_machine_id',
            'packaging_id'
        );
    }
}
