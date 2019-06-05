@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Timeslot {{ $timeslot->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/timeslots') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/timeslots/' . $timeslot->id . '/edit') }}" title="Edit Timeslot"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('timeslots' . '/' . $timeslot->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Timeslot" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $timeslot->id }}</td>
                                        <th>Name</th><td>{{ $timeslot->name }}</td>
                                        <th>Gap</th><td>{{ $timeslot->gap }}</td>
                                        <th>Seq</th><td>{{ $timeslot->seq }}</td>
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
