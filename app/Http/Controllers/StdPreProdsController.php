<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StdPreProd;
use App\PreProd;
use Illuminate\Http\Request;

class StdPreProdsController extends Controller
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
            $stdpreprods = StdPreProd::latest()->paginate($perPage);
        } else {
            $stdpreprods = StdPreProd::latest()->paginate($perPage);
        }

        return view( 'std-pre-prods.index', compact( 'stdpreprods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $preprodlist = PreProd::pluck('name', 'id');
        return view( 'std-pre-prods.create',compact( 'preprodlist'));
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
        
        StdPreProd::create($requestData);

        return redirect( 'std-pre-prods')->with('flash_message', ' added!');
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
        $stdpreprod = StdPreProd::findOrFail($id);

        return view( 'std-pre-prods.show', compact( 'stdpreprod'));
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
        $stdpreprod = StdPreProd::findOrFail($id);
        $preprodlist = PreProd::pluck('name', 'id');

        return view( 'std-pre-prods.edit', compact( 'stdpreprod', 'preprodlist'));
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

        $stdpreprod = StdPreProd::findOrFail($id);
        $stdpreprod->update($requestData);

        return redirect( 'std-pre-prods')->with('flash_message', ' updated!');
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
        StdPreProd::destroy($id);

        return redirect( 'std-pre-prods')->with('flash_message', ' deleted!');
    }
}
