@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>งานฟรีส</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/freeze-ms/create') }}" class="btn btn-success btn-sm" title="Add New FreezeM">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/freeze-ms') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        @if ($status == 'Active')
                            <a href="{{ url('/freeze-ms/?status=Active') }}" class="btn btn-primary btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/freeze-ms/?status=Closed') }}" class="btn btn-success btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @else
                            <a href="{{ url('/freeze-ms/?status=Active') }}" class="btn btn-success btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/freeze-ms/?status=Closed') }}" class="btn btn-primary btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @endif
                        
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Job</th>
                                        <th>Target (kg/hr/person)</th>
                                        <th>รับเข้า</th>
                                        <th>Remain</th>
                                        <th>รายการ</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($freezems as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->iqfjob->name }}</td>
                                        <td>{{ $item->targets }}</td>
                                        <td>{{ number_format($item->start_RM,2,".",",") }}</td>
                                        <td>
                                        @php
                                            //echo $item->freezed->count();
                                            if($item->freezed->count() > 0){
                                               echo number_format($item->freezed()->orderBy('process_datetime','desc')->first()->current_RM,2,".",",");
                                            }else{
                                                echo number_format($item->start_RM,2,".",",");
                                               }
                                        @endphp
                                        </td>
                                        <td>{{ $item->freezed->count() }}</td>
                                        <td>
                                            @php
                                                if($item->status == 'Active'){
                                                if($item->freezed->count() > 0){
                                                    if ($item->freezed()->orderBy('process_datetime','desc')->first()->current_RM > 0){
                                            @endphp
                                            <a href="{{ url('/freeze-ms/createDetail/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> ADD</button></a>
                                            @php       
                                                    }
                                                }else{
                                            @endphp
                                            <a href="{{ url('/freeze-ms/createDetail/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> ADD</button></a>
                                            @php 
                                                }
                                            }
                                            @endphp
                                            <a href="{{ url('/freeze-ms/graph/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> Graph</button></a>
                                          
                                            <a href="{{ url('/freeze-ms/' . $item->id) }}" title="View FreezeM"><button class="btn btn-info btn-sm"><i class="fa fa-gears" aria-hidden="true"></i> Manage</button></a>
                                            <a href="{{ url('/freeze-ms/' . $item->id . '/edit') }}" title="Edit FreezeM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/freeze-ms/changestatus/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->status }}</button></a>
                                            @if ($item->freezed->count() == 0)
                                                <form method="POST" action="{{ url('/freeze-ms' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete FreezeM" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $freezems->appends(['search' => Request::get('search'),'status'=>$status])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
