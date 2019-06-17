@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">IqfMapCol {{ $iqfmapcol->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/iqf-map-cols') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/iqf-map-cols/' . $iqfmapcol->id . '/edit') }}" title="Edit IqfMapCol"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('iqfmapcols' . '/' . $iqfmapcol->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete IqfMapCol" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $iqfmapcol->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th><td>{{ $iqfmapcol->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Col Name</th><td>{{ $iqfmapcol->col_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th><td>{{ $iqfmapcol->status }}</td>
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
