@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>สรุปงานคัด</h3></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>สินค้า</th>
                                        <th>Input</th>
                                        <th>Output</th>
                                        <th>Yeild</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($rawdata as $item)
                                    <tr>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ number_format($item->suminput,0,".",",") }}</td>
                                        <td>{{ number_format($item->sumoutput,0,".",",") }}</td>
                                        <td>{{ number_format($item->yeilds,0,".",",") }}</td>
                                        <td>
                                            <a href="{{ url('/summary/' . $item->process_date) }}" title="สรุปรายวัน"><button class="btn btn-normal btn-sm"><i class="glyphicon glyphicon-leaf" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/chart/' . $item->process_date) }}" title="สรุปรายวัน"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/charttime/' . $item->process_date) }}" title="สรุปรายชม."><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/charttimeproduct/' . $item->process_date .'/'. $item->product_id) }}" title="สรุปรายชม.ต่อสินค้า"><button class="btn btn-success btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            
                                            
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
