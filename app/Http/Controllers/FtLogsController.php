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
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        
        if($user->group->name == 'user_pack'){
            return redirect('ft-log-packs');
        } elseif ( $user->group->name == 'user_freeze'){
            return redirect('ft-log-freezes');
        } elseif ($user->group->name == 'user_prepare') {
            return redirect('ft-log-pres');
        }
        
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $products = Product::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray();
            if(empty($products)){
                $ft_logs = FtLog::where('note', 'like', '%' . $keyword . '%')
                    ->orderBy('process_date', 'DESC')
                    ->orderBy('timeslot_id', 'DESC')
                    ->paginate($perPage);
            }else{
                $ft_logs = FtLog::where('note', 'like', '%' . $keyword . '%')
                    ->orWhereIn('product_id',$products)
                    ->orderBy('process_date', 'DESC')
                    ->orderBy('timeslot_id', 'DESC')
                    ->paginate($perPage);
            }
        } else {
            $ft_logs = FtLog::orderBy('process_date', 'DESC')->orderBy( 'timeslot_id', 'DESC')->paginate($perPage);
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

        $chk = FtLog::where('process_date', $requestData['process_date'])
            ->where('timeslot_id', $requestData[ 'timeslot_id'])
            ->where('product_id', $requestData[ 'product_id'])
            ->first();
        if(!empty($chk)){
            return redirect('ft_logs')->with('flash_message', 'Duplicate Data')->with('alert_message','alert');
        }


        $productGroup = Product::findOrFail($requestData['product_id']);

        $stdData = StdProcess::where('product_id', $productGroup->product_group_id)->where('status', true)->first();

        $requestData['std_process_id'] = $stdData->id;

        $timeSlotObj = Timeslot::findOrFail($requestData['timeslot_id']);

        $requestData['time_seq'] = $timeSlotObj->seq;
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


        $chk = FtLog::where('process_date', $requestData['process_date'])
            ->where('timeslot_id', $requestData['timeslot_id'])
            ->where('product_id', $requestData['product_id'])
            ->where('id', '!=', $id)
            ->first();
        if (!empty($chk)) {
            return redirect('ft_logs')->with('flash_message', 'Duplicate Data')->with('alert_message', 'alert');
        }

        $productGroup = Product::findOrFail($requestData['product_id']);

        $stdData = StdProcess::where('product_id', $productGroup->product_group_id)->where('status', true)->first();

        $requestData['std_process_id'] = $stdData->id;

        $timeSlotObj = Timeslot::findOrFail($requestData['timeslot_id']);

        $requestData['time_seq'] = $timeSlotObj->seq;

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
        return redirect('ft_logs')->with('flash_message', ' deleted!')->with('alert_message', 'alert');
    }

    private function recal($date){
        $data = FtLog::where('process_date', $date)->orderBy('time_seq')->get();
        $prevCode = "";
        $sum = array();
        $sumin = array();
        foreach ($data as $key => $value) {
            if(isset($sum[$value->product_id])){
                $sum[$value->product_id] = $sum[$value->product_id] + $value->output_kg;
                $sumin[$value->product_id] = $sum[$value->product_id] + $value->input_kg;
            }else{
                $sum[$value->product_id] = $value->output_kg;
                $sumin[$value->product_id] = $value->input_kg;
            }
            $ft_log = FtLog::find($value->id);

            $ft_log->sum_kg = $sum[$value->product_id];
            $ft_log->sum_in_kg = $sumin[$value->product_id];
            $ft_log->save();
        }
    }
}

