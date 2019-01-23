<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ProductGroup;
use Illuminate\Http\Request;

class ProductGroupsController extends Controller
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
            $productgroups = ProductGroup::where('name','like' , '%'.$keyword.'%')->orWhere('desc', 'like', '%' . $keyword . '%')->paginate($perPage);
        } else {
            $productgroups = ProductGroup::latest()->paginate($perPage);
        }

        return view('product-groups.index', compact('productgroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('product-groups.create');
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

        ProductGroup::create($requestData);

        return redirect('product-groups')->with('flash_message', ' added!');
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
        $productgroup = ProductGroup::findOrFail($id);

        return view('product-groups.show', compact('productgroup'));
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
        $productgroup = ProductGroup::findOrFail($id);

        return view('product-groups.edit', compact('productgroup'));
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

        $productgroup = ProductGroup::findOrFail($id);
        $productgroup->update($requestData);

        return redirect('product-groups')->with('flash_message', ' updated!');
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
        ProductGroup::destroy($id);

        return redirect('product-groups')->with('flash_message', ' deleted!');
    }
}
