<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 10;

        if (!empty($keyword)) {
            $packages = Package::where('name', 'like', '%' . $keyword . '%')
                ->paginate($perPage);
        } else {
            $packages = Package::latest()->paginate($perPage);
        }

        return view( 'packages.index', compact( 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view( 'packages.create');
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

        $requestData['name'] = strtoupper($requestData['name']);
        $requestData['desc'] = strtoupper($requestData['desc']);
        
        Package::create($requestData);

        return redirect( 'packages')->with('flash_message', ' added!');
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
        $package = Package::findOrFail($id);

        return view( 'packages.show', compact( 'package'));
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
        $package = Package::findOrFail($id);

        return view( 'packages.edit', compact( 'package'));
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

        $requestData['name'] = strtoupper($requestData['name']);
        $requestData['desc'] = strtoupper($requestData['desc']);

        $package = Package::findOrFail($id);
        $package->update($requestData);

        return redirect( 'packages')->with('flash_message', ' updated!');
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
        Package::destroy($id);

        return redirect( 'packages')->with('flash_message', ' deleted!');
    }
}
