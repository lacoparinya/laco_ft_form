<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timeslot;
use App\Shift;
use Illuminate\Http\Request;

class TimeslotsController extends Controller
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
            $timeslots = Timeslot::orderBy('seq', 'asc')->paginate($perPage);
        } else {
            $timeslots = Timeslot::orderBy('seq', 'asc')->paginate($perPage);
        }

        return view('timeslots.index', compact('timeslots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $shiftlist = Shift::pluck('name', 'id');
        return view('timeslots.create',compact('shiftlist'));
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

        Timeslot::create($requestData);

        return redirect('timeslots')->with('flash_message', ' added!');
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
        $timeslot = Timeslot::findOrFail($id);

        return view('timeslots.show', compact('timeslot'));
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
        $shiftlist = Shift::pluck('name', 'id');
        $timeslot = Timeslot::findOrFail($id);

        return view('timeslots.edit', compact('timeslot', 'shiftlist'));
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

        $timeslot = Timeslot::findOrFail($id);
        $timeslot->update($requestData);

        return redirect('timeslots')->with('flash_message', ' updated!');
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
        Timeslot::destroy($id);

        return redirect('timeslots')->with('flash_message', ' deleted!');
    }
}
