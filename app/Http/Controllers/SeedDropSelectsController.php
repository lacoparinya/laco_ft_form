<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeedDropSelect;
use App\Shift;

class SeedDropSelectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $seeddropselects = SeedDropSelect::latest()->paginate($perPage);
        } else {
            $seeddropselects = SeedDropSelect::latest()->paginate($perPage);
        }

        return view('seed-drop-selects.index', compact('seeddropselects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shiftlist = Shift::pluck('name', 'id');
        return view('seed-drop-selects.create', compact('shiftlist'));
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

        SeedDropSelect::create($requestData);

        return redirect('seed-drop-selects')->with('flash_message', ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seeddropselect = SeedDropSelect::findOrFail($id);

        return view('seed-drop-selects.show', compact('seeddropselect'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seeddropselect = SeedDropSelect::findOrFail($id);
        $shiftlist = Shift::pluck('name', 'id');
        return view('seed-drop-selects.edit', compact('seeddropselect', 'shiftlist'));
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

        $seeddropselect = SeedDropSelect::findOrFail($id);
        $seeddropselect->update($requestData);

        return redirect('seed-drop-selects')->with('flash_message', ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SeedDropSelect::destroy($id);

        return redirect('seed-drop-selects')->with('flash_message', ' deleted!');
    }
}
