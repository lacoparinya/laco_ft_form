<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FtMaster;
use App\Product;
use Illuminate\Http\Request;

class FtMastersController extends Controller
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
            $ft_masters = FtMaster::latest()->paginate($perPage);
        } else {
            $ft_masters = FtMaster::latest()->paginate($perPage);
        }

        return view('ft_masters.index', compact('ft_masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $productlist = Product::pluck('name', 'id');
        return view('ft_masters.create', compact('productlist'));
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

        FtMaster::create($requestData);

        return redirect('ft_masters')->with('flash_message', ' added!');
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
        $ft_master = FtMaster::findOrFail($id);

        return view('ft_masters.show', compact('ft_master'));
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
        $productlist = Product::pluck('name', 'id');
        $ft_master = FtMaster::findOrFail($id);


        return view('ft_masters.edit', compact('ft_master', 'productlist'));
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

        $ft_master = FtMaster::findOrFail($id);
        $ft_master->update($requestData);

        return redirect('ft_masters')->with('flash_message', ' updated!');
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
        FtMaster::destroy($id);

        return redirect('ft_masters')->with('flash_message', ' deleted!');
    }
}
