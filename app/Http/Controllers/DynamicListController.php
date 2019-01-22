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

       
        $output = $timeslot->shift_id;
        echo $output;
    }
}
