@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">MatPackRate {{ $matpackrate->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/mat-pack-rates') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/mat-pack-rates/' . $matpackrate->id . '/edit') }}" title="Edit MatPackRate"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('matpackrates' . '/' . $matpackrate->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete MatPackRate" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $matpackrate->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mat Pack</th><td>{{ $matpackrate->matpack->matname }}</td>
                                    </tr>
                                    <tr>
                                        <th>เครื่อง</th><td>{{ $matpackrate->stampmachine->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>STD Rate per Hr</th><td>{{ $matpackrate->rateperhr }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th><td>{{ $matpackrate->status }}</td>
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
