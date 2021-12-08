<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PlanGroup;
use App\PlanRptM;
use App\PlanRptD;

class PlanRptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchdate = $request->get('searchdate');
        $perPage = 25;
        
        if(!empty($searchdate)){
            $planrptms = PlanRptM::where('enter_date', $searchdate)
            ->orderBy('enter_date', 'DESC')
            ->paginate($perPage);
        }else{
            $planrptms = PlanRptM::orderBy('enter_date', 'DESC')
            ->paginate($perPage);
        }

        return view(
            'plan-rpt.index',
            compact('planrptms')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plangrouplist = PlanGroup::where('status','Active')->pluck('name', 'id');
        //dd(date('Y'));
        $prevplanrptm = PlanRptM::where('month', date('m'))
            ->where('year', date('Y'))
            ->where('status', 'Active')
            ->first();
        $prevplanrptds = array();
        // /dd($prevplanrptm);
        if (!empty($prevplanrptm)) {
            foreach ($prevplanrptm->planrptds as $planrptdObj) {
                $prevplanrptds[$planrptdObj->plan_group_id] = $planrptdObj;
            }
        }
        return view(
            'plan-rpt.create',
            compact('plangrouplist' ,'prevplanrptds')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        PlanRptM::where('month', $requestData['month'])
            ->where('year', $requestData['year'])
            ->where('status', 'Active')
            ->update(['status' => 'Inactive']);

        $planrptm = PlanRptM::create($requestData);

        $plangrouplist = PlanGroup::where('status', 'Active')->pluck('name', 'id');
        foreach ($plangrouplist as $plangroupkey => $plangroupvalue) {
            $tmp = array();
            $tmp['plan_rpt_m_id'] = $planrptm->id;
            $tmp['plan_group_id'] = $plangroupkey;
            $tmp['num_delivery_plan'] = $requestData['num_delivery_plan-'. $plangroupkey];
            $tmp['num_confirm'] = $requestData['num_confirm-' . $plangroupkey];
            $tmp['num_packed'] = $requestData['num_packed-' . $plangroupkey];
            $tmp['num_wait'] = $requestData['num_wait-' . $plangroupkey];
            $tmp['num_unconfirm'] = $requestData['num_delivery_plan-' . $plangroupkey] - $requestData['num_confirm-' . $plangroupkey];
            $tmp['num_unpacked'] = $requestData['num_delivery_plan-' . $plangroupkey] - $requestData['num_packed-' . $plangroupkey];
            $tmp['note'] = '-';

            $planrptd = PlanRptD::create($tmp);
        }

        return redirect('plan-rpt')->with('flash_message', ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $planrptm = PlanRptM::findOrFail($id);
       
        return view(
            'plan-rpt.view',
            compact('planrptm') 
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plangrouplist = PlanGroup::where('status', 'Active')->pluck('name', 'id');
        $planrptm = PlanRptM::findOrFail($id);
        $planrptds = array();
        foreach ($planrptm->planrptds as $planrptdObj) {
            $planrptds[$planrptdObj->plan_group_id] = $planrptdObj;
        }
        return view(
            'plan-rpt.edit',
            compact('plangrouplist', 'planrptm', 'planrptds')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $planrptm = PlanRptM::findOrFail($id);

        $planrptm->note = $requestData['note'];
        foreach ($planrptm->planrptds as $planrptdObj) {
            if(isset($requestData['num_delivery_plan-'. $planrptdObj->plan_group_id])){
                $planrptdObj->num_delivery_plan = $requestData['num_delivery_plan-' . $planrptdObj->plan_group_id];
            }
            if (isset($requestData['num_confirm-' . $planrptdObj->plan_group_id])) {
                $planrptdObj->num_confirm = $requestData['num_confirm-' . $planrptdObj->plan_group_id];
                $planrptdObj->num_unconfirm = $planrptdObj->num_delivery_plan - $planrptdObj->num_confirm;
            }
            if (isset($requestData['num_packed-' . $planrptdObj->plan_group_id])) {
                $planrptdObj->num_packed = $requestData['num_packed-' . $planrptdObj->plan_group_id];
                $planrptdObj->num_unpacked = $planrptdObj->num_delivery_plan - $planrptdObj->num_packed;
            }
            if (isset($requestData['num_wait-' . $planrptdObj->plan_group_id])) {
                $planrptdObj->num_wait = $requestData['num_wait-' . $planrptdObj->plan_group_id];
            }

            $planrptdObj->update();
            
        }
        $planrptm->update();
        return redirect('plan-rpt')->with('flash_message', ' Edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $collection = PlanRptD::where('plan_rpt_m_id', $id)->get(['id']);
        PlanRptD::destroy($collection->toArray());

        PlanRptM::destroy($id);

        return redirect('plan-rpt')->with('flash_message', ' deleted!');
    }

    public function getprevdata($month,$year){
        $prevplanrptm = PlanRptM::where('month', $month)
            ->where('year', $year)
            ->where('status', 'Active')
            ->first();
        
        $data = array();
        $data['main'] = $prevplanrptm;
        $data['details'] = $prevplanrptm->planrptds;
        
        return response()->json($data);
    }
}
