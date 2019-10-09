<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LogSelectM;
use App\LogSelectD;
use App\Product;
use App\Shift;
use App\Unit;
use App\StdProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogSelectMsController extends Controller
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

        $user = Auth::user();

        if ($user->group->name == 'user_pack') {
            return redirect('log-pack-ms');
        } elseif ($user->group->name == 'user_freeze') {
            return redirect('freeze-ms');
        } elseif ($user->group->name == 'user_prepare') {
            return redirect('log-prepare-ms');
        }

        $status = 'Active';
        $keyword = $request->get('search');
        if (!empty($request->get('status'))) {
            $status = $request->get('status');
        }

        $perPage = 25;

        if (!empty($status)) {
            $logselectms = LogSelectM::where('status', $status)->orderBy('process_date', 'DESC')->paginate($perPage);
        } else {
            $logselectms = LogSelectM::orderBy('process_date', 'DESC')->paginate($perPage);
        }

        return view('log-select-ms.index', compact('logselectms','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $productlist = Product::pluck('name', 'id');
        $shiftlist = Shift::pluck('name', 'id');
        $unitlist = Unit::pluck('name', 'id');
        
        return view('log-select-ms.create',compact('productlist', 'shiftlist', 'unitlist', 'gradelist'));
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

        $stdData = StdProcess::where('product_id', $requestData['product_id'])->where('status', true)->first();

        if(empty($stdData)){
            $tmpStdProcess = array();
            $tmpStdProcess['product_id'] = $requestData['product_id'];
            $tmpStdProcess['std_rate'] = 1;
            $tmpStdProcess['status'] = true;
            $stdData = StdProcess::create($tmpStdProcess);
        }

        $requestData['std_process_id'] = $stdData->id;
        $requestData['status'] = 'Active';

        LogSelectM::create($requestData);

        return redirect('log-select-ms')->with('flash_message', ' added!');
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
        $logselectm = LogSelectM::findOrFail($id);

        return view('log-select-ms.show', compact('logselectm'));
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
        $productlist = Product::pluck('name', 'id');
        $shiftlist = Shift::pluck('name', 'id');
        
        $gradelist = array(
            '-' => '-',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'DEF' => 'DEF',
        );
        $logselectm = LogSelectM::findOrFail($id);

        return view('log-select-ms.edit', compact('logselectm', 'productlist', 'shiftlist', 'gradelist'));
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

        $stdData = StdProcess::where('product_id', $requestData['product_id'])->where('status', true)->first();

        if (empty($stdData)) {
            $tmpStdProcess = array();
            $tmpStdProcess['product_id'] = $requestData['product_id'];
            $tmpStdProcess['std_rate'] = 1;
            $tmpStdProcess['status'] = true;
            $stdData = StdProcess::create($tmpStdProcess);
        }
        $requestData['std_process_id'] = $stdData->id;


        $logselectm = LogSelectM::findOrFail($id);
        $logselectm->update($requestData);

        return redirect('log-select-ms')->with('flash_message', ' updated!');
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
        LogSelectM::destroy($id);

        return redirect('log-select-ms')->with('flash_message', ' deleted!');
    }

    public function createDetail($log_select_m_id){
        $logselectm = LogSelectM::findOrFail($log_select_m_id);
        $unitlist = Unit::pluck('name', 'id');
        $gradelist = array(
            '-' => '-',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'DEF' => 'DEF',
        );

        $suminputkg = 0;
        $sumoutputkg = 0;

        foreach ($logselectm->logselectd as $logselectdObj) {
            $suminputkg += $logselectdObj->input_kg;
            $sumoutputkg += $logselectdObj->output_kg;
        }

        return view('log-select-ms.createDetail', compact('logselectm', 'sumoutputpack', 'suminputkg', 'unitlist', 'gradelist'));
    }

    public function storeDetail(Request $request, $log_select_m_id){
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');

        LogSelectD::create($requestData);

        $logselectd = new LogSelectD();
        $logselectd->recalculate($log_select_m_id);

        return redirect('log-select-ms/' . $log_select_m_id)->with('flash_message', ' added!');
    }
    
    public function editDetail($id){
        $logselectd = LogSelectD::findOrFail($id);
        $logselectm = LogSelectM::findOrFail($logselectd->log_select_m_id);
        $unitlist = Unit::pluck('name', 'id');
        $gradelist = array(
            '-' => '-',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'DEF' => 'DEF',
        );

        $suminputkg = 0;
        $sumoutputkg = 0;

        foreach ($logselectm->logselectd as $logselectdObj) {
            $suminputkg += $logselectdObj->input_kg;
            $sumoutputkg += $logselectdObj->output_kg;
        }

        return view('log-select-ms.editDetail', compact('logselectd', 'logselectm', 'suminputkg', 'sumoutputkg', 'unitlist', 'gradelist'));
    }

    public function updateDetail(Request $request, $id){
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');


        $logselectd = LogSelectD::findOrFail($id);

        $logselectd->update($requestData);

        $logselectd->recalculate($logselectd->log_select_m_id);

        return redirect('log-select-ms/' . $logselectd->log_select_m_id)->with('flash_message', ' updated!');
    }

    public function changestatus($log_select_m_id){
        $logselectm = LogSelectM::findOrFail($log_select_m_id);

        $status = 'Active';
        if ($logselectm->status == 'Active') {
            $logselectm->status = 'Closed';
            $status = 'Closed';
        } else {
            $logselectm->status = 'Active';
        }

        $logselectm->update();

        return redirect('log-select-ms/?status=' . $status)->with('flash_message', ' updated!');
    }

    public function graph($log_select_m_id){
        $logselectm = LogSelectM::findOrFail($log_select_m_id);

        return view('dashboards.charttimeproduct2', compact('logselectm'));
    }

    public function forecast($log_select_m_id){
        $logselectm = LogSelectM::findOrFail($log_select_m_id);
        $detailData = $logselectm->logselectd()->orderBy('process_datetime')->get();

        $totalTime = 0;
        $remainTime = 0;
        $totalinput = 0;
        $totaloutput = 0;
        $totalsum = 0;
        $ratePerHr = 0;
        foreach ($detailData as $key => $value) {
            $totalTime += $value->workhours;
            $totalinput += $value->input_kg;
            $totaloutput += $value->output_kg;
        }

        $remainTime = $logselectm->hourperday - $totalTime;
        $targetResult = $logselectm->targetperday;

        if ($remainTime > 0) {
            $totalsum = $totaloutput;
            $ratePerHr = ($targetResult - $totaloutput) / $remainTime;
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

        return view('dashboards.charttimeselectforcast', compact('logselectm', 'estimateData'));
    }

    public function deleteDetail($id, $log_select_m_id)
    {
        LogSelectD::destroy($id);

        $logselectm = LogSelectM::findOrFail($log_select_m_id);

        $logselectd = new LogSelectD();
        $logselectd->recalculate($logselectm->id);

        return redirect('log-select-ms/' . $log_select_m_id)->with('flash_message', ' deleted!');
    }

}
