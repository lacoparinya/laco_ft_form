@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">PST Seleted Standard {{ $stdselectpst->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/std-select-psts') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/std-select-psts/' . $stdselectpst->id . '/edit') }}" title="Edit StdSelectPst"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('stdselectpsts' . '/' . $stdselectpst->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete StdSelectPst" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $stdselectpst->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product</th><td>{{ $stdselectpst->pstproduct->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Rate</th><td>{{ $stdselectpst->std_rate_per_h_m }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $stdselectpst->note }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th><td>
                                            @if ($stdselectpst->status == '0')
                                                Inactive
                                            @else
                                                Active                                                
                                            @endif

                                        </td>
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
