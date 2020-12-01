<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StampM;
use App\StampD;
use App\MatPack;
use App\StampMachine;
use App\Shift;
use Illuminate\Http\Request;

class StampMsController extends Controller
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

        if (!empty($keyword)){
            $matpackid = MatPack::where('matname','like','%'.$keyword.'%')->pluck('id')->toArray();
            if (!empty($status)) {
                $stampms = StampM::where('status', $status)
                ->whereIn('mat_pack_id', $matpackid)
                ->orderBy('process_date', 'DESC')
                ->paginate($perPage);
            } else {
                $stampms = StampM::whereIn('mat_pack_id', $matpackid)
                ->orderBy('process_date', 'DESC')
                ->paginate($perPage);
            }            
        }else{
            if (!empty($status)) {
                $stampms = StampM::where('status', $status)->orderBy('process_date', 'DESC')->paginate($perPage);
            } else {
                $stampms = StampM::orderBy('process_date', 'DESC')->paginate($perPage);
            }
        }

        return view('stamp-ms.index', compact('stampms', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $matpacklist = (new MatPack())->getlist();
        $stampmachinelist = StampMachine::pluck('name', 'id');
        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');
        return view('stamp-ms.create', compact('matpacklist', 'stampmachinelist', 'shiftlist'));
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

        StampM::create($requestData);

        return redirect('stamp-ms')->with('flash_message', ' added!');
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
        $stampm = StampM::findOrFail($id);

        return view('stamp-ms.show', compact('stampm'));
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
        $stampm = StampM::findOrFail($id);
        $matpacklist = (new MatPack())->getlist(); 
        $stampmachinelist = StampMachine::pluck('name', 'id');
        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');

        return view('stamp-ms.edit', compact('stampm', 'matpacklist', 'stampmachinelist', 'shiftlist'));
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

        $stampm = StampM::findOrFail($id);
        $stampm->update($requestData);

        return redirect('stamp-ms')->with('flash_message', ' updated!');
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
        StampM::destroy($id);
        
        return redirect('stamp-ms')->with('flash_message', ' deleted!');
    }

    public function createDetail($stamp_m_id){
        $stampm = StampM::findOrFail($stamp_m_id);

        $sumoutput = 0;

        foreach ($stampm->stampd as $stampdObj) {
            $sumoutput += $stampdObj->output;
        }

        return view('stamp-ms.createDetail', compact('stampm', 'sumoutput'));
   
    }

    public function storeDetail(Request $request, $stamp_m_id){
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');

        $requestData['output_sum'] = 0;


        if ($request->hasFile('problem_img')) {
            $image = $request->file('problem_img');
            $name = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/stamp/' . $stamp_m_id);
            $image->move($destinationPath, $name);

            $requestData['img_path'] = 'images/stamp/' . $stamp_m_id  . "/" . $name;
        }

        StampD::create($requestData);

        $stampd = new StampD();
        $stampd->recalculate($stamp_m_id);

        return redirect('stamp-ms/' . $stamp_m_id)->with('flash_message', ' added!');
    }

    public function editDetail($id){
        $stampd = StampD::findOrFail($id);
        $stampm = $stampd->stampm;

        return view('stamp-ms.editDetail', compact('stampd', 'stampm'));
    }

    public function updateDetail(Request $request, $id){
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');


        $stampd = StampD::findOrFail($id);

        if ($request->hasFile('problem_img')) {
            $image = $request->file('problem_img');
            $name = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/stamp/' . $stampd->stamp_m_id);
            $image->move($destinationPath, $name);

            $requestData['img_path'] = 'images/stamp/' . $stampd->stamp_m_id  . "/" . $name;
        }

        $stampd->update($requestData);

        $stampd->recalculate($stampd->stamp_m_id);

        return redirect('stamp-ms/' . $stampd->stamp_m_id)->with('flash_message', ' updated!');
    }

    public function changestatus($stamp_m_id){
        $stampm = StampM::findOrFail($stamp_m_id);

        $status = 'Active';
        if ($stampm->status == 'Active') {
            $stampm->status = 'Closed';
            $status = 'Closed';
        } else {
            $stampm->status = 'Active';
        }
        //var_dump($logpreparem);
        $stampm->update();

        // return redirect('freeze-ms?status='. $status, compact('freezem'));
        return redirect('stamp-ms/?status=' . $status)->with('flash_message', ' updated!');
    }

    public function graph($stamp_m_id)
    {
        $stampm = StampM::findOrFail($stamp_m_id);

        return view('dashboards.chartstamp', compact('stampm'));
    }

    public function forecast($log_pack_m_id)
    {
        $stampm = StampM::findOrFail($log_pack_m_id);

        $detailData = $stampm->stampd()->orderBy('process_datetime')->get();

        $totalTime = 0;
        $remainTime = 0;
        //$totalinput = 0;
        $totaloutput = 0;
        //$totaloutputpack = 0;
        $totalsum = 0;
        $ratePerHr = 0;
        foreach ($detailData as $key => $value) {
            $totalTime += $value->workhours;
           // $totalinput += $value->input_kg;
            $totaloutput += $value->output;
           // $totaloutputpack += $value->output_pack;
        }

        //$remainTime = $logpackm->hourperday - ($totalTime* $stampm->rateperhr);
        $targetResult = $stampm->targetperjob - $totaloutput;

        if ($targetResult > 0) {
            $remainTime = ceil($targetResult/ $stampm->rateperhr);
        }

        $loop = 0;
        $loopSum = $totaloutput;
        $estimateData = array();
        while ($loop < $remainTime) {
            $tmpArray = array();
            //echo $loopSum."/";
            if (($remainTime - $loop) > 1) {
                $loop++;
                $tmpArray['time'] = $loop;
                $tmpArray['realrate'] = $stampm->rateperhr;
                $loopSum += $stampm->rateperhr;
                $tmpArray['realtotal'] = $loopSum;
                $estimateData[] = $tmpArray;
            } else {
                if (($remainTime - $loop) > 0) {

                    $tmpArray['realrate'] = $stampm->targetperjob - $loopSum;
                    
                    $loop = $remainTime;
                    $tmpArray['time'] = $remainTime;

                    $tmpArray['realtotal'] = $stampm->targetperjob;
                    $estimateData[] = $tmpArray;
                }
            }
            //$loop++;
        }

        return view('dashboards.chartstampforecast', compact('stampm', 'estimateData'));
    }

    public function deleteDetail($id, $stamp_m_id)
    {
        StampD::destroy($id);

        $logpackd = new StampD();
        $logpackd->recalculate($stamp_m_id);

        return redirect('stamp-ms/' . $stamp_m_id)->with('flash_message', ' deleted!');
    }
}
