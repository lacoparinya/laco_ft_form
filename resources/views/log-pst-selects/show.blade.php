@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>งานคัด {{ $logpstselect->id }}</h3></div>
                    <div class="card-body">

                        <a href="{{ url('/log-pst-selects') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/log-pst-selects/' . $logpstselect->id . '/edit') }}" title="Edit LogSelectM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        @if ($logpstselect->status == 'Active' )
                          <a href="{{ url('/log-pst-selects/createDetail/' . $logpstselect->id ) }}" title="Add Details"><button class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</button></a>
                        @endif
                        <br/>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id">ID</label>
                                {{ $logpstselect->id }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">วันที่</label>
                                {{ $logpstselect->process_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">กะ</label>
                                {{ $logpstselect->shift->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">สินค้า</label>
                                {{ $logpstselect->pstproduct->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวนชม.ที่ใช้ในการผลิต</label>
                                {{ $logpstselect->hourperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวนสินค้าที่ต้องผลิต</label>
                                {{ $logpstselect->targetperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">SAP CODE</label>
                                {{ $logpstselect->ref_note }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">note</label>
                                {{ $logpstselect->note }}
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Time</th>
                                        <th colspan="2">kg</th>
                                        <th rowspan="2">Yeild (%)</th>
                                        <th colspan="2">สะสม kg</th>
                                        <th rowspan="2">คนคัดรวม</th>
                                        <th rowspan="2">เกรด</th>
                                        <th rowspan="2">SAP Code<br/>หมายเหตุ</th>
                                        <th rowspan="2"></th>
                                    </tr>
                                    <tr>
                                        <th>Input</th>
                                        <th>Output</th>
                                        <th>Input</th>
                                        <th>Output</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logpstselect->logpstselectd()->orderBy('process_datetime')->get() as $item)
                                       <tr>
                                            <td>{{ $item->process_datetime }}</td>
                                            <td>{{ $item->input_kg }}</td>
                                            <td>{{ $item->output_kg }}</td>
                                            <td>{{ round($item->yeild_percent,2) }}</td>
                                            <td>{{ $item->sum_in_kg }}</td>
                                            <td>{{ $item->sum_kg }}</td>
                                            <td>{{ $item->num_classify }}</td>
                                            <td>{{ $item->grade }}</td>
                                            <td>{{ $item->ref_note }}<br/>{{ $item->note }}</td>
                                            <td><a href="{{ url('/log-pst-selects/editDetail/' . $item->id) }}" title="Edit FreezeM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/log-pst-selects/deleteDetail/' . $item->id . '/'. $item->log_pst_select_m_id) }}" title="Delete FreezeM"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
                                       </td>
                                        </tr> 
                                    @endforeach
                                    
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
