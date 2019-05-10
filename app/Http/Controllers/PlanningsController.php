<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Planning;
use App\Job;
use Illuminate\Http\Request;

class PlanningsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $plannings = Planning::latest()->paginate($perPage);
        } else {
            $plannings = Planning::latest()->paginate($perPage);
        }

        return view( 'plannings.index', compact( 'plannings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $joblist = Job::pluck('name', 'id');
        return view( 'plannings.create',compact( 'joblist'));
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
        
        Planning::create($requestData);

        return redirect( 'plannings')->with('flash_message', ' added!');
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
        $planning = Planning::findOrFail($id);

        return view( 'plannings.show', compact( 'planning'));
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
        $planning = Planning::findOrFail($id);
        $joblist = Job::pluck('name', 'id');
        return view( 'plannings.edit', compact( 'planning','joblist'));
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

        $planning = Planning::findOrFail($id);
        $planning->update($requestData);

        return redirect( 'plannings')->with('flash_message', ' updated!');
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
        Planning::destroy($id);

        return redirect( 'plannings')->with('flash_message', ' deleted!');
    }
}
