@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">StdProcesss {{ $stdprocess->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/std-processs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/std-processs/' . $stdprocess->id . '/edit') }}" title="Edit StdProcesss"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('stdprocesss' . '/' . $stdprocess->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete StdProcesss" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $stdprocess->id }}</td>
                                    </tr>
                                     <tr>
                                        <th>Product</th><td>{{ $stdprocess->product->name }}</td>
                                    </tr>
                                     <tr>
                                        <th>STD Productivity Rate</th><td>{{ $stdprocess->std_rate }}</td>
                                    </tr>
                                     <tr>
                                        <th>Status</th><td>{{ $stdprocess->status }}</td>
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
