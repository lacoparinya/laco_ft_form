<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StdIqf;
use App\IqfJob;
use App\Mechine;
use Illuminate\Http\Request;

class StdIqfsController extends Controller
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
            $stdiqfs = StdIqf::latest()->paginate($perPage);
        } else {
            $stdiqfs = StdIqf::latest()->paginate($perPage);
        }

        return view('std-iqfs.index', compact( 'stdiqfs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $iqfjoblist = IqfJob::pluck('name', 'id');
        $mechinelist = Mechine::pluck('name', 'id');

        return view( 'std-iqfs.create',compact( 'iqfjoblist', 'mechinelist'));
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
        
        StdIqf::create($requestData);

        return redirect( 'std-iqfs')->with('flash_message', ' added!');
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
        $stdiqf = StdIqf::findOrFail($id);

        return view( 'std-iqfs.show', compact( 'stdiqf'));
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
        $stdiqf = StdIqf::findOrFail($id);
        $iqfjoblist = IqfJob::pluck('name', 'id');
        $mechinelist = Mechine::pluck('name', 'id');

        return view( 'std-iqfs.edit', compact( 'stdiqf', 'iqfjoblist', 'mechinelist'));
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

        $stdiqf = StdIqf::findOrFail($id);
        $stdiqf->update($requestData);

        return redirect( 'std-iqfs')->with('flash_message', ' updated!');
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
        StdIqf::destroy($id);

        return redirect( 'std-iqfs')->with('flash_message', ' deleted!');
    }
}
