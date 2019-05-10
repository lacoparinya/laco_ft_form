<?php

namespace App\Http\Controllers;

use App\Timeslot;
use App\StdPack;
use Illuminate\Support\Facades\DB;

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

    public function stdpackfetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        $stdpack = StdPack::find($value);


        $output['value'] = $stdpack->id;
        $output['label'] = $stdpack->std_rate;
        echo json_encode($output);
    }

    public function getpackage(Request $request){

        $value = $request->get('q');
        $callback = $request->get( 'callback');
        
        $data = DB::table('packages')->where('name','like','%'.$value.'%')->get();

        $result = array();
        foreach ( $data as $obj) {
            $result[$obj->id] = $obj->name;
        }

        header('Content-Type: application/json; charset=utf8');

        //echo json_encode( $result);
        echo $callback. "(" . json_encode( $data) . ")";
    }

    public function getorder(Request $request)
    {

        $value = $request->get('q');
        $callback = $request->get('callback');

        $data = DB::table('orders')->where( 'order_no', 'like', '%' . $value . '%')->get();

        header('Content-Type: application/json; charset=utf8');

        //echo json_encode( $result);
        echo $callback . "(" . json_encode($data) . ")";
    }
}
