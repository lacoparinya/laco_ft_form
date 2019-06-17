<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IqfMapCol extends Model
{
    protected $fillable = [
        'name', 'col_name', 'status',
    ];
}
