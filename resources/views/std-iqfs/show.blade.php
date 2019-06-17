@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">StdIqf {{ $stdiqf->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/std-iqfs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/std-iqfs/' . $stdiqf->id . '/edit') }}" title="Edit StdIqf"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('stdiqfs' . '/' . $stdiqf->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete StdIqf" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $stdiqf->id }}</td>
                                     </tr>   <tr> 
                                        <th>งาน</th><td>{{ $stdiqf->iqfjob->name }}</td>
                                        </tr>   <tr> 
                                        <th>เครื่อง</th><td>{{ $stdiqf->mechine->name }}</td>
                                        </tr>   <tr> 
                                        <th>Target per Person</th><td>{{ $stdiqf->std_productivity_person }}</td>
                                        </tr>   <tr> 
                                        <th>Note</th><td>{{ $stdiqf->desc }}</td>
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
