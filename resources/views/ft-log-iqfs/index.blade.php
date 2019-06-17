@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>งาน Freeze IQF <a href="{{ url('/ft-log-iqfs/create') }}" class="btn btn-success btn-sm" title="Add New FtLogIqf">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
                        </a></h3>

                    </div>
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
                    <div class="card-body">
                        

                        <form method="GET" action="{{ url('/ft-log-iqfs') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Col Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($ftlogiqfs as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->col_name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="{{ url('/ft-log-iqfs/' . $item->id) }}" title="View FtLogIqf"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/ft-log-iqfs/' . $item->id . '/edit') }}" title="Edit FtLogIqf"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/ft-log-iqfs' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete FtLogIqf" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $ftlogiqfs->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
