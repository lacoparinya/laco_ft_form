@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">FtLogFreeze {{ $ftlogfreeze->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/ft-log-freezes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/ft-log-freezes/' . $ftlogfreeze->id . '/edit') }}" title="Edit FtLogFreeze"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('ftlogfreezes' . '/' . $ftlogfreeze->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete FtLogFreeze" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $ftlogfreeze->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th><td>{{ $ftlogfreeze->process_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Time</th><td>{{ substr($ftlogfreeze->process_time,0,5) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Target</th><td>{{ $ftlogfreeze->target }}</td>
                                    </tr>
                                    <tr>
                                        <th>Working Time (ชม.)</th><td>{{ $ftlogfreeze->workhours }}</td>
                                    </tr>
                                    @foreach ($iqfmapcollist as $key=>$item)
                                    <tr>
                                    <th>{{ $item }}</th><td>{{ $ftlogfreeze->$key }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th>รวมฟรีส</th><td>{{ $ftlogfreeze->output_sum }}</td>
                                    </tr>
                                    <tr>
                                        <th>รวมฟรีสสะสม</th><td>{{ $ftlogfreeze->output_all_sum }}</td>
                                    </tr>
                                    <tr>
                                        <th>ปริมาณ RM คงเหลือ</th><td>{{ $ftlogfreeze->current_RM }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $ftlogfreeze->note }}</td>
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
