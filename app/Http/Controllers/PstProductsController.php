<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PstProduct;
use Illuminate\Http\Request;

class PstProductsController extends Controller
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
            $pstproducts = PstProduct::latest()->paginate($perPage);
        } else {
            $pstproducts = PstProduct::latest()->paginate($perPage);
        }

        return view('pst-products.index', compact('pstproducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pst-products.create');
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
        
        PstProduct::create($requestData);

        return redirect('pst-products')->with('flash_message', 'PstProduct added!');
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
        $pstproduct = PstProduct::findOrFail($id);

        return view('pst-products.show', compact('pstproduct'));
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
        $pstproduct = PstProduct::findOrFail($id);

        return view('pst-products.edit', compact('pstproduct'));
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
        
        $pstproduct = PstProduct::findOrFail($id);
        $pstproduct->update($requestData);

        return redirect('pst-products')->with('flash_message', 'PstProduct updated!');
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
        PstProduct::destroy($id);

        return redirect('pst-products')->with('flash_message', 'PstProduct deleted!');
    }
}
