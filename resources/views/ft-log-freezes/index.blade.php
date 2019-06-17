@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>งาน Freeze <a href="{{ url('/ft-log-freezes/create') }}" class="btn btn-success btn-sm" title="Add New FtLogIqf">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
                        </a></h3>

                    </div>
                    <div class="card-body">

                        <form method="GET" action="{{ url('/ft-log-freezes') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date/Time</th>
                                        <th>Product</th>
                                        <th>Freeze รวม</th>
                                        <th>ปริมาณ RM คงเหลือ</th>
                                        <th>Freeze สะสม</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($ftlogfreezes as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->process_date }} / {{ date('H:i',strtotime($item->process_time)) }}</td>
                                        <td>{{ $item->iqfjob->name }}</td>
                                        <td>{{ $item->output_sum }}</td>
                                        <td>{{ $item->current_RM }}</td>
                                        <td>{{ $item->output_all_sum }}</td>
                                        <td>
                                            <a href="{{ url('/chart/freezebydate/' . $item->process_date ) }}" title="รายงานสรุปสะสม Freeze"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-stats" aria-hidden="true"></i></button></a>
                                            
                                            <a href="{{ url('/ft-log-freezes/' . $item->id) }}" title="View FtLogFreeze"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i></button></a>
                                            <a href="{{ url('/ft-log-freezes/' . $item->id . '/edit') }}" title="Edit FtLogFreeze"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></button></a>

                                            <form method="POST" action="{{ url('/ft-log-freezes' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete FtLogFreeze" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $ftlogfreezes->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
