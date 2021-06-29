<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeedDropPack;
use App\Method;
use App\Shift;

class SeedDropPacksController extends Controller
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
            $seeddroppacks = SeedDropPack::latest()->paginate($perPage);
        } else {
            $seeddroppacks = SeedDropPack::latest()->paginate($perPage);
        }

        return view('seed-drop-packs.index', compact('seeddroppacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $methodlist = Method::where('seed_drop_pack_flag',1)->pluck('name', 'id');
        $shiftlist = Shift::pluck('name', 'id');
        return view('seed-drop-packs.create', compact('methodlist', 'shiftlist'));
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

        SeedDropPack::create($requestData);

        return redirect('seed-drop-packs')->with('flash_message', ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seeddroppack = SeedDropPack::findOrFail($id);

        return view('seed-drop-packs.show', compact('seeddroppack'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seeddroppack = SeedDropPack::findOrFail($id);
        $methodlist = Method::where('seed_drop_pack_flag', 1)->pluck('name', 'id');
        $shiftlist = Shift::pluck('name', 'id');
        return view('seed-drop-packs.edit', compact('seeddroppack', 'methodlist', 'shiftlist'));
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

        $seeddroppack = SeedDropPack::findOrFail($id);
        $seeddroppack->update($requestData);

        return redirect('seed-drop-packs')->with('flash_message', ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SeedDropPack::destroy($id);

        return redirect('seed-drop-packs')->with('flash_message', ' deleted!');
    }
}
