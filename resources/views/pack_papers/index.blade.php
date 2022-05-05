@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ใบแจ้งบรรจุ</div>
                    <div class="card-body">
                    <div class="row">   
                        <form method="GET" action="{{ url('pack_papers') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">                            
                            <select id="search" name="search" class="form-control col-md-5" data-role="select-dropdown" onchange="myFunction(this.value)">
                                <option value="" @if(empty($search)) selected @endif>..ค้นหาสินค้า..</option>
                                @foreach ($to_search as $key)
                                    <option value="{{ $key->packaging_id }}" @if($search==$key->packaging_id) selected @endif>{{ $key->name }}</option>
                                @endforeach
                            </select>
                            <span class="col-md-1">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>                                
                        </form>
                        <a class="btn btn-success" href="{{ url('/pack_papers/generateOrder/'.$search.'/1') }}" @if(!empty($search)) enabled @else disabled @endif><i class="fa fa-plus"></i> Create</a>
                    </div>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>สินค้า</th><th>Order</th><th>Plan Version</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($paperpacks as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->order_no }}</td>
                                        <td>@if(empty($item->pack_version)) {{ '1' }} @else{{ $item->pack_version }}@endif</td>
                                        <td>
                                            <a href="{{ url('/pack_papers/view/' . $item->id) }}" title="View Job"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/pack_papers/edit_genOrder/' . $item->id . '/' . $item->packpaperdlots->count()) }}" title="Edit Job"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/pack_papers/delete/' . $item->id) }}" title="Delete"><button class="btn btn-danger btn-sm" onclick="return confirm('คุณต้องการลบรายการ {{ $item->name }} Order ที่ {{ $item->order_no }} ใช่มั้ย ?')"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button></a>
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
