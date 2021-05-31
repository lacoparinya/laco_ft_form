@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Package {{ $package->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/packages') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/packages/' . $package->id . '/edit') }}" title="Edit Package"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('packages' . '/' . $package->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Package" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $package->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th><td>{{ $package->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Desc</th><td>{{ $package->desc }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kgs per Pack</th><td>{{ $package->kgsperpack }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Number per Box</th><td>{{ $package->numperbox }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th><td>{{ $package->status }}</td>
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
