@extends('layouts.app')

@section('content')
    <div class="container">
        
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>งานคัด <a href="{{ url('/ft_logs/create') }}" class="btn btn-success btn-sm" title="เพิ่มข้อมูล">
                                    <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มข้อมูล
                                </a></h3></div>
                    <div class="card-body">
                        @if(Session::has('flash_message'))
                        @if(Session::has('alert_message'))
                            <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                        @else 
                            <div class="alert alert-success alert-block">
	                        <button type="button" class="close" data-dismiss="alert">×</button>
                        @endif
                        
                                <strong>{{ Session::get('flash_message') }}</strong>
                        </div>
                        @endif
                                <form method="GET" action="{{ url('/ft_logs') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                                <div class="row">
                            <div class="col-md-3">
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                            
                                    </div>
                        </div>
                        <div class="col-md-9">
                                    <div class="input-group"> <button class="btn btn-secondary" type="submit">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                       
                                    </div>
                                    </div>
                        </div>
                                </form>
                            
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan=2>Process</th>
                                        <th rowspan=2>กะ</th>
                                        <th rowspan=2>คัดผลิตภัณท์</th>
                                        <th colspan=2>(kg)</th>
                                        <th colspan=2>รวม(kg)</th>
                                        <th rowspan=2>Yeild (%)</th>
                                        <th rowspan=2>เกรด</th>
                                        <th rowspan=2>หมายเหตุ</th>
                                        <th rowspan=2></th>
                                    </tr>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>เวลา</th>
                                        <th>Input</th>
                                        <th>Output</th>
                                        <th>Input</th>
                                        <th>Output</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($ft_logs as $item)
                                    <tr>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->timeslot->name }}</td>
                                        <td>{{ $item->shift->name }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ number_format($item->input_kg,0,".",",") }}</td>
                                        <td>{{ number_format($item->output_kg,0,".",",") }}</td>
                                        <td>{{ number_format($item->sum_in_kg,0,".",",") }}</td>
                                        <td>{{ number_format($item->sum_kg,0,".",",") }}</td>
                                        <td>{{ number_format(round($item->yeild_percent,2),2,".",",")  }}</td>
                                        <td>{{ $item->grade }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>
                                            <a href="{{ url('/chart/' . $item->process_date) }}" title="สรุปรายวัน"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/charttime/' . $item->process_date) }}" title="สรุปรายชม."><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/charttimeproduct/' . $item->process_date .'/'. $item->product_id) }}" title="สรุปรายชม.ต่อสินค้า"><button class="btn btn-success btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            
                                            <a href="{{ url('/ft_logs/' . $item->id) }}" title="View ft_log"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i></button></a>
                                            
                                            <a href="{{ url('/ft_logs/' . $item->id . '/edit') }}" title="Edit ft_log"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>

                                            <form method="POST" action="{{ url('/ft_logs' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete ft_log" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $ft_logs->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
