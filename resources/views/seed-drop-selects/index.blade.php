@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ถั่วตกไลน์คัด</div>
                    <div class="card-body">
                        <a href="{{ url('/seed-drop-selects/create') }}" class="btn btn-success btn-sm"
                            title="Add New seeddropselect">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/seed-drop-selects') }}" accept-charset="UTF-8"
                            class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..."
                                    value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">#</th>
                                        <th rowspan="2">กะ</th>
                                        <th rowspan="2">วันที่</th>
                                        <th rowspan="2">ประเภท</th>
                                        <th colspan="2">RM</th>
                                        <th colspan="2">Incline</th>
                                        <th colspan="2">สายพานรับถั่วจาก<br>Recheck</th>
                                        <th colspan="2">สายพานลำเลียงถั่วเข้า<br>Auto weight</th>
                                        <th colspan="2">ใต้สายพานไลน์คัด<br>"ของตกเกรด"</th>
                                        <th rowspan="2">Actions</th>
                                    </tr>
                                    <tr>
                                        <th>Input</th>
                                        <th>Output</th>
                                        <th>Machine</th>
                                        <th>Man</th>
                                        <th>Machine</th>
                                        <th>Man</th>
                                        <th>Machine</th>
                                        <th>Man</th>
                                        <th>Machine</th>
                                        <th>Man</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($seeddropselects as $item)
                                        <tr>
                                            <td>{{ $loop->iteration or $item->id }}</td>
                                            <td>{{ $item->shift->name or '' }}</td>
                                            <td>{{ $item->check_date or '' }}</td>
                                            <td>{{ $item->material or '' }}</td>
                                            <td>{{ number_format($item->input_w, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->output_w, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->incline_a, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->incline_m, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->beltrecheck_a, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->beltrecheck_m, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->beltautoweight_a, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->beltautoweight_m, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->underbelt_a, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->underbelt_m, 2, '.', ',') }}</td>
                                            <td>
                                                <a href="{{ url('/seed-drop-selects/' . $item->id) }}"
                                                    title="View seeddropselect"><button class="btn btn-info btn-sm"><i
                                                            class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>
                                                        View</button></a>
                                                <a href="{{ url('/seed-drop-selects/' . $item->id . '/edit') }}"
                                                    title="Edit seeddropselect"><button class="btn btn-primary btn-sm"><i
                                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
                                                        Edit</button></a>
                                                <form method="POST"
                                                    action="{{ url('/seed-drop-selects' . '/' . $item->id) }}"
                                                    accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Delete seeddropselect"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                            class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                                                        Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $seeddropselects->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
