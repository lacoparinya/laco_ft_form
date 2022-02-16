@extends('layouts.apppackage')

@section('content')

    <div class="container">
        <div class="row">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Packaging 
        </h2>
            <div class="bg-white ">
                    <form method="GET" action="{{ url('/packagings') }}" accept-charset="UTF-8" class="form-inline  " role="search">           
                        <div class='col-12'>   
                        <div class="">  
                            <table class="table">
                                 <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Version<br/><input type="text" class="form-control" name="txtversion" placeholder="ค้นหา Verion..." value="{{ request('txtversion') }}"></th>
                                        <th>Product Group<br/><input type="text" class="form-control" name="txtproductgroup" placeholder="ค้นหา กลุ่มสินค้า..." value="{{ request('txtproductgroup') }}"></th>                                                 
                                        <th>Product<br/><input type="text" class="form-control" name="txtproduct" placeholder="ค้นหา สินค้า..." value="{{ request('txtproduct') }}"></th>         
                                        <th>Package<br/><input type="text" class="form-control" name="txtpackage" placeholder="ค้นหา Package..." value="{{ request('txtpackage') }}"></th>                                    
                                        <th>น้ำหนักต่อถุง(g.) <br/>/ จำนวนถุงต่อกล่อง<br/> / น้ำหนักต่อกล่อง(kg.)<br/><input type="text" class="form-control" name="txtweight" placeholder="ค้นหา นน จำนวน..." value="{{ request('txtweight') }}"></th>
                                        <th>Actions<br/><input class="btn btn-secondary" type="submit"/></th>                                    
                                    </tr>                                    
                                </thead>
                                <tbody>
                                @foreach($packagings as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->version }}</td>                                        
                                        <td>{{ $item->product->productgroup->name or ''}}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>
                                            @foreach ($item->package()->get() as $subitem)
                                               {{ $subitem->packagetype->name }} \ {{ $subitem->name }} <br/>
                                            @endforeach
                                        </td>
                                        <td>{{ number_format($item->inner_weight_g,2,".",",") }} / {{ $item->number_per_pack }} / {{ number_format($item->outer_weight_kg,3,".",",") }}</td>
                                        <td>
                                            <a href="{{ url('/packagings/' . $item->id) }}" title="View Packaging" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                            <a href="{{ url('/pack_papers/generateOrder/'.$item->id.'/1/1') }}" title="สร้างใบแจ้งบรรจุ" class="btn btn-info btn-sm"><i class="fa fa-file-text-o" aria-hidden="true"></i> ใบแจ้งบรรจุ</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $packagings->appends([
                                'txtversion' => Request::get('txtversion'),
                                'txtproductgroup' => Request::get('txtproductgroup'),
                                'txtproduct' => Request::get('txtproduct'),
                                'txtpackage' => Request::get('txtpackage'),
                                'txtweight' => Request::get('txtweight')
                                ])->render() !!} </div>
                        </div>

            </div></div>   </form>
</div>
    </div>
@endsection