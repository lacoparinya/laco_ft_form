@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ถั่วตกไลน์แพ๊ค</div>
                    <div class="card-body">
                        <a href="{{ url('/seed-drop-packs/create') }}" class="btn btn-success btn-sm"
                            title="Add New seeddroppack">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/seed-drop-packs') }}" accept-charset="UTF-8"
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
                                        <th>#</th>
                                        <th>วิธี</th>
                                        <th>กะ</th>
                                        <th>วันที่</th>
                                        <th>บริเวณลากกระบะ (KG.)</th>
                                        <th>สายพานจุดปล่อยถั่ว (KG.)</th>
                                        <th>สายพาน Intralox/โครง Z (KG.)</th>
                                        <th>หัวชั่ง</th>
                                        <th>Shaker</th>
                                        <th>ในเครื่องบรรจุ (KG.)</th>
                                        <th>โต๊ะบรรจุ</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($seeddroppacks as $item)
                                        <tr>
                                            <td>{{ $loop->iteration or $item->id }}</td>
                                            <td>{{ $item->method->name }}</td>
                                            <td>{{ $item->shift->name or '' }}</td>
                                            <td>{{ $item->check_date or '' }}</td>
                                            <td>{{ number_format($item->cabin, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->belt_start, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->belt_Intralox, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->weight_head, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->shaker, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->pack_part, 2, '.', ',') }}</td>
                                            <td>{{ number_format($item->table, 2, '.', ',') }}</td>
                                            <td>
                                                <a href="{{ url('/seed-drop-packs/' . $item->id) }}"
                                                    title="View seeddroppack"><button class="btn btn-info btn-sm"><i
                                                            class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>
                                                        View</button></a>
                                                <a href="{{ url('/seed-drop-packs/' . $item->id . '/edit') }}"
                                                    title="Edit seeddroppack"><button class="btn btn-primary btn-sm"><i
                                                            class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
                                                        Edit</button></a>
                                                <form method="POST"
                                                    action="{{ url('/seed-drop-packs' . '/' . $item->id) }}"
                                                    accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        title="Delete seeddroppack"
                                                        onclick="return confirm(&quot;Confirm delete?&quot;)"><i
                                                            class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                                                        Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $seeddroppacks->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
