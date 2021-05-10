<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BaseModel;

class FreezeM extends BaseModel
{
    protected $fillable = [
        'process_date', 'targets', 'iqf_job_id', 'start_RM', 'recv_RM', 'note','status',
        'target_hr', 'staff_target',
        'staff_operate', 'staff_pk', 'staff_pf', 'staff_pst'
    ];

    public function iqfjob()
    {
        return $this->hasOne('App\IqfJob', 'id', 'iqf_job_id');
    }

    public function freezed()
    {
        return $this->hasMany('App\FreezeD', 'freeze_m_id');
    }

    public function jsonify() {
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $record = [];
        foreach($columns as $column) {
            
           // if ($column == 'created_at' || $column == 'updated_at') {
           //     var_dump($this[$column]);
                //$record[$column] = $this[$column]->format(Carbon::ISO8601);
              //  $record[$column] = date("D d M", strtotime($this[$column]));
           //     $record[$column] =     \Carbon\Carbon::createFromFormat('d-m-Y H:s:i', $this[$column])->format('d-m-Y');
           // } else {
            $record[$column] = $this[$column];        
          //  }
        }
        return json_encode($record);
    }
}


