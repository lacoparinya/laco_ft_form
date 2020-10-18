<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\MatPackRate;
use App\MatPack;
use App\StampMachine;
use Illuminate\Http\Request;

class MatPackRatesController extends Controller
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
            $matpackrates = MatPackRate::latest()->paginate($perPage);
        } else {
            $matpackrates = MatPackRate::latest()->paginate($perPage);
        }

        return view('mat-pack-rates.index', compact('matpackrates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $matpacklist = MatPack::pluck('matname', 'id');
        $stampmachinelist = StampMachine::pluck('name', 'id');

        return view('mat-pack-rates.create',compact('matpacklist', 'stampmachinelist'));
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

        MatPackRate::create($requestData);

        return redirect('mat-pack-rates')->with('flash_message', ' added!');
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
        $matpackrate = MatPackRate::findOrFail($id);

        return view('mat-pack-rates.show', compact('matpackrate'));
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
        $matpackrate = MatPackRate::findOrFail($id);
        $matpacklist = MatPack::pluck('matname', 'id');
        $stampmachinelist = StampMachine::pluck('name', 'id');

        return view('mat-pack-rates.edit', compact('matpackrate','matpacklist', 'stampmachinelist'));
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

        $matpackrate = MatPackRate::findOrFail($id);
        $matpackrate->update($requestData);

        return redirect('mat-pack-rates')->with('flash_message', ' updated!');
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
        MatPackRate::destroy($id);

        return redirect('mat-pack-rates')->with('flash_message', ' deleted!');
    }

    public function getrate(Request $request)
    {
        $matpackid = $request->get('matpackid');
        $stampmachineid = $request->get('stampmachineid');

        $matpackrate = MatPackRate::where('mat_pack_id', $matpackid)
        ->where('stamp_machine_id', $stampmachineid)
        ->where('status', 'Active')
        ->first();
        
        $output['value'] = 0;
        if(!empty($matpackrate)){
            $output['value'] = $matpackrate->rateperhr;
        }
        
        echo json_encode($output);
    }
}
