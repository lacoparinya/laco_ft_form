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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $products = PreProd::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray();
            if (empty($products)) {
                $ftlogpres = FtLogPre::where('note', 'like', '%' . $keyword . '%')
                    ->orderBy('process_date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->paginate($perPage);
            } else {
                $ftlogpres = FtLogPre::where('note', 'like', '%' . $keyword . '%')
                    ->orWhereIn('pre_prod_id', $products)
                    ->orderBy('process_date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->paginate($perPage);
            }
        } else {
            $ftlogpres = FtLogPre::orderBy('process_date', 'DESC')->orderBy('id', 'DESC')->paginate($perPage);
        } 
/*
        if (!empty($keyword)) {
            $ftlogpres = FtLogPre::latest()->paginate($perPage);
        } else {
            $ftlogpres = FtLogPre::latest()->paginate($perPage);
        }
        */

        return view( 'ft-log-pres.index', compact( 'ftlogpres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $shiftlist = Shift::pluck('name', 'id');
        $preprodlist = PreProd::orderBy('name')->pluck('name', 'id');
        return view( 'ft-log-pres.create',compact( 'shiftlist', 'preprodlist'));
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

        $stdpreprod = StdPreProd::where('pre_prod_id', $requestData[ 'pre_prod_id'])->where('status',1)->first();

        if(empty( $stdpreprod->id)){
            $tmp = array();
            $tmp[ 'pre_prod_id'] = $requestData['pre_prod_id'];
            $tmp[ 'std_rate_per_h_m'] = 1;
            $tmp['note'] = 'Aut Gen';
            $tmp['status'] = 1;

            $stdpreprod = StdPreProd::create($tmp);

            $requestData['std_pre_prod_id'] = $stdpreprod->id;

        }else{
            $requestData[ 'std_pre_prod_id'] = $stdpreprod->id;

        }

        $requestData['status'] = 'Active';

        FtLogPre::create($requestData);

        $ftlogpre = new FtLogPre;
        $ftlogpre->recalculate( $requestData[ 'process_date'], $requestData[ 'shift_id'], $requestData[ 'pre_prod_id']);

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
        $shiftlist = Shift::pluck('name', 'id');
        $preprodlist = PreProd::orderBy('name')->pluck('name', 'id');

        return view( 'ft-log-pres.edit', compact( 'ftlogpre', 'shiftlist', 'preprodlist'));
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


        $stdpreprod = StdPreProd::where('pre_prod_id', $requestData['pre_prod_id'])->where('status', 1)->first();

        if (empty($stdpreprod->id)) {
            $tmp = array();
            $tmp['pre_prod_id'] = $requestData['pre_prod_id'];
            $tmp['std_rate_per_h_m'] = 1;
            $tmp['note'] = 'Aut Gen';
            $tmp['status'] = 1;

            $stdpreprod = StdPreProd::create($tmp);

            $requestData['std_pre_prod_id'] = $stdpreprod->id;
        } else {
            $requestData['std_pre_prod_id'] = $stdpreprod->id;
        }

        $ftlogpre = FtLogPre::findOrFail($id);
        $ftlogpre->update($requestData);
        $ftlogpre->recalculate( $ftlogpre->process_date, $ftlogpre->shift_id, $ftlogpre->pre_prod_id);

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
