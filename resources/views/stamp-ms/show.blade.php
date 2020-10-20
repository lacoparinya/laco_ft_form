@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>รายการในงานStamp #{{ $stampm->id }}</h3></div>
                    <div class="card-body">

                        <a href="{{ url('/stamp-ms') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/stamp-ms/createDetail/' . $stampm->id ) }}" title="Add StampD"><button class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</button></a>

                        <br/>
                        
                        <div class="row">
                            <div class="col-md-1">
                                <label for="id">ID:</label>
                                {{ $stampm->id }}
                            </div>
                            <div class="col-md-2">
                                <label for="id">Date / กะ:</label>
                                {{ $stampm->process_date }} / {{ $stampm->shift->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">เครื่อง:</label>
                                {{ $stampm->stampmachine->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ผลิตภัณฑ์:</label>
                                {{ $stampm->matpack->matname }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Packageing:</label>
                                {{ $stampm->matpack->packname }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Order No:</label>
                                {{ $stampm->order_no }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Pack Date:</label>
                                {{ $stampm->pack_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">เป้าพนักงาน / มาจริง:</label>
                                {{ $stampm->staff_target }} / {{ $stampm->staff_actual }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ผู้ดูแล:</label>
                                {{ $stampm->staff_operate }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Status:</label>
                                {{ $stampm->status }}
                            </div>
                            <div class="col-md-9">
                                <label for="id">Note:</label>
                                {{ $stampm->note }}
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date/Time</th>
                                        <th>Output</th>
                                        <th>สะสม Output</th>
                                        <th>Note / ปัญหา</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stampm->stampd()->orderBy('process_datetime')->get() as $item)
                                        <tr>
                                        <td>{{ date('H:i',strtotime($item->process_datetime)) }}</td>
                                        <td>{{ $item->output }}</td>
                                        <td>{{ $item->outputSum }}</td>
                                        <td>{{ $item->note }}
                                        @if (!empty($item->problem))
                                            <br/>{{ $item->problem }}
                                        @endif
                                        </td>
                                        <td>   <a href="{{ url('/stamp-ms/editDetail/' . $item->id) }}" title="Edit Stamp D"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/stamp-ms/deleteDetail/' . $item->id . '/'. $item->stamp_m_id) }}" title="Delete Stamp D"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
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
