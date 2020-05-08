@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>งานของ PST</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/log-pst-selects/create') }}" class="btn btn-success btn-sm" title="Add New LogPstSelect">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/log-pst-selects') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>@if ($status == 'Active')
                            <a href="{{ url('/log-pst-selects/?status=Active') }}" class="btn btn-primary btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/log-pst-selects/?status=Closed') }}" class="btn btn-success btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @else
                            <a href="{{ url('/log-pst-selects/?status=Active') }}" class="btn btn-success btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/log-pst-selects/?status=Closed') }}" class="btn btn-primary btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>วันที่ / กะ</th>
                                        <th>ประเภทงาน / ผลิตภัณท์</th>
                                        <th>ยอดที่ผลิดได้</th>
                                        <th>เป้าที่ต้องผลิต</th>
                                        <th>จำนวน</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($logpstselects as $item)
                                    <tr>
                                        <td>{{ $item->process_date }} / {{ $item->shift->name }}</td>
                                        <td>{{ $item->psttype->name or ''}}  / {{ $item->pstproduct->name }}</td>
                                        <td>{{ $item->logpstselectd->sum('output_kg') }}</td>
                                        <td>{{ $item->targetperday }}</td>
                                        <td>{{ $item->logpstselectd->count() }}</td>
                                        
                                        <td>
                                          
                                             @if ($item->status == 'Active')
                                                <a href="{{ url('/log-pst-selects/createDetail/'.$item->id) }}" class="btn btn-success btn-sm" title="Add New LogPrepareM">
                                                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มข้อมูล
                                                </a>    
                                            @endif
                                                <a href="{{ url('/log-pst-selects/' . $item->id) }}" title="View LogPackM"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> จัดการ</button></a>
                                                <a href="{{ url('/log-pst-selects/graph/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> กราฟ</button></a>
                                                <a href="{{ url('/log-pst-selects/forecast/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> ประเมิน</button></a>
                                                @if ($item->pst_type_id == '3')
                                                <a href="{{ url('/log-pst-selects/groupgraph/' . $item->process_date .'/'. $item->pst_type_id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> กราฟรายวัน</button></a>
                                                @endif
                                                <a href="{{ url('/log-pst-selects/changestatus/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->status }}</button></a>
                                                <a href="{{ url('/log-pst-selects/' . $item->id . '/edit') }}" title="Edit LogPackM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>
                                                <form method="POST" action="{{ url('/log-pst-selects' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete LogSelectM" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $logpstselects->appends(['search' => Request::get('search'),'status'=>$status])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
