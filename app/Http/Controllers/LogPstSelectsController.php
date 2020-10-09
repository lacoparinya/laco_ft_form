<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\LogPstSelectM;
use App\LogPstSelectD;

use App\PstProduct;
use App\PstType;
use App\Shift;
use App\StdSelectPst;
use Illuminate\Http\Request;

class LogPstSelectsController extends Controller
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
        $status = 'Active';
        $keyword = $request->get('search');
        if (!empty($request->get('status'))) {
            $status = $request->get('status');
        }

        $perPage = 25;

        if (!empty($keyword)) {
            $products = PstProduct::where('name', 'like', '%' . $keyword . '%')->pluck('id')->toArray();
            if (empty($products)) {
                $logpstselects = LogPstSelectM::where('note', 'like', '%' . $keyword . '%')
                    ->orWhere('ref_note', 'like', '%' . $keyword . '%')
                    ->orderBy('process_date', 'DESC')
                    ->paginate($perPage);
            } else {
                $logpstselects = LogPstSelectM::where('note', 'like', '%' . $keyword . '%')
                    ->orWhere('ref_note', 'like', '%' . $keyword . '%')
                    ->orWhereIn('product_id', $products)
                    ->orderBy('process_date', 'DESC')
                    ->paginate($perPage);
            }
        } else {
            $logpstselects = LogPstSelectM::where('status', $status)->orderBy('process_date', 'DESC')->paginate($perPage);
        }

        return view('log-pst-selects.index', compact('logpstselects', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $productlist = PstProduct::pluck('name', 'id');
        //$shiftlist = Shift::pluck('name', 'id');
        $shiftlist = array('2'=>'B');
        $psttypelist = PstType::pluck('name', 'id');
        

        return view('log-pst-selects.create',compact('shiftlist', 'productlist', 'psttypelist'));
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

        $requestData['status'] = 'Active';

        $stdselectpst = StdSelectPst::where('pst_product_id', $requestData['product_id'])
        ->where('status',1)
        ->orderBy('id','desc')
        ->first();

        if(isset($stdselectpst->id)){
            $requestData['std_process_id'] = $stdselectpst->id;
        }
        
        LogPstSelectM::create($requestData);

        return redirect('log-pst-selects')->with('flash_message', 'LogPstSelectM added!');
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
        $logpstselect = LogPstSelectM::findOrFail($id);

        return view('log-pst-selects.show', compact('logpstselect'));
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
        $logpstselect = LogPstSelectM::findOrFail($id);
        $productlist = PstProduct::pluck('name', 'id');
        //$shiftlist = Shift::pluck('name', 'id');
        $shiftlist = array('2' => 'B');
        $psttypelist = PstType::pluck('name', 'id');

        return view('log-pst-selects.edit', compact('logpstselect', 'productlist', 'shiftlist', 'psttypelist'));
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

        $stdselectpst = StdSelectPst::where('pst_product_id', $requestData['product_id'])
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();

        if (isset($stdselectpst->id)) {
            $requestData['std_process_id'] = $stdselectpst->id;
        }


        $logpstselect = LogPstSelectM::findOrFail($id);
        $logpstselect->update($requestData);

        return redirect('log-pst-selects')->with('flash_message', 'LogPstSelectM updated!');
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
        LogPstSelectM::destroy($id);

        return redirect('log-pst-selects')->with('flash_message', 'LogPstSelectM deleted!');
    }

    public function createDetail($log_select_m_id)
    {
        $logpstselectm = LogPstSelectM::findOrFail($log_select_m_id);
        $gradelist = array(
            '-' => '-',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'DEF' => 'DEF',
        );

        $suminputkg = 0;
        $sumoutputkg = 0;

        foreach ($logpstselectm->logpstselectd as $logselectdObj) {
            $suminputkg += $logselectdObj->input_kg;
            $sumoutputkg += $logselectdObj->output_kg;
        }

        return view('log-pst-selects.createDetail', compact('logpstselectm', 'sumoutputpack', 'suminputkg', 'gradelist'));
    }

    public function storeDetail(Request $request, $log_pst_select_m_id)
    {
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');

        if ($request->hasFile('problem_img')) {
            $image = $request->file('problem_img');
            $name = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/pst/' . $log_pst_select_m_id);
            $image->move($destinationPath, $name);

            $requestData['img_path'] = 'images/pst/' . $log_pst_select_m_id  . "/" . $name;
        }

        LogPstSelectD::create($requestData);

        $logselectd = new LogPstSelectD();
        $logselectd->recalculate($log_pst_select_m_id);

        return redirect('log-pst-selects/' . $log_pst_select_m_id)->with('flash_message', ' added!');
    }

    public function editDetail($id)
    {
        $logpstselectd = LogPstSelectD::findOrFail($id);
        $logpstselectm = LogPstSelectM::findOrFail($logpstselectd->log_pst_select_m_id);
        $gradelist = array(
            '-' => '-',
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'DEF' => 'DEF',
        );

        $suminputkg = 0;
        $sumoutputkg = 0;

        foreach ($logpstselectm->logpstselectd as $logselectdObj) {
            $suminputkg += $logselectdObj->input_kg;
            $sumoutputkg += $logselectdObj->output_kg;
        }

        return view('log-pst-selects.editDetail', compact('logpstselectd', 'logpstselectm', 'suminputkg', 'sumoutputkg', 'gradelist'));
    }

    public function updateDetail(Request $request, $id)
    {
        $requestData = $request->all();

        $requestData['process_datetime'] = \Carbon\Carbon::parse($requestData['process_datetime'])->format('Y-m-d H:i');


        $logselectd = LogPstSelectD::findOrFail($id);

        if ($request->hasFile('problem_img')) {
            $image = $request->file('problem_img');
            $name = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/pst/' . $logselectd->log_pst_select_m_id);
            $image->move($destinationPath, $name);

            $requestData['img_path'] = 'images/pst/' . $logselectd->log_pst_select_m_id  . "/" . $name;
        }

        $logselectd->update($requestData);

        $logselectd->recalculate($logselectd->log_pst_select_m_id);

        return redirect('log-pst-selects/' . $logselectd->log_pst_select_m_id)->with('flash_message', ' updated!');
    }

    public function changestatus($log_select_m_id)
    {
        $logselectm = LogPstSelectM::findOrFail($log_select_m_id);

        $status = 'Active';
        if ($logselectm->status == 'Active') {
            $logselectm->status = 'Closed';
            $status = 'Closed';
        } else {
            $logselectm->status = 'Active';
        }

        $logselectm->update();

        return redirect('log-pst-selects/?status=' . $status)->with('flash_message', ' updated!');
    }

    public function groupgraph($date,$pst_type_id)
    {
        if($pst_type_id == 3){
            $logselectids = LogPstSelectM::where('process_date',$date)->where('pst_type_id', $pst_type_id)->pluck( 'id');
            // /var_dump($logselectids);
            $logselectds = LogPstSelectD::whereIn('log_pst_select_m_id', $logselectids)->orderBy('process_datetime')->get();
            
            return view('dashboards.charttimeprocessproductpst', compact('logselectds','date'));
        }
    }

    public function graph($log_select_m_id)
    {
        $logselectm = LogPstSelectM::findOrFail($log_select_m_id);

        return view('dashboards.charttimeproductpst', compact('logselectm'));
    }

    public function forecast($log_select_m_id)
    {
        $logselectm = LogPstSelectM::findOrFail($log_select_m_id);
        $detailData = $logselectm->logpstselectd()->orderBy('process_datetime')->get();

        $totalTime = 0;
        $remainTime = 0;
        $totalinput = 0;
        $totaloutput = 0;
        $totalsum = 0;
        $ratePerHr = 0;
        foreach ($detailData as $key => $value) {
            $totalTime += $value->workhours;
            $totalinput += $value->input_kg;
            $totaloutput += $value->output_kg;
        }

        $remainTime = $logselectm->hourperday - $totalTime;
        $targetResult = $logselectm->targetperday;

        if ($remainTime > 0) {
            $totalsum = $totaloutput;
            $ratePerHr = ($targetResult - $totaloutput) / $remainTime;
        }

        $loop = 0;
        $loopSum = $totalsum;
        $estimateData = array();
        while ($loop < $remainTime) {
            $tmpArray = array();

            if (($remainTime - $loop) > 1) {
                $loop++;
                $tmpArray['time'] = $loop;
                $tmpArray['realrate'] = $ratePerHr;
                $loopSum += $ratePerHr;
                $tmpArray['realtotal'] = $loopSum;
                $estimateData[] = $tmpArray;
            } else {
                if (($remainTime - $loop) > 0) {
                    $tmpArray['realrate'] = $targetResult - $loopSum;

                    $loop = $remainTime;
                    $tmpArray['time'] = $remainTime;



                    $tmpArray['realtotal'] = $targetResult;
                    $estimateData[] = $tmpArray;
                }
            }
        }

        return view('dashboards.charttimeselectforcastpst', compact('logselectm', 'estimateData'));
    }

    public function deleteDetail($id, $log_pst_select_m_id)
    {
        LogPstSelectD::destroy($id);

        $logselectm = LogPstSelectM::findOrFail($log_pst_select_m_id);

        $logselectd = new LogPstSelectD();
        $logselectd->recalculate($logselectm->id);

        return redirect('log-pst-selects/' . $log_pst_select_m_id)->with('flash_message', ' deleted!');
    }

}
