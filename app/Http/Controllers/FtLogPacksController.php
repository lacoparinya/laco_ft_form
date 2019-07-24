<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FtLogPack;
use App\Timeslot;
use App\Method;
use App\Package;
use App\Order;
use App\StdPack;
use Illuminate\Http\Request;

class FtLogPacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $products = Package::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray();
            if (empty($products)) {
                $ftlogpacks = FtLogPack::where('note', 'like', '%' . $keyword . '%')
                    ->orderBy('process_date', 'DESC')
                    ->orderBy('timeslot_id', 'DESC')
                    ->paginate($perPage);
            } else {
                $ftlogpacks = FtLogPack::where('note', 'like', '%' . $keyword . '%')
                    ->orWhereIn('package_id', $products)
                    ->orderBy('process_date', 'DESC')
                    ->orderBy('timeslot_id', 'DESC')
                    ->paginate($perPage);
            }
        } else {
            $ftlogpacks = FtLogPack::orderBy('process_date', 'DESC')->orderBy('timeslot_id', 'DESC')->paginate($perPage);
        } 

        return view( 'ft-log-packs.index', compact( 'ftlogpacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $timeslotlist = Timeslot::pluck('name', 'id');
        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::where('status','Active')->orderBy('name', 'asc')->pluck('name', 'id');
        return view( 'ft-log-packs.create',compact( 'timeslotlist', 'methodlist', 'packagelist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();

        

        if(empty($requestData['package_id'])){

            $package = Package::where('name', $requestData['package_name'])->first();
            if(empty($package)){
                $tmp = array();
                $tmp['name'] = strtoupper($requestData['package_name']);
                $tmp['desc'] = strtoupper($requestData['package_name']);
                $tmp['kgsperpack'] = $requestData['kgsperpack'];
                $tmp['status'] = 'Active';

                $package = Package::create($tmp);

                $requestData['package_id'] = $package->id;
            }else{

                if ($package->kgsperpack <> $requestData['kgsperpack']) {
                    $package->kgsperpack = $requestData['kgsperpack'];
                    $package->update( $package);
                }

                $requestData['package_id'] = $package->id;
            }

            
        } else {
            $package = Package::findOrFail($requestData['package_id']);
            if ($package->kgsperpack <> $requestData['kgsperpack']) {
                $package->kgsperpack = $requestData['kgsperpack'];
                $package->update();
            }
        }

        $chk = FtLogPack::where('process_date', $requestData['process_date'])
            ->where('timeslot_id', $requestData['timeslot_id'])
            ->where('method_id', $requestData['method_id'])
            ->where('package_id', $requestData[ 'package_id'])
            ->first();
        if (!empty($chk)) {
            return redirect('ft-log-packs')->with('flash_message', 'Duplicate Data')->with('alert_message', 'alert');
        }

        if (empty($requestData['order_id'])) {

            $order = Order::where( 'order_no', $requestData[ 'order_name'])->where( 'loading_date', $requestData[ 'order_date'])->first();
            
            if(empty($order)){
                $tmp = array();
                $tmp['order_no'] = $requestData['order_name'];
                $tmp['loading_date'] = $requestData['order_date'];

                $order = Order::create($tmp);

                $requestData['order_id'] = $order->id;
            }else{
                $requestData['order_id'] = $order->id;
            }

        }

        $timeSlotObj = Timeslot::findOrFail($requestData['timeslot_id']);

        $requestData['time_seq'] = $timeSlotObj->seq;

        //Find and Create STD
        $stdObj = StdPack::where('method_id', $requestData[ 'method_id'])
                            ->where('package_id', $requestData[ 'package_id'])
                            ->where('status', true)
                            ->first();
        if(empty($stdObj)){
            $tmp = array();
            
            $tmp['method_id'] = $requestData['method_id'];
            $tmp['package_id'] = $requestData['package_id'];
            $tmp['std_rate'] = 1;
            $tmp['status'] = true;

            $stdObj = StdPack::create($tmp);
        }
        $requestData[ 'std_pack_id'] = $stdObj->id;

       // var_dump($requestData);
        FtLogPack::create($requestData);


        $this->recal($requestData['process_date']);
        return redirect( 'ft-log-packs')->with('flash_message', ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $ftlogpack = FtLogPack::findOrFail($id);

        return view( 'ft-log-packs.show', compact( 'ftlogpack'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $timeslotlist = Timeslot::pluck('name', 'id');
        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::where('status', 'Active')->orderBy('name', 'asc')->pluck('name', 'id');
        $ftlogpack = FtLogPack::findOrFail($id);

        return view( 'ft-log-packs.edit', compact( 'ftlogpack', 'timeslotlist', 'methodlist', 'packagelist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();

        

        if (empty($requestData['package_id'])) {

            $package = Package::where('name', $requestData['package_name'])->first();
            if (empty($package)) {
                $tmp = array();
                $tmp['name'] = strtoupper($requestData['package_name']);
                $tmp['desc'] = strtoupper($requestData['package_name']);
                $tmp['kgsperpack'] = $requestData['kgsperpack'];
                $tmp['status'] = 'Active';

                $package = Package::create($tmp);

                $requestData['package_id'] = $package->id;
            } else {

                if($package->kgsperpack <> $requestData['kgsperpack']){
                    $package->kgsperpack = $requestData['kgsperpack'];
                    $package->update();
                    
                }

                $requestData['package_id'] = $package->id;
            }
        }else{
            $package = Package::findOrFail( $requestData['package_id']);
            if ($package->kgsperpack <> $requestData['kgsperpack']) {
                $package->kgsperpack = $requestData['kgsperpack'];
                $package->update();
            }
        }

        $chk = FtLogPack::where('process_date', $requestData['process_date'])
            ->where('timeslot_id', $requestData['timeslot_id'])
            ->where('method_id', $requestData['method_id'])
            ->where('package_id', $requestData['package_id'])
            ->where('id', '!=', $id)
            ->first();
        if (!empty($chk)) {
            return redirect('ft-log-packs')->with('flash_message', 'Duplicate Data')->with('alert_message', 'alert');
        }

        if (empty($requestData['order_id'])) {

            $order = Order::where('order_no', $requestData['order_name'])->where('loading_date', $requestData['order_date'])->first();

            if (empty($order)) {
                $tmp = array();
                $tmp['order_no'] = $requestData['order_name'];
                $tmp['loading_date'] = $requestData['order_date'];

                $order = Order::create($tmp);

                $requestData['order_id'] = $order->id;
            } else {
                $requestData['order_id'] = $order->id;
            }
        }

        $timeSlotObj = Timeslot::findOrFail($requestData['timeslot_id']);

        $requestData['time_seq'] = $timeSlotObj->seq;

        $stdObj = StdPack::where('method_id', $requestData['method_id'])
            ->where('package_id', $requestData['package_id'])
            ->where('status', true)
            ->first();
        if (empty($stdObj)) {
            $tmp = array();

            $tmp['method_id'] = $requestData['method_id'];
            $tmp['package_id'] = $requestData['package_id'];
            $tmp['std_rate'] = 1;
            $tmp['kgsperpack'] = $requestData['kgsperpack'];
            
            $tmp['status'] = true;

            $stdObj = StdPack::create($tmp);
        }else{
            if ( $requestData['kgsperpack'] <> $stdObj->kgsperpack){
                
                $stdObj->kgsperpack = $requestData['kgsperpack'];
                $stdObj->update();
            }
        }
        $requestData['std_pack_id'] = $stdObj->id;

        $ftlogpack = FtLogPack::findOrFail($id);
        $ftlogpack->update($requestData);

        $this->recal($requestData['process_date']);
        return redirect( 'ft-log-packs')->with('flash_message', ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        FtLogPack::destroy($id);

        return redirect( 'ft-log-packs')->with('flash_message', ' deleted!')->with('alert_message', 'alert');
    }

    private function recal($date)
    {
        $data = FtLogPack::where('process_date', $date)->orderBy('time_seq')->get();
        $prevCode = "";
        $sum = array();
        $sumin = array();
        $sumout = array();
        foreach ($data as $key => $value) {
            if (isset($sum[$value->package_id][$value->order_id])) {
                $sum[$value->package_id][$value->order_id] = $sum[$value->package_id][$value->order_id] + $value->output_pack;
                $sumin[$value->package_id][$value->order_id] = $sumin[$value->package_id][$value->order_id] + $value->input_kg;
                $sumout[$value->package_id][$value->order_id] = $sumout[$value->package_id][$value->order_id] + $value->output_kg;
            } else {
                $sum[$value->package_id][$value->order_id] = $value->output_pack;
                $sumin[$value->package_id][$value->order_id] = $value->input_kg;
                $sumout[$value->package_id][$value->order_id] = $value->output_kg;
            }
            $ft_log = FtLogPack::find($value->id);

            $ft_log->output_pack_sum = $sum[$value->package_id][$value->order_id];
            $ft_log->input_kg_sum = $sumin[$value->package_id][$value->order_id];
            $ft_log->output_kg_sum = $sumout[$value->package_id][$value->order_id];
            $ft_log->save();
        }
    }
}
