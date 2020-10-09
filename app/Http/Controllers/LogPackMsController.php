<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LogPackM;
use App\LogPackD;
use App\Method;
use App\Package;
use App\Order;
use App\StdPack;
use App\Shift;
use Illuminate\Http\Request;

class LogPackMsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = 'Active';
        $keyword = $request->get('search');
        if (!empty($request->get('status'))) {
            $status = $request->get('status');
        }

        $perPage = 25;

        if (!empty($keyword)) {
            $products = Package::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray();
            if (empty($products)) {
                $logpackms = LogPackM::where('note', 'like', '%' . $keyword . '%')
                    ->orderBy('process_date', 'DESC')
                    ->paginate($perPage);
            } else {
                $logpackms = LogPackM::where('note', 'like', '%' . $keyword . '%')
                    ->orWhereIn('package_id', $products)
                    ->orderBy('process_date', 'DESC')
                    ->paginate($perPage);
            }
        } else {
            $logpackms = LogPackM::where('status', $status)->orderBy('process_date', 'DESC')->paginate($perPage);
        } 

        return view('log-pack-ms.index', compact('logpackms', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::where('status', 'Active')->orderBy('name', 'asc')->pluck('name', 'id');

        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');
        return view('log-pack-ms.create',compact('methodlist', 'packagelist', 'shiftlist'));
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

                if ($package->kgsperpack <> $requestData['kgsperpack']) {
                    $package->kgsperpack = $requestData['kgsperpack'];
                    $package->update($package);
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

        $chk = LogPackM::where('process_date', $requestData['process_date'])
            ->where('method_id', $requestData['method_id'])
            ->where('package_id', $requestData['package_id'])
            ->first();
        if (!empty($chk)) {
         //   return redirect('log-pack-ms')->with('flash_message', 'Duplicate Data')->with('alert_message', 'alert');
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

        //Find and Create STD
        $stdObj = StdPack::where('method_id', $requestData['method_id'])
            ->where('package_id', $requestData['package_id'])
            ->where('status', true)
            ->first();
        if (empty($stdObj)) {
            $tmp = array();

            $tmp['method_id'] = $requestData['method_id'];
            $tmp['package_id'] = $requestData['package_id'];
            $tmp['std_rate'] = 1;
            $tmp['status'] = true;

            $stdObj = StdPack::create($tmp);
        }
        $requestData['std_pack_id'] = $stdObj->id;

        // var_dump($requestData);
        LogPackM::create($requestData);


        //$this->recal($requestData['process_date']);




        //$requestData = $request->all();

        //LogPackM::create($requestData);

        return redirect('log-pack-ms')->with('flash_message', ' added!');
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
        $logpackm = LogPackM::findOrFail($id);

        $sumoutputpack = 0;
        $suminputkg = 0;
        $sumoutputkg = 0;

        foreach ($logpackm->logpackd as $logpackdObj) {
            $sumoutputpack += $logpackdObj->output_pack;
            $suminputkg += $logpackdObj->input_kg;
            $sumoutputkg += $logpackdObj->output_kg;
        }


        return view('log-pack-ms.show', compact('logpackm', 'sumoutputpack', 'suminputkg', 'sumoutputkg'));
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
        $logpackm = LogPackM::findOrFail($id);

        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::where('status', 'Active')->orderBy('name', 'asc')->pluck('name', 'id');
        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');

        return view('log-pack-ms.edit', compact('logpackm', 'methodlist', 'packagelist', 'shiftlist'));
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

                if ($package->kgsperpack <> $requestData['kgsperpack']) {
                    $package->kgsperpack = $requestData['kgsperpack'];
                    $package->update();
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

        $chk = LogPackM::where('process_date', $requestData['process_date'])
            ->where('method_id', $requestData['method_id'])
            ->where('package_id', $requestData['package_id'])
            ->where('id', '!=', $id)
            ->first();
        if (!empty($chk)) {
        //    return redirect('ft-log-packs')->with('flash_message', 'Duplicate Data')->with('alert_message', 'alert');
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

        //$timeSlotObj = Timeslot::findOrFail($requestData['timeslot_id']);

      //  $requestData['time_seq'] = $timeSlotObj->seq;

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
        } else {
           // if ($requestData['kgsperpack'] <> $stdObj->kgsperpack) {

          //      $stdObj->kgsperpack = $requestData['kgsperpack'];
         //       $stdObj->update();
          //  }
        }
        $requestData['std_pack_id'] = $stdObj->id;

        $logpackm = LogPackM::findOrFail($id);
        $logpackm->update($requestData);

        return redirect('log-pack-ms')->with('flash_message', ' updated!');
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
        LogPackM::destroy($id);

        return redirect('log-pack-ms')->with('flash_message', ' deleted!');
    }

    public function createDetail($log_pack_m_id){
        $logpackm = LogPackM::findOrFail($log_pack_m_id);
        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');

        $sumoutputpack = 0;
        $suminputkg = 0;
        $sumoutputkg = 0;

        foreach ($logpackm->logpackd as $logpackdObj) {
            $sumoutputpack += $logpackdObj->output_pack;
            $suminputkg += $logpackdObj->input_kg;
            $sumoutputkg += $logpackdObj->output_kg;
        }

        return view('log-pack-ms.createDetail', compact('logpackm', 'shiftlist', 'sumoutputpack', 'suminputkg', 'sumoutputkg'));
    }

    public function storeDetail(Request $request, $log_pack_m_id){
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');

        if ($request->hasFile('problem_img')) {
            $image = $request->file('problem_img');
            $name = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/pack/' . $log_pack_m_id);
            $image->move($destinationPath, $name);

            $requestData['img_path'] = 'images/pack/' . $log_pack_m_id  . "/" . $name;
        }

        LogPackD::create($requestData);

        $logpackd = new LogPackD();
        $logpackd->recalculate($log_pack_m_id);

        return redirect('log-pack-ms/' . $log_pack_m_id)->with('flash_message', ' added!');
    }

    public function editDetail($id){
        $logpackd = LogPackD::findOrFail($id);
        $logpackm = LogPackM::findOrFail($logpackd->log_pack_m_id);
        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');

        $sumoutputpack = 0;
        $suminputkg = 0;
        $sumoutputkg = 0;

        foreach ($logpackm->logpackd as $logpackdObj) {
            $sumoutputpack += $logpackdObj->output_pack;
            $suminputkg += $logpackdObj->input_kg;
            $sumoutputkg += $logpackdObj->output_kg;
        }

        return view('log-pack-ms.editDetail', compact('logpackd','logpackm', 'shiftlist', 'sumoutputpack', 'suminputkg', 'sumoutputkg'));
    }

    public function updateDetail(Request $request, $id){
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');


        $logpackd = LogPackD::findOrFail($id);

        if ($request->hasFile('problem_img')) {
            $image = $request->file('problem_img');
            $name = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/pack/' . $logpackd->log_pack_m_id);
            $image->move($destinationPath, $name);

            $requestData['img_path'] = 'images/pack/' . $logpackd->log_pack_m_id  . "/" . $name;
        }

        $logpackd->update($requestData);

        $logpackd->recalculate($logpackd->log_pack_m_id);

        return redirect('log-pack-ms/' . $logpackd->log_pack_m_id)->with('flash_message', ' updated!');
    }

    public function changestatus($log_pack_m_id){
        $logpackm = LogPackM::findOrFail($log_pack_m_id);

        $status = 'Active';
        if ($logpackm->status == 'Active') {
            $logpackm->status = 'Closed';
            $status = 'Closed';
        } else {
            $logpackm->status = 'Active';
        }
        //var_dump($logpreparem);
        $logpackm->update();

        // return redirect('freeze-ms?status='. $status, compact('freezem'));
        return redirect('log-pack-ms/?status=' . $status)->with('flash_message', ' updated!');
    }

    public function graph($log_pack_m_id){
        $logpackm = LogPackM::findOrFail($log_pack_m_id);

        return view('dashboards.chartpacknew', compact('logpackm'));
    }

    public function forecast($log_pack_m_id)
    {
        $logpackm = LogPackM::findOrFail($log_pack_m_id);

        $detailData = $logpackm->logpackd()->orderBy('process_datetime')->get();

        $totalTime = 0;
        $remainTime = 0;
        $totalinput = 0;
        $totaloutput = 0;
        $totaloutputpack = 0;
        $totalsum = 0;
        $ratePerHr = 0;
        foreach ($detailData as $key => $value) {
            $totalTime += $value->workhours;
            $totalinput += $value->input_kg;
            $totaloutput += $value->output_kg;
            $totaloutputpack += $value->output_pack;
        }

        $remainTime = $logpackm->hourperday - $totalTime;
        $targetResult = $logpackm->targetperday;

        if ($remainTime > 0) {
                $totalsum = $totaloutputpack;
                $ratePerHr = ($targetResult - $totaloutputpack) / $remainTime;
        }

        $loop = 0;
        $loopSum = $totalsum;
        $estimateData = array();
        while ($loop < $remainTime) {
            $tmpArray = array();

            if (($remainTime - $loop) > 1) {
                $loop++;
                $tmpArray['time'] = $loop;
                $tmpArray['realrate'] = $ratePerHr;
                $loopSum += $ratePerHr;
                $tmpArray['realtotal'] = $loopSum;
                $estimateData[] = $tmpArray;
            } else {
                if (($remainTime - $loop) > 0) {
                    $tmpArray['realrate'] = $targetResult - $loopSum;

                    $loop = $remainTime;
                    $tmpArray['time'] = $remainTime;



                    $tmpArray['realtotal'] = $targetResult;
                    $estimateData[] = $tmpArray;
                }
            }
        }

        return view('dashboards.chartpackforecast', compact('logpackm', 'estimateData'));
    }

    public function deleteDetail($id, $log_pack_m_id){
        LogPackD::destroy($id);

        $logpackm = LogPackM::findOrFail($log_pack_m_id);

        $logpackd = new LogPackD();
        $logpackd->recalculate($logpackm->id);

        return redirect('log-pack-ms/' . $log_pack_m_id)->with('flash_message', ' deleted!');
    }
}
