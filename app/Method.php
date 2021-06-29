<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    protected $fillable = [
        'job_id', 'name', 'desc', 'seed_drop_pack_flag'
    ];

    public function job()
    {
        return $this->hasOne('App\Job', 'id', 'job_id');
    }
}
