<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FreezeM;
use App\FreezeD;
use App\IqfMapCol;
use App\IqfJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FreezeMsController extends Controller
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
        if(!empty($request->get('status'))){
            $status = $request->get('status');
        }
        
        $perPage = 25;

        if (!empty($status)) {
            $freezems = FreezeM::where('status',$status)->latest()->paginate($perPage);
        } else {
            $freezems = FreezeM::latest()->paginate($perPage);
        }

        return view('freeze-ms.index', compact('freezems', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //$iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        $iqfjoblist = IqfJob::pluck('name', 'id');
        return view('freeze-ms.create',compact('iqfjoblist'));
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

        FreezeM::create($requestData);

        return redirect('freeze-ms')->with('flash_message', ' added!');
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
        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        $freezem = FreezeM::findOrFail($id);

        $freezeall = 0;

        foreach ($freezem->freezed as $freezedobj) {
            $freezeall += $freezedobj->output_sum;
        }

        return view('freeze-ms.show', compact('freezem', 'iqfmapcollist', 'freezeall'));
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
        $freezem = FreezeM::findOrFail($id);
        $iqfjoblist = IqfJob::pluck('name', 'id');

        

        return view('freeze-ms.edit', compact('freezem', 'iqfjoblist'));
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

        $freezem = FreezeM::findOrFail($id);
        $freezem->update($requestData);

        $freezed = new FreezeD();
        $freezed->recalculate($id, $freezem->start_RM);

        return redirect('freeze-ms')->with('flash_message', ' updated!');
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
        FreezeM::destroy($id);

        return redirect('freeze-ms')->with('flash_message', ' deleted!');
    }

    public function createDetail($freeze_m_id){
        $freezem = FreezeM::findOrFail($freeze_m_id);
        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        $iqfjoblist = IqfJob::pluck('name', 'id');

        $freezeall = 0;

        foreach ($freezem->freezed as $freezedobj) {
            $freezeall += $freezedobj->output_sum;
        }

        return view('freeze-ms.createDetail', compact('freezem', 'iqfjoblist', 'iqfmapcollist', 'freezeall'));
    }

    public function storeDetail(Request $request, $freeze_m_id)
    {

        $requestData = $request->all();

        $freezem = FreezeM::findOrFail($freeze_m_id);

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');

        $requestData['output_sum'] = 0;
        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        foreach ($iqfmapcollist as $key => $value) {
            $requestData['output_sum'] += $requestData[$key];
        }

        FreezeD::create($requestData);

        $freezed = new FreezeD();
        $freezed->recalculate($freezem->id, $freezem->start_RM);

        return redirect('freeze-ms/'. $freeze_m_id)->with('flash_message', ' added!');
    }

    public function editDetail($id)
    {
        $freezed = FreezeD::findOrFail($id);
        $freezem = FreezeM::findOrFail($freezed->freeze_m_id);
        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        $iqfjoblist = IqfJob::pluck('name', 'id');

        $freezeall = 0;

        foreach ($freezem->freezed as $freezedobj) {
            $freezeall += $freezedobj->output_sum;
        }

        return view('freeze-ms.editDetail', compact('freezem', 'iqfmapcollist', 'iqfjoblist', 'freezed', 'freezeall'));
    }

    public function updateDetail(Request $request, $id)
    {

        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');

        $requestData['output_sum'] = 0;
        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        foreach ($iqfmapcollist as $key => $value) {
            $requestData['output_sum'] += $requestData[$key];
        }



        $freezed = FreezeD::findOrFail($id);

       // $requestData['current_RM'] = $freezed->current_RM;

        $freezed->update($requestData);


        $freezed->recalculate($freezed->freeze_m_id, $freezed->freezem->start_RM);

        return redirect('freeze-ms/' . $freezed->freeze_m_id)->with('flash_message', ' updated!');
    }

    public function changestatus($freeze_m_id)
    {
        $freezem = FreezeM::findOrFail($freeze_m_id);
        $status = 'Active';
        if ($freezem->status == 'Active'){
            $freezem->status = 'Closed';
            $status = 'Closed';
        }else{
            $freezem->status = 'Active';
        }
        $freezem->update();

       // return redirect('freeze-ms?status='. $status, compact('freezem'));
        return redirect('freeze-ms/?status=' . $status)->with('flash_message', ' updated!');
    }

    public function graph($freeze_m_id){
        $freezem = FreezeM::findOrFail($freeze_m_id);
        $groupdata = $rawdata = DB::table('freeze_ms')
            ->join('freeze_ds', 'freeze_ds.freeze_m_id', '=', 'freeze_ms.id')
            ->join('iqf_jobs', 'iqf_jobs.id', '=', 'freeze_ds.iqf_job_id')
            ->select(DB::raw('freeze_ds.iqf_job_id,iqf_jobs.name as job,sum(freeze_ds.output_sum)  as sunfreeze'))
            ->where('freeze_ms.id', $freeze_m_id)
            ->groupBy(DB::raw('freeze_ds.iqf_job_id,iqf_jobs.name'))
            ->orderBy(DB::raw('iqf_jobs.name'))
            ->get();

        return view('dashboards.chartfreeze2', compact('freezem', 'groupdata'));
    }

    public function deleteDetail($id, $freeze_m_id){
        FreezeD::destroy($id);

        $freezem = FreezeM::findOrFail($freeze_m_id);

        $freezed = new FreezeD();
        $freezed->recalculate($freezem->id, $freezem->start_RM);

        return redirect('freeze-ms/' . $freeze_m_id)->with('flash_message', ' deleted!');
    }
}
