<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StdIqf extends Model
{
    protected $fillable = [ 
        'iqf_job_id', 'mechine_id', 'std_productivity_person', 'desc'
    ];

    public function iqfjob()
    {
        return $this->hasOne('App\IqfJob', 'id', 'iqf_job_id');
    }

    public function mechine()
    {
        return $this->hasOne('App\Mechine', 'id', 'mechine_id');
    }
}
