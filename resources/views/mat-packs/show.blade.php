@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">MatPack {{ $matpack->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/mat-packs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/mat-packs/' . $matpack->id . '/edit') }}" title="Edit MatPack"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('matpacks' . '/' . $matpack->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete MatPack" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $matpack->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mat Name</th><td>{{ $matpack->matname }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pack Name</th><td>{{ $matpack->packname }}</td>
                                    </tr>
                                    <tr>
                                        <th>STD Rate per Hr</th><td>{{ $matpack->stdrateperhr }}</td>
                                    </tr>
                                    <tr>
                                        <th>Satus</th><td>{{ $matpack->status }}</td>
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
