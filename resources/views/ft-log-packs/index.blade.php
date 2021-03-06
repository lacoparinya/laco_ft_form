@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>งานแพ็ค <a href="{{ url('/ft-log-packs/create') }}" class="btn btn-success btn-sm" title="Add New FtLogPack">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
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

                        <form method="GET" action="{{ url('/ft-log-packs') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th rowspan=2>วิธี</th>
                                        <th rowspan=2>บรรจุผลิตภัณฑ์</th>
                                        <th rowspan=2>Order<br/>Loading date</th>
                                        <th rowspan=2>Output / สะสม<br/>(กล่อง หรือ EA)</th>
                                        <th colspan=2>(kg)</th>
                                        <th rowspan=2>Productivity</th>
                                        <th rowspan=2>Yeild (%)</th>
                                        <th rowspan=2></th>
                                    </tr>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>เวลา</th>
                                        <th>Input</th>
                                        <th>Output</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($ftlogpacks as $item)
                                    <tr>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->timeslot->name }}</td>
                                        <td>{{ $item->shift->name }}</td>
                                        <td>{{ $item->method->name }}</td>
                                        <td>{{ $item->package->name }}</td>
                                        <td>{{ $item->order->order_no }} <br/> {{ $item->order->loading_date }}</td>
                                        <td>{{ number_format($item->output_pack,0,".",",")}} / {{ number_format($item->output_pack_sum,0,".",",")}}</td>
                                        <td>{{ number_format($item->input_kg,0,".",",") }}</td>
                                        <td>{{ number_format($item->output_kg,0,".",",") }}</td>
                                        <td>{{ number_format($item->productivity,2,".",",") }}</td>
                                        <td>{{ number_format($item->yeild_percent,2,".",",") }}</td>
                                        <td>
                                            <a href="{{ url('/chart/packdatepackage/' . $item->process_date. '/'. $item->package->id . '/'.$item->method->id ) }}" title="รายงานสรุปสะสมตาม เครื่อง และ Package"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/chart/packdatepackageshift/' . $item->process_date. '/'. $item->package->id . '/'.$item->method->id. '/'.$item->shift->id ) }}" title="รายงานสรุปสะสมตาม เครื่อง, Package และ กะ"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            
                                            <a href="{{ url('/ft-log-packs/' . $item->id) }}" title="View FtLogPack"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/ft-log-packs/' . $item->id . '/edit') }}" title="Edit FtLogPack"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>

                                            <form method="POST" action="{{ url('/ft-log-packs' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete FtLogPack" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $ftlogpacks->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
