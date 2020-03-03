<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LogPrepareM;
use App\LogPrepareD;
use App\PreProd;
use App\StdPreProd;
use App\Shift;
use Illuminate\Http\Request;

class LogPrepareMsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $status = 'Active';
        $keyword = $request->get('search');
        if (!empty($request->get('status'))) {
            $status = $request->get('status');
        }

        $perPage = 25;

        if (!empty($status)) {
            $logpreparems = LogPrepareM::where('status', $status)->orderBy('process_date','DESC')->paginate($perPage);
        } else {
            $logpreparems = LogPrepareM::orderBy('process_date','DESC')->paginate($perPage);
        }

        return view('log-prepare-ms.index', compact('logpreparems', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $preprodlist = PreProd::orderBy('name')->pluck('name', 'id');
        return view('log-prepare-ms.create',compact('preprodlist'));
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

        $requestData['status'] = 'Active';
        
        LogPrepareM::create($requestData);

        return redirect('log-prepare-ms')->with('flash_message', ' added!');
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
        $logpreparem = LogPrepareM::findOrFail($id);

        return view('log-prepare-ms.show', compact('logpreparem'));
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
        $logpreparem = LogPrepareM::findOrFail($id);
        $preprodlist = PreProd::orderBy('name')->pluck('name', 'id');

        return view('log-prepare-ms.edit', compact('logpreparem', 'preprodlist'));
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

        $logpreparem = LogPrepareM::findOrFail($id);
        $logpreparem->update($requestData);

        return redirect('log-prepare-ms')->with('flash_message', ' updated!');
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
        LogPrepareM::destroy($id);

        return redirect('log-prepare-ms')->with('flash_message', ' deleted!');
    }

    public function createDetail($log_prepare_m_id)
    {
        $logpreparem = LogPrepareM::findOrFail($log_prepare_m_id);
        $preprodlist = PreProd::orderBy('name')->pluck('name', 'id');
        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');

        $suminput = 0;
        $sumoutput = 0;

        foreach ($logpreparem->logprepared as $logpreparedObj) {
            $suminput += $logpreparedObj->input;
            $sumoutput += $logpreparedObj->output;
        }

        

        return view('log-prepare-ms.createDetail', compact('logpreparem', 'preprodlist', 'shiftlist', 'suminput', 'sumoutput'));
    }

    public function storeDetail(Request $request, $log_prepare_m_id)
    {

        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');

        $requestData['input_sum'] = 0;
        $requestData['output_sum'] = 0;

        LogPrepareD::create($requestData);

        $logprepared = new LogPrepareD();
        $logprepared->recalculate($log_prepare_m_id);

        return redirect('log-prepare-ms/' . $log_prepare_m_id)->with('flash_message', ' added!');
    }

    public function editDetail($id)
    {
        $logprepared = LogPrepareD::findOrFail($id);
        $logpreparem = $logprepared->logpreparem;
        $preprodlist = PreProd::orderBy('name')->pluck('name', 'id');
        $shiftlist = Shift::orderBy('name')->pluck('name', 'id');

        return view('log-prepare-ms.editDetail', compact('logprepared', 'logpreparem', 'preprodlist', 'shiftlist'));
    }

    public function updateDetail(Request $request, $id)
    {

        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');


        $logprepared = LogPrepareD::findOrFail($id);

        $logprepared->update($requestData);

        $logprepared->recalculate($logprepared->log_prepare_m_id);

        return redirect('log-prepare-ms/' . $logprepared->log_prepare_m_id)->with('flash_message', ' updated!');
    }

    public function changestatus($log_prepare_m_id)
    {
        $logpreparem = LogPrepareM::findOrFail($log_prepare_m_id);
        
        $status = 'Active';
        if ($logpreparem->status == 'Active') {
            $logpreparem->status = 'Closed';
            $status = 'Closed';
        } else {
            $logpreparem->status = 'Active';
        }
        //var_dump($logpreparem);
        $logpreparem->update();

        // return redirect('freeze-ms?status='. $status, compact('freezem'));
        return redirect('log-prepare-ms/?status=' . $status)->with('flash_message', ' updated!');
    }

    public function graph($log_prepare_m_id)
    {
        $logpreparem = LogPrepareM::findOrFail($log_prepare_m_id);

        return view('dashboards.chartprepare2', compact('logpreparem'));
    }

    public function deleteDetail($id, $log_prepare_m_id)
    {
        LogPrepareD::destroy($id);

        $logpreparem = LogPrepareM::findOrFail($log_prepare_m_id);

        $logprepared = new LogPrepareD();
        $logprepared->recalculate($logpreparem->id);

        return redirect('log-prepare-ms/' . $log_prepare_m_id)->with('flash_message', ' deleted!');
    }

    public function graph2($log_prepare_m_id)
    {
        $logpreparem = LogPrepareM::findOrFail($log_prepare_m_id);

        $detailData = $logpreparem->logprepared()->orderBy('process_datetime')->get();

        $totalTime = 0;
        $remainTime = 0;
        $totalinput = 0;
        $totaloutput = 0;
        $totalsum = 0;
        $ratePerHr = 0;
        $forecastloop = array();
        foreach ($detailData as $key => $value) {
            $totalTime += $value->workhours;
            $totalinput += $value->input;
            $totaloutput += $value->output;
        }

        $targetResult = $logpreparem->target_result;
        foreach ($detailData as $key => $value) {
            if ($value->input == 0 && $value->output == 0){
                $forecastloop[$value->process_datetime] = ($targetResult / $logpreparem->target_workhours) * $value->workhours;
            }else{
                $forecastloop[$value->process_datetime] = 0;
            }
        }

        $remainTime = $logpreparem->target_workhours - $totalTime;
        

        if($remainTime > 0){
            if ($totalinput > 0) {
                $totalsum = $totalinput;
                $ratePerHr = ($targetResult - $totalinput) / $remainTime;
            } else {

                $totalsum = $totaloutput;
                $ratePerHr = ($targetResult - $totaloutput) / $remainTime;
            }
        }

        $loop = 0;
        $loopSum = $totalsum;
        $estimateData = array();
        while ($loop < $remainTime) {
            $tmpArray = array();

            if(($remainTime - $loop) > 1){
                $loop++;
                $tmpArray['time'] = $loop;
                $tmpArray['realrate'] = $ratePerHr;
                $loopSum += $ratePerHr;
                $tmpArray['realtotal'] = $loopSum;
                $estimateData[] = $tmpArray;
            }else{
                if (($remainTime - $loop) > 0) {
                    $tmpArray['realrate'] = $targetResult - $loopSum;

                    $loop = $remainTime;
                    $tmpArray['time'] = $remainTime;
                    
                    
                    
                    $tmpArray['realtotal'] = $targetResult;
                    $estimateData[] = $tmpArray;
                }
            }

            
        }

      //  echo  $totalTime ."-". $remainTime ."-". $totalinput . "-" . $totaloutput . "-" . $ratePerHr;



        return view('dashboards.chartprepare3', compact('logpreparem', 'estimateData', 'forecastloop'));
    }
}
