<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StdPack;
use App\Method;
use App\Package;
use Illuminate\Http\Request;

class StdPacksController extends Controller
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
            $stdpacks = StdPack::latest()->paginate($perPage);
        } else {
            $stdpacks = StdPack::latest()->paginate($perPage);
        }

        return view( 'std-packs.index', compact( 'stdpacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::pluck('name', 'id');
        return view( 'std-packs.create',compact( 'methodlist', 'packagelist'));
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

        StdPack::create($requestData);

        return redirect( 'std-packs')->with('flash_message', ' added!');
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
        $stdpack = StdPack::findOrFail($id);

        return view( 'std-packs.show', compact( 'stdpack'));
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
        $stdpack = StdPack::findOrFail($id);
        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::pluck('name', 'id');
        return view( 'std-packs.edit', compact( 'stdpack', 'methodlist', 'packagelist'));
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

        $stdpack = StdPack::findOrFail($id);
        $stdpack->update($requestData);

        return redirect( 'std-packs')->with('flash_message', ' updated!');
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
        StdPack::destroy($id);

        return redirect( 'std-packs')->with('flash_message', ' deleted!');
    }
}
