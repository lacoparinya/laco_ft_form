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
            $ftlogfreezes = FtLogFreeze::latest()->paginate($perPage);
        }

        return view( 'ft-log-freezes.index', compact( 'ftlogfreezes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $prevftlogfreeze = FtLogFreeze::latest()->first();

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

        $requestData['job_id'] = 3;

        if($requestData['prev_current_RM'] == 0){
            $requestData['output_all_sum'] = $requestData['output_sum'];
        }


        if($requestData['recv_RM'] > 0){
            $requestData['start_RM'] = $requestData['recv_RM'];
        }

        if( $requestData['prev_current_RM'] > 0){
            $requestData['use_RM'] = $requestData['prev_current_RM'];
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

        return view( 'ft-log-freezes.show', compact( 'ftlogfreeze'));
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

        return view( 'ft-log-freezes.edit', compact( 'ftlogfreeze'));
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
        FtLogFreeze::destroy($id);

        return redirect( 'ft-log-freezes')->with('flash_message', ' deleted!');
    }
}
