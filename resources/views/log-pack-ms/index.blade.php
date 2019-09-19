@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Logpackms</div>
                    <div class="card-body">
                        <a href="{{ url('/log-pack-ms/create') }}" class="btn btn-success btn-sm" title="Add New LogPackM">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/log-pack-ms') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                            <a href="{{ url('/log-pack-ms/?status=Active') }}" class="btn btn-primary btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/log-pack-ms/?status=Closed') }}" class="btn btn-success btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @else
                            <a href="{{ url('/log-pack-ms/?status=Active') }}" class="btn btn-success btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/log-pack-ms/?status=Closed') }}" class="btn btn-primary btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order</th>
                                        <th>Methode / Product</th>
                                         <th>รายการ</th>
                                        <th>Actual</th>
                                        <th>Plan</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($logpackms as $item)
                                    <tr>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->order->order_no }} / {{ $item->order->loading_date }}</td>
                                        <td>{{ $item->method->name }} / {{ $item->package->name }}</td>
                                        @if (count($item->logpackd))
                                        <td>{{ $item->logpackd->count() }}</td>
                                        <td>{{ $item->logpackd()->orderBy('process_datetime','DESC')->first()->input_kg_sum or '' }} / 
                                            {{ $item->logpackd()->orderBy('process_datetime','DESC')->first()->output_kg_sum or '' }} / 
                                            {{ $item->logpackd()->orderBy('process_datetime','DESC')->first()->output_pack_sum or '' }}</td>
                                        @else
                                        <td>0</td>
                                        <td>- / - / -</td>
                                        @endif
                                        <td>{{ $item->overalltargets }}</td>
                                        
                                        
                                        <td>
                                            @if ($item->status == 'Active')
                                                <a href="{{ url('/log-pack-ms/createDetail/'.$item->id) }}" class="btn btn-success btn-sm" title="Add New LogPrepareM">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Detail
                        </a>    
                                            @endif
                                            <a href="{{ url('/log-pack-ms/' . $item->id) }}" title="View LogPackM"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Manage</button></a>
                                           
 <a href="{{ url('/log-pack-ms/graph/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> Graph</button></a>
 
         <a href="{{ url('/log-pack-ms/changestatus/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->status }}</button></a>
                        <br/>  <a href="{{ url('/log-pack-ms/' . $item->id . '/edit') }}" title="Edit LogPackM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                          
                            <form method="POST" action="{{ url('/log-pack-ms' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete LogPackM" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </form>
                     
                        
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $logpackms->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
