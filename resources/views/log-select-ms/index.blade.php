@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>งานคัด</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/log-select-ms/create') }}" class="btn btn-success btn-sm" title="Add New LogSelectM">
                            <i class="fa fa-plus" aria-hidden="true"></i> สร้างรายการใหม่
                        </a>

                        <form method="GET" action="{{ url('/log-select-ms') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                            <a href="{{ url('/log-select-ms/?status=Active') }}" class="btn btn-primary btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/log-select-ms/?status=Closed') }}" class="btn btn-success btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @else
                            <a href="{{ url('/log-select-ms/?status=Active') }}" class="btn btn-success btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/log-select-ms/?status=Closed') }}" class="btn btn-primary btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>วันที่ / กะ</th>
                                        <th>คัดผลิตภัณท์</th>
                                        <th>ยอดที่ผลิดได้</th>
                                        <th>เป้าที่ต้องผลิต</th>
                                        <th>จำนวน</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($logselectms as $item)
                                    <tr>
                                        <td>{{ $item->process_date }} / {{ $item->shift->name }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->logselectd->sum('output_kg') }}</td>
                                        <td>{{ $item->targetperday }}</td>
                                        <td>{{ $item->logselectd->count() }}</td>
                                        <td>
                                            @if ($item->status == 'Active')
                                                <a href="{{ url('/log-select-ms/createDetail/'.$item->id) }}" class="btn btn-success btn-sm" title="Add New LogPrepareM">
                            <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มข้อมูล
                        </a>    
                                            @endif
                                            <a href="{{ url('/log-select-ms/' . $item->id) }}" title="View LogPackM"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> จัดการ</button></a>
                                           
 <a href="{{ url('/log-select-ms/graph/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> กราฟ</button></a>
  <a href="{{ url('/log-select-ms/forecast/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> ประเมิน</button></a>
 
         <a href="{{ url('/log-select-ms/changestatus/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->status }}</button></a>
                        <br/>  <a href="{{ url('/log-select-ms/' . $item->id . '/edit') }}" title="Edit LogPackM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                          
                                            <form method="POST" action="{{ url('/log-select-ms' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete LogSelectM" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $logselectms->appends(['search' => Request::get('search'),'status'=>$status])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
