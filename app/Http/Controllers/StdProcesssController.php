<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StdProcess;
use App\ProductGroup;
use Illuminate\Http\Request;

class StdProcesssController extends Controller
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
            $stdprocesss = StdProcess::latest()->paginate($perPage);
        } else {
            $stdprocesss = StdProcess::latest()->paginate($perPage);
        }

        return view('std-processs.index', compact('stdprocesss'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $productlist = ProductGroup::pluck('name', 'id');
        return view('std-processs.create', compact('productlist'));
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

        StdProcess::create($requestData);

        return redirect('std-processs')->with('flash_message', ' added!');
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
        $stdprocess = StdProcess::findOrFail($id);

        return view('std-processs.show', compact('stdprocess'));
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
        $productlist = ProductGroup::pluck('name', 'id');
        $stdprocess = StdProcess::findOrFail($id);

        return view('std-processs.edit', compact('stdprocess', 'productlist'));
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

        $stdprocess = StdProcess::findOrFail($id);
        $stdprocess->update($requestData);

        return redirect('std-processs')->with('flash_message', ' updated!');
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
        StdProcess::destroy($id);

        return redirect('std-processs')->with('flash_message', ' deleted!');
    }
}
