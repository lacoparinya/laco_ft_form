<?php

namespace App\Http\Controllers;

use App\Timeslot;
use Illuminate\Http\Request;


class DynamicListController extends Controller
{
    public function shiftfetch (Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        $timeslot = Timeslot::find($value);

       
        $output['value'] = $timeslot->shift_id;
        $output['label'] = $timeslot->shift->name;
        echo json_encode($output);
    }
}
