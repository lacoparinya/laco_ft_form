<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\IqfJob;
use Illuminate\Http\Request;

class IqfJobsController extends Controller
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
            $iqfjobs = IqfJob::latest()->paginate($perPage);
        } else {
            $iqfjobs = IqfJob::latest()->paginate($perPage);
        }

        return view( 'iqf-jobs.index', compact( 'iqfjobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view( 'iqf-jobs.create');
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
        
        IqfJob::create($requestData);

        return redirect( 'iqf-jobs')->with('flash_message', ' added!');
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
        $iqfjob = IqfJob::findOrFail($id);

        return view( 'iqf-jobs.show', compact( 'iqfjob'));
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
        $iqfjob = IqfJob::findOrFail($id);

        return view( 'iqf-jobs.edit', compact( 'iqfjob'));
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

        $iqfjob = IqfJob::findOrFail($id);
        $iqfjob->update($requestData);

        return redirect( 'iqf-jobs')->with('flash_message', ' updated!');
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
        IqfJob::destroy($id);

        return redirect( 'iqf-jobs')->with('flash_message', ' deleted!');
    }
}
