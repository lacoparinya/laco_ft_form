@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Timeslots</div>
                    <div class="card-body">
                        <a href="{{ url('/timeslots/create') }}" class="btn btn-success btn-sm" title="Add New Timeslot">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/timeslots') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Gap</th>
                                        <th>Seq</th>
                                        <th>Shift</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($timeslots as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gap }}</td>
                                        <td>{{ $item->seq }}</td>
                                        <td>{{ $item->shift->name }}</td>
                                        <td>
                                            <a href="{{ url('/timeslots/' . $item->id) }}" title="View Timeslot"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/timeslots/' . $item->id . '/edit') }}" title="Edit Timeslot"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/timeslots' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Timeslot" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $timeslots->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
