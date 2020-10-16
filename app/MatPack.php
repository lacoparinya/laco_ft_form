<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatPack extends Model
{
    protected $fillable = [
        'matname', 'packname', 'stdrateperhr', 'status'
    ];
}
