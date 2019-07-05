@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h2>งานเตรียมการ ของ ID {{ $ftlogpre->id }}</h2></div>
                    <div class="card-body">

                        <a href="{{ url('/ft-log-pres') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/ft-log-pres/' . $ftlogpre->id . '/edit') }}" title="Edit FtLogPre"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('ftlogpres' . '/' . $ftlogpre->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete FtLogPre" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $ftlogpre->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date / Time / กะ</th><td>{{ $ftlogpre->process_date }} / {{ date('H:i',strtotime($ftlogpre->process_time)) }} / {{ $ftlogpre->shift->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>ผลิตภัณฑ์</th><td>{{ $ftlogpre->preprod->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Target</th><td>{{ $ftlogpre->targets }}</td>
                                    </tr>
                                    <tr>
                                        <th>Input / Output</th><td>{{ $ftlogpre->input }} / {{ $ftlogpre->output }}</td>
                                    </tr>
                                    <tr>
                                        <th>สะสม Input / Output</th><td>{{ $ftlogpre->input_sum }} / {{ $ftlogpre->output_sum }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $ftlogpre->note }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th><td>{{ $ftlogpre->status }}</td>
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
