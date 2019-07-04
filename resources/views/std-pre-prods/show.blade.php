@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">StdPreProd {{ $stdpreprod->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/std-pre-prods') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/std-pre-prods/' . $stdpreprod->id . '/edit') }}" title="Edit StdPreProd"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('stdpreprods' . '/' . $stdpreprod->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete StdPreProd" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $stdpreprod->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product</th><td>{{ $stdpreprod->preprod->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rate Per Hour and Man</th><td>{{ $stdpreprod->std_rate_per_h_m }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $stdpreprod->note }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th><td>{{ $stdpreprod->status }}</td>
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
