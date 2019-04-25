<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FtLog;
use App\Product;
use App\Shift;
use App\Unit;
use App\Timeslot;
use App\StdProcess;
use Illuminate\Http\Request;

class FtLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
            $ft_logs = FtLog::orderBy('process_date', 'DESC')->orderBy('process_time', 'DESC')->paginate($perPage);
        } else {
            $ft_logs = FtLog::orderBy('process_date', 'DESC')->orderBy('process_time', 'DESC')->paginate($perPage);
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
        $timeslotlist = Timeslot::pluck('name', 'id');
        $gradelist = array(
            '-' => '-',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'DEF' => 'DEF',
        );
        return view('ft_logs.create',compact('productlist', 'shiftlist', 'unitlist', 'gradelist', 'timeslotlist'));
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

        $productGroup = Product::findOrFail($requestData['product_id']);

        $stdData = StdProcess::where('product_id', $productGroup->product_group_id)->where('status', true)->first();

        $requestData['std_process_id'] = $stdData->id;


/*
        $this->validate(
            $request,
            [
                'process_date' => 'required',
                'product_id' => 'required',
                'shift_id' => 'required',
                'timeslot_id' => 'required',
                'std_process_id' => 'required',
                'input_kg' => 'required',
                'output_kg' => 'required',
                'sum_kg' => 'required',
                'num_pk' => 'required',
                'num_pf' => 'required',
                'num_pst' => 'required',
                'line_a' => 'required',
                'line_b' => 'required',
                'ref_note' => 'required',
                'grade' => 'required'
            ]
        );
*/
        $result = FtLog::create($requestData);

        $this->recal($requestData['process_date']);

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
        $timeslotlist = Timeslot::pluck('name', 'id');
        $gradelist = array(
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'DEF' => 'DEF',
        );
        $process_time_format = date('H:i:s', strtotime($ft_log->process_time)); 

        return view('ft_logs.edit', compact('ft_log','productlist', 'shiftlist', 'unitlist', 'process_time_format', 'gradelist', 'timeslotlist'));
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

        $this->validate($request, [
            'process_date' => 'required',
            'product_id' => 'required',
            'shift_id' => 'required',
            'timeslot_id' => 'required',
            'input_kg' => 'required',
            'output_kg' => 'required',
            'sum_kg' => 'required',
            'num_pk' => 'required',
            'num_pf' => 'required',
            'num_pst' => 'required',
            'line_a' => 'required',
            'line_b' => 'required',
            'ref_note' => 'required',
            'grade' => 'required'
        ]);

        $productGroup = Product::findOrFail($requestData['product_id']);

        $stdData = StdProcess::where('product_id', $productGroup->product_group_id)->where('status', true)->first();

        $requestData['std_process_id'] = $stdData->id;

        $ft_log = FtLog::findOrFail($id);
        $ft_log->update($requestData);

        $this->recal($ft_log->process_date);

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
        $ft_log = FtLog::findOrFail($id);
        $deleteDate = $ft_log->process_date;
        FtLog::destroy($id);

        $this->recal($deleteDate);
        return redirect('ft_logs')->with('flash_message', ' deleted!');
    }

    private function recal($date){
        $data = FtLog::where('process_date', $date)->orderBy('process_time')->get();
        $prevCode = "";
        $sum = 0;
        foreach ($data as $key => $value) {
            if($prevCode == $value->product_id){
                $sum = $sum + $value->output_kg;
            }else{
                $sum = $value->output_kg;
            }
            $ft_log = FtLog::find($value->id);

            $ft_log->sum_kg = $sum;
            $ft_log->save();

            $prevCode = $value->product_id;
        }
    }
}
