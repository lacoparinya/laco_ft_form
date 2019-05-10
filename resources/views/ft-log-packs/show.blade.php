@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">FtLogPack {{ $ftlogpack->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/ft-log-packs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/ft-log-packs/' . $ftlogpack->id . '/edit') }}" title="Edit FtLogPack"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('ftlogpacks' . '/' . $ftlogpack->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete FtLogPack" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $ftlogpack->id }}</td>
                                        <th>Date</th><td>{{ $ftlogpack->process_date }}</td>
                                        <th>Time</th><td>{{ $ftlogpack->timeslot->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>กะ</th><td>{{ $ftlogpack->shift->name }}</td>
                                        <th>วิธีการ</th><td>{{ $ftlogpack->method->name }}</td>
                                        <th>บรรจุผลิตภัณฑ์</th><td>{{ $ftlogpack->package->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order No</th><td>{{ $ftlogpack->order->order_no }}</td>
                                        <th>Loading Date</th><td>{{ $ftlogpack->order->loading_date }}</td>
                                        <th>Output (กล่อง หรือ EA)</th><td>{{ number_format($ftlogpack->output_pack,0,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>Output สะสม (กล่อง หรือ EA)</th><td>{{ number_format($ftlogpack->output_pack_sum,0,".",",") }}</td>
                                        <th>Input (kg)</th><td>{{ number_format($ftlogpack->input_kg,0,".",",") }}</td>
                                        <th>Output (kg)</th><td>{{ number_format($ftlogpack->output_kg,0,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>บรรจุได้สะสม</th><td>{{ number_format($ftlogpack->output_kg_sum,0,".",",") }}</td>
                                        <th>STD Productivity</th><td>{{ number_format($ftlogpack->stdpack->std_rate,2,".",",") }}</td>
                                        <th>Productivity</th><td>{{ number_format($ftlogpack->productivity,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>% yeild</th><td>{{ number_format($ftlogpack->yeild_percent,2,".",",") }}</td>
                                        <th>จำนวน</th><td>{{ number_format($ftlogpack->num_pack,2,".",",") }}</td>
                                        <th>Note</th><td>{{  $ftlogpack->note }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
