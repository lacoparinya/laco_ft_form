<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\IqfMapCol;
use Illuminate\Http\Request;

class IqfMapColsController extends Controller
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
            $iqfmapcols = IqfMapCol::latest()->paginate($perPage);
        } else {
            $iqfmapcols = IqfMapCol::latest()->paginate($perPage);
        }

        return view( 'iqf-map-cols.index', compact( 'iqfmapcols'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view( 'iqf-map-cols.create');
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
        
        IqfMapCol::create($requestData);

        return redirect( 'iqf-map-cols')->with('flash_message', ' added!');
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
        $iqfmapcol = IqfMapCol::findOrFail($id);

        return view( 'iqf-map-cols.show', compact( 'iqfmapcol'));
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
        $iqfmapcol = IqfMapCol::findOrFail($id);

        return view( 'iqf-map-cols.edit', compact( 'iqfmapcol'));
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

        $iqfmapcol = IqfMapCol::findOrFail($id);
        $iqfmapcol->update($requestData);

        return redirect( 'iqf-map-cols')->with('flash_message', ' updated!');
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
        IqfMapCol::destroy($id);

        return redirect( 'iqf-map-cols')->with('flash_message', ' deleted!');
    }
}
