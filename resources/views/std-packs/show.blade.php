@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">StdPack {{ $stdpack->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/std-packs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/std-packs/' . $stdpack->id . '/edit') }}" title="Edit StdPack"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('stdpacks' . '/' . $stdpack->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete StdPack" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $stdpack->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>วิธี</th><td>{{ $stdpack->method->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Std rate</th><td>{{ $stdpack->std_rate }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th><td>{{ $stdpack->status }}</td>
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
