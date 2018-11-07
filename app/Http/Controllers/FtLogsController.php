<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FtLog;
use App\Product;
use App\Shift;
use App\Unit;
use Illuminate\Http\Request;

class FtLogsController extends Controller
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
            $ft_logs = FtLog::latest()->paginate($perPage);
        } else {
            $ft_logs = FtLog::latest()->paginate($perPage);
        }

        return view('ft_logs.index', compact('ft_logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $productlist = Product::pluck('name', 'id');
        $shiftlist = Shift::pluck('name', 'id');
        $unitlist = Unit::pluck('name', 'id');
        return view('ft_logs.create',compact('productlist', 'shiftlist', 'unitlist'));
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

        FtLog::create($requestData);

        return redirect('ft_logs')->with('flash_message', ' added!');
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
        $ft_log = FtLog::findOrFail($id);

        return view('ft_logs.show', compact('ft_log'));
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
        $ft_log = FtLog::findOrFail($id);

        $productlist = Product::pluck('name', 'id');
        $shiftlist = Shift::pluck('name', 'id');
        $unitlist = Unit::pluck('name', 'id');

        $process_time_format = date('H:i:s', strtotime($ft_log->process_time)); 

        return view('ft_logs.edit', compact('ft_log','productlist', 'shiftlist', 'unitlist', 'process_time_format'));
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

        $ft_log = FtLog::findOrFail($id);
        $ft_log->update($requestData);

        return redirect('ft_logs')->with('flash_message', ' updated!');
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
        FtLog::destroy($id);

        return redirect('ft_logs')->with('flash_message', ' deleted!');
    }
}
