@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ใบแจ้งบรรจุ</div>
                    <div class="card-body">

                        <form method="GET" action="{{ url('/paper_packs') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>สินค้า</th><th>Order</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($paperpacks as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->packaging->product->name }}</td>
                                        <td>{{ $item->order_no }}</td>
                                        <td>
                                            <a href="{{ url('/pack_papers/view/' . $item->id) }}" title="View Job"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/pack_papers/edit_genOrder/' . $item->id . '/' . $item->packpaperdlots->count()) }}" title="Edit Job"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/pack_papers/delete/' . $item->id) }}" title="Delete"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button></a>
                                            {{-- <form method="POST" action="{{ url('/pack_papers/delete/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Job" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $paperpacks->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
