@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">FreezeM {{ $freezem->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/freeze-ms') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/freeze-ms/createDetail/' . $freezem->id ) }}" title="Add FreezeM"><button class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</button></a>

                        
                        <div class="row">
                            <div class="col-md-4">
                            <h3>Date : {{$freezem->process_date}}</h3>
                            </div>
                            <div class="col-md-4">
                            <h3>Job : {{$freezem->iqfjob->name}}</h3>
                            </div>
                             <div class="col-md-4">
                            <h3>Target (kg/hr/person) : {{$freezem->targets}}</h3>
                            </div>
                            <div class="col-md-6">
                            <h3>วัตถุดิบเริ่ม (kg) : {{$freezem->start_RM}}</h3>
                            </div>
                            <div class="col-md-6">
                            <h3>คงเหลือ (kg) : {{ $freezem->start_RM - $freezeall }}</h3>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        @foreach ($iqfmapcollist as $key=>$item)
                                        <th>{{$item}}</th>
                                        @endforeach
                                        <th>Total</th>
                                        <th>Remain</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($freezem->freezed()->orderBy('process_datetime')->get() as $freezeditem)
                                    <tr>
                                        <td>{{ $freezeditem->process_datetime }} / {{ $freezeditem->iqfjob->name or '' }}</td>
                                        @foreach ($iqfmapcollist as $key=>$item)
                                        <td>{{ $freezeditem->$key }}</td>
                                        @endforeach
                                        <td>{{ $freezeditem->output_sum }}</td>
                                        <td>{{ $freezeditem->current_RM }}</td>
                                        <td>
                                            <a href="{{ url('/freeze-ms/editDetail/' . $freezeditem->id) }}" title="Edit FreezeM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/freeze-ms/deleteDetail/' . $freezeditem->id . '/'. $freezeditem->freeze_m_id) }}" title="Delete FreezeM"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
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
