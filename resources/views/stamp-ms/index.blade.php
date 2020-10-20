@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>รายการในงานStamp</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/stamp-ms/create') }}" class="btn btn-success btn-sm" title="Add New StampM">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/stamp-ms') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                            <a href="{{ url('/stamp-ms/?status=Active') }}" class="btn btn-primary btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/stamp-ms/?status=Closed') }}" class="btn btn-success btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @else
                            <a href="{{ url('/stamp-ms/?status=Active') }}" class="btn btn-success btn-sm" title="Status Active">
                            <i class="fa fa-unlock" aria-hidden="true"></i> Active
                        </a>
                        <a href="{{ url('/stamp-ms/?status=Closed') }}" class="btn btn-primary btn-sm" title="Add New FreezeM">
                            <i class="fa fa-lock" aria-hidden="true"></i> Closed
                        </a>
                        @endif
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date / Shift</th>
                                        <th>เครื่อง</th>
                                        <th>สินค้า</th>
                                        <th>รายการ</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($stampms as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->process_date }} / {{ $item->shift->name }}</td>
                                        <td>{{ $item->stampmachine->name }}</td>
                                        <td>{{ $item->matpack->matname }} / {{ $item->matpack->packname }}</td>
                                        <td>{{ $item->stampd->count() }}</td>
                                        <td>
                                            <a href="{{ url('/stamp-ms/' . $item->id) }}" title="View StampM"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> จัดการ</button></a>
                                            <a href="{{ url('/stamp-ms/graph/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> กราฟ</button></a>
                                        <a href="{{ url('/stamp-ms/forecast/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-bar-chart" aria-hidden="true"></i> ประเมิน</button></a>
                                        <a href="{{ url('/stamp-ms/changestatus/' . $item->id) }}" title="Add FreezeM"><button class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->status }}</button></a>
                                      
                                            <a href="{{ url('/stamp-ms/' . $item->id . '/edit') }}" title="Edit StampM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข</button></a>

                                            <form method="POST" action="{{ url('/stamp-ms' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete StampM" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> ลบ</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $stampms->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
