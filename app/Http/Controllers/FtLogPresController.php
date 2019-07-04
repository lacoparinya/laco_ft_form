<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FtLogPre;
use App\PreProd;
use App\StdPreProd;
use App\Shift;
use Illuminate\Http\Request;

class FtLogPresController extends Controller
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
            $ftlogpres = FtLogPre::latest()->paginate($perPage);
        } else {
            $ftlogpres = FtLogPre::latest()->paginate($perPage);
        }

        return view( 'ft-log-pres.index', compact( 'ftlogpres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view( 'ft-log-pres.create');
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
        
        FtLogPre::create($requestData);

        return redirect( 'ft-log-pres')->with('flash_message', ' added!');
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
        $ftlogpre = FtLogPre::findOrFail($id);

        return view( 'ft-log-pres.show', compact( 'ftlogpre'));
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
        $ftlogpre = FtLogPre::findOrFail($id);

        return view( 'ft-log-pres.edit', compact( 'ftlogpre'));
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

        $ftlogpre = FtLogPre::findOrFail($id);
        $ftlogpre->update($requestData);

        return redirect( 'ft-log-pres')->with('flash_message', ' updated!');
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
        FtLogPre::destroy($id);

        return redirect( 'ft-log-pres')->with('flash_message', ' deleted!');
    }
}
