<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FtLogIqf;
use App\Timeslot;
use App\Mechine;
use App\IqfJob;
use Illuminate\Http\Request;

class FtLogIqfsController extends Controller
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
            $ftlogiqfs = FtLogIqf::latest()->paginate($perPage);
        } else {
            $ftlogiqfs = FtLogIqf::latest()->paginate($perPage);
        }

        return view( 'ft-log-iqfs.index', compact( 'ftlogiqfs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $timeslotlist = Timeslot::pluck('name', 'id');
        $mechinelist = Mechine::pluck('name', 'id');
        $iqfjoblist = IqfJob::pluck('name', 'id');
        return view( 'ft-log-iqfs.create',compact( 'timeslotlist', 'mechinelist', 'iqfjoblist'));
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
        
        FtLogIqf::create($requestData);

        return redirect( 'ft-log-iqfs')->with('flash_message', ' added!');
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
        $ftlogiqf = FtLogIqf::findOrFail($id);

        return view( 'ft-log-iqfs.show', compact( 'ftlogiqf'));
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
        $ftlogiqf = FtLogIqf::findOrFail($id);

        return view( 'ft-log-iqfs.edit', compact( 'ftlogiqf'));
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

        $ftlogiqf = FtLogIqf::findOrFail($id);
        $ftlogiqf->update($requestData);

        return redirect( 'ft-log-iqfs')->with('flash_message', ' updated!');
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
        FtLogIqf::destroy($id);

        return redirect( 'ft-log-iqfs')->with('flash_message', ' deleted!');
    }
}
