<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StdSelectPst;
use App\PstProduct;
use Illuminate\Http\Request;

class StdSelectPstsController extends Controller
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
        $stdselectpsts = array();
        if (!empty($keyword)) {

            $listidpstprod = PstProduct::where('name', 'like', '%' . $keyword . '%')->pluck('id','id');
            if($listidpstprod->count() > 0){
                $stdselectpsts = StdSelectPst::where('pst_product_id',$listidpstprod)->paginate($perPage);
            }else{
                $stdselectpsts = StdSelectPst::where('pst_product_id', 0)->paginate($perPage);
            }
        } else {
            $stdselectpsts = StdSelectPst::latest()->paginate($perPage);
        }

        return view('std-select-psts.index', compact('stdselectpsts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $productlist = PstProduct::pluck('name','id');
        $statuslist = array('1'=>'Active','0'=> 'Inactive');
        return view('std-select-psts.create',compact('productlist', 'statuslist'));
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
        
        StdSelectPst::create($requestData);

        return redirect('std-select-psts')->with('flash_message', 'StdSelectPst added!');
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
        $stdselectpst = StdSelectPst::findOrFail($id);

        return view('std-select-psts.show', compact('stdselectpst'));
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
        $stdselectpst = StdSelectPst::findOrFail($id);
        $productlist = PstProduct::pluck('name', 'id');
        $statuslist = array('1' => 'Active', '0' => 'Inactive');

        return view('std-select-psts.edit', compact('stdselectpst', 'productlist', 'statuslist'));
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
        
        $stdselectpst = StdSelectPst::findOrFail($id);
        $stdselectpst->update($requestData);

        return redirect('std-select-psts')->with('flash_message', 'StdSelectPst updated!');
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
        StdSelectPst::destroy($id);

        return redirect('std-select-psts')->with('flash_message', 'StdSelectPst deleted!');
    }
}
