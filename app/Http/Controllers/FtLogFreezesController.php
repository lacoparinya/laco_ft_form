<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FtLogFreeze;
use Illuminate\Http\Request;
use App\IqfMapCol;
use App\IqfJob;

class FtLogFreezesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $ftlogfreezes = FtLogFreeze::latest()->paginate($perPage);
        } else {
            $ftlogfreezes = FtLogFreeze::orderBy('process_date', 'desc')->orderBy('process_time','desc')->orderBy('iqf_job_id','asc')->paginate($perPage);
        }

        $endList = array();
        foreach ( $ftlogfreezes as $ftlogfreezesObj) {
            if( $ftlogfreezesObj->current_RM == 0){
                $endList[ $ftlogfreezesObj->master_code] = 1; 
            }
        }

        return view( 'ft-log-freezes.index', compact( 'ftlogfreezes', 'endList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $code = $request->input('code');
        //echo $code;
        $prevftlogfreeze = FtLogFreeze::Where('master_code',$code)->latest()->first();

        

        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        $iqfjoblist = IqfJob::pluck('name', 'id');
        return view( 'ft-log-freezes.create',compact( 'iqfmapcollist', 'iqfjoblist', 'prevftlogfreeze'));
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

        $this->validate($request, [
            'output_sum' => 'required|numeric|min:0|not_in:0',
        ]);

        $requestData['job_id'] = 3;

        if($requestData['prev_current_RM'] == 0){
            $requestData['output_all_sum'] = $requestData['output_sum'];
        }

        if ($requestData['prev_current_RM'] > 0) {
            $requestData['use_RM'] = $requestData['prev_current_RM'];
            $requestData['master_code'] = $requestData['prev_master_code'];
        }

        if($requestData['recv_RM'] > 0){
            $requestData['start_RM'] = $requestData['recv_RM'];
            $requestData['master_code'] = $requestData['process_date']."-". $requestData['process_time']."-". $requestData[ 'iqf_job_id'];
        }

        

        FtLogFreeze::create($requestData);

        return redirect( 'ft-log-freezes')->with('flash_message', ' added!');
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
        $ftlogfreeze = FtLogFreeze::findOrFail($id);
        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        return view( 'ft-log-freezes.show', compact( 'ftlogfreeze', 'iqfmapcollist'));
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
        $ftlogfreeze = FtLogFreeze::findOrFail($id);

        $chkData = FtLogFreeze::where('master_code', $ftlogfreeze->master_code)->get();
        $codecount = $chkData->count();

        $iqfmapcollist = IqfMapCol::pluck('name', 'col_name');
        $iqfjoblist = IqfJob::pluck('name', 'id');
        return view( 'ft-log-freezes.edit', compact( 'ftlogfreeze', 'iqfmapcollist', 'iqfjoblist', 'codecount'));
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

        $ftlogfreeze = FtLogFreeze::findOrFail($id);
        $ftlogfreeze->update($requestData);

        $ftlogfreeze->recalculate( $ftlogfreeze->master_code);

        return redirect( 'ft-log-freezes')->with('flash_message', ' updated!');
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
        $delteObj = FtLogFreeze::findOrFail($id);

        $code = $delteObj->master_code;

        if(FtLogFreeze::destroy($id)){

            $delteObj->recalculate( $code);

        }
        return redirect( 'ft-log-freezes')->with('flash_message', ' deleted!');
    }
}
