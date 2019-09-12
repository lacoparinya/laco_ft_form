@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">งานเตรียมการ {{ $logpreparem->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/log-prepare-ms') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        @if ($logpreparem->status == 'Active' )
                          <a href="{{ url('/log-prepare-ms/createDetail/' . $logpreparem->id ) }}" title="Add FreezeM"><button class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</button></a>
                        @endif
                        
                        
                        <br/>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id">ID</label>
                                {{ $logpreparem->id }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Date</label>
                                {{ $logpreparem->process_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ผลิตภัณฑ์</label>
                                {{ $logpreparem->preprod->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวน</label>
                                {{ $logpreparem->logprepared->count() }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id">สะสม Input/Output : </label>
                                @php
                                    $inputsum = 0;
                                    $outputsum = 0;
                                    foreach( $logpreparem->logprepared as $item){
                                        $inputsum += $item->input;
                                        $outputsum += $item->output;
                                    }
                                    echo $inputsum." / ".$outputsum;
                                @endphp
                            </div>
                            <div class="col-md-3">
                                <label for="id">แผนการทำงานต่อชม.(kg/hr/คน)</label>
                                {{ $logpreparem->targetperhr }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">เป้าที่ต้องผลิตได้ (kg)</label>
                                {{ $logpreparem->target_result }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">เป้าชม.ที่ใช้ผลิตเสร็จ (hrs)</label>
                                {{ $logpreparem->target_workhours }}
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Time
                                        </th>
                                        <th>
                                            ผลิตภัณฑ์
                                        </th>
                                        <th>
                                            Input/Output
                                        </th>
                                        <th>
                                            สะสม Input/Output
                                        </th>
                                        <th>
                                            เตรียมการ / IQF / รวม
                                        </th>
                                        <th>
                                            Note
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logpreparem->logprepared()->orderBy('process_datetime')->get() as $item)
                                        <tr>
                                            <td>{{ date('H:i',strtotime($item->process_datetime)) }}</td>
                                            <td>{{ $item->preprod->name }}</td>
                                            <td>{{ $item->input }} / {{ $item->output }}</td>
                                            <td>{{ $item->input_sum }} / {{ $item->output_sum }}</td>
                                            <td>{{ $item->num_pre }} / {{ $item->num_iqf }} / {{ $item->num_all }}</td>
                                            <td>{{ $item->note }}</td>
                                            <td>
                                            <a href="{{ url('/log-prepare-ms/editDetail/' . $item->id) }}" title="Edit FreezeM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/log-prepare-ms/deleteDetail/' . $item->id . '/'. $item->log_prepare_m_id) }}" title="Delete FreezeM"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
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
