@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h2>งานเตรียมการ <a href="{{ url('/ft-log-pres/create') }}" class="btn btn-success btn-sm" title="Add New FtLogPre">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
                        </a></h2></div>
                    <div class="card-body">
                        

                        <form method="GET" action="{{ url('/ft-log-pres') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>Date/Time</th>
                                        <th>ผลิตภัณฑ์</th>
                                        <th>กะ</th>
                                        <th>Target</th>
                                        <th>output</th>
                                        <th>สะสม</th>
                                        <th>จำนวนเตรียมการ</th>
                                        <th>จำนวน IQF/F</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($ftlogpres as $item)
                                    <tr>
                                        <td>{{ $item->process_date }} / {{ date('H:i',strtotime($item->process_time)) }}</td>
                                        <td>{{ $item->preprod->name }}</td>
                                        <td>{{ $item->shift->name }}</td>
                                        <td>{{ $item->targets }}</td>
                                        <td>{{ $item->output }}</td>
                                        <td>{{ $item->output_sum }}</td>
                                        <td>{{ $item->num_pre }}</td>
                                        <td>{{ $item->num_iqf }}</td>
                                        <td> 
                                            <a href="{{ url('/charttime/prepareinput/' . $item->process_date. '/'. $item->preprod->id . '/'.$item->shift->id ) }}" title="รายงานสรุปสะสมตาม เครื่อง และ Package"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i> Input</button></a>
                                           <a href="{{ url('/charttime/prepareoutput/' . $item->process_date. '/'. $item->preprod->id . '/'.$item->shift->id ) }}" title="รายงานสรุปสะสมตาม เครื่อง และ Package"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i> Output</button></a>
                                           
                                            <a href="{{ url('/ft-log-pres/' . $item->id) }}" title="View FtLogPre"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/ft-log-pres/' . $item->id . '/edit') }}" title="Edit FtLogPre"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/ft-log-pres' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete FtLogPre" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $ftlogpres->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
