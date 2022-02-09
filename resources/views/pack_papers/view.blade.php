@extends('layouts.app')

@section('content')
@php
    $typePack = array();
    foreach ($packpaper->packpaperpackages()->get() as $packageObj){
        $typePack[] = $packageObj->packaging->packagetype->name;
    }
@endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ใบแจ้งการบรรจุผลิตภัณฑ์แช่แข็งสำเร็จรูป</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th rowspan="2">ผลิตภัณฑ์</th>
                                            <th rowspan="2">ลูกค้า</th>
                                            <th rowspan="2">วันที่บรรจุ</th>
                                            <th rowspan="2">Order number</th>
                                            <th colspan="{{ $packpaper->packpaperpackages()->count() }}">ชนิดของถุงและกล่อง</th>
                                            <th colspan="3">ขนาดบรรจุ</th>
                                            <th rowspan="2">สีสายรัด</th>
                                        </tr>
                                        <tr>
                                            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                                                <th>{{ $packageObj->packaging->packagetype->name }}</th>
                                            @endforeach
                                            <th>น้ำหนัก / ถุง</th>
                                            <th>จำนวนถุง / กล่อง</th>
                                            <th>น้ำหนัก / กล่อง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $packpaper->packaging->product->name }}</td>
                                            <td>{{ $packpaper->packaging->product->customer->name }}</td>
                                            <td>ว/ด/ป</td>
                                            <td>ตามใบแจ้งโหลด</td>
                                             @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                                                <td>{{ $packageObj->packaging->name }}</td>
                                            @endforeach
                                            <td>{{ number_format($packpaper->packaging->inner_weight_g, 2, '.', ',') }} กรัม</td>
                                            <td>{{ $packpaper->packaging->number_per_pack }} แพ็ค</td>
                                            <td>{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                             @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                                                <td> </td>
                                            @endforeach
                                            <td>น้ำหนักชั่งรวมถุง</td>
                                            <td> </td>
                                            <td> </td>
                                            <td></td>
                                        </tr>   
                                        @foreach ($packpaper->packpaperds()->get() as $packpaperd)
                                        <tr>
                                            <td>{{ $packpaper->packaging->product->name }}</td>
                                            <td>{{ $packpaper->packaging->product->customer->name }}</td>
                                            <td>{{ $packpaperd->pack_date }}</td>
                                            <td>{{ $packpaper->order_no }}</td>
                                             @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                                                <td>{{ $packageObj->packaging->name }}</td>
                                            @endforeach
                                            <td>{{ $packpaper->weight_with_bag  }}</td>
                                            <td>{{ $packpaper->packaging->number_per_pack }} แพ็ค</td>
                                            <td>{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
                                            <td>{{ $packpaperd->cablecover  }}</td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th colspan="2">ปริมาณ</th>
                                            <th rowspan="2">ระยะเวลาที่หมด อายุ (เดือน)</th>
                                            <th rowspan="2">วันที่หมดอายุ</th>
                                            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)                                             
                                                <th rowspan="2">วันที่ผลิต บน {{ $packageObj->packaging->packagetype->name }}</th>
                                                <th rowspan="2">วันที่หมดอายุ บน {{ $packageObj->packaging->packagetype->name }}</th>
                                                <th rowspan="2">Lot บน {{ $packageObj->packaging->packagetype->name }}</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th>กก.</th>
                                            <th>กล่อง</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>{{ $packpaper->exp_month  }}</td>
                                            <td>ว/ด/ป</td>
                                            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)                                             
                                                <td>
                                                    @if (empty($packageObj->pack_date_format))
                                                        ไม่ระบุ
                                                    @else
                                                        {{ $packageObj->pack_date_format }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (empty($packageObj->exp_date_format))
                                                        ไม่ระบุ
                                                    @else
                                                        {{ $packageObj->exp_date_format }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (empty($packageObj->lot))
                                                        ไม่ระบุ
                                                    @else
                                                        {{ $packageObj->lot }}
                                                    @endif</td>
                                            @endforeach
                                        </tr>
                                        @foreach ($packpaper->packpaperds()->get() as $packpaperd)
                                            <tr>
                                                <td>{{ $packpaperd->all_weight }}</td>
                                                <td>{{ $packpaperd->all_bpack }}</td>
                                                <td>{{ $packpaper->exp_month  }}</td>
                                                <td>{{ $packpaperd->exp_date  }}</td>
                                                @foreach ($packpaper->packpaperpackages()->get() as $packageObj)                                             
                                                    <td>
                                                        @if (empty($packageObj->pack_date_format))
                                                            ไม่ระบุ
                                                        @else
                                                            {{ date($packageObj->pack_date_format,strtotime($packpaperd->exp_month)) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (empty($packageObj->exp_date_format))
                                                            ไม่ระบุ
                                                        @else
                                                        @php
                                                         $phpformat =  str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$packageObj->exp_date_format))));
                                                         $lotSymbol = strpos($packageObj->exp_date_format,"LOT");
                                                         $noSymbol = strpos($packageObj->exp_date_format,"No");
                                                        @endphp
                                                            {{ date($phpformat,strtotime($packpaperd->exp_date)) }} 
                                                            @if ($lotSymbol > 0)
                                                                A
                                                            @endif
                                                            @if ($noSymbol > 0)
                                                                1
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (empty($packageObj->lot))
                                                            ไม่ระบุ
                                                        @else
                                                            {{ $packageObj->lot }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>    
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            @php
                                                $allcols = 8 + (2 * $packpaper->packpaperpackages()->count() );
                                            @endphp
                                            <th  colspan="{{ $allcols }}">การ STAMP ถุง และกล่อง </th>
                                        </tr>
                                        <tr>
                                            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                                            <th colspan="2">การ STAMP {{ $packageObj->packaging->packagetype->name }}สำเร็จรูป</th>
                                            @endforeach
                                           <th rowspan="2">Lot</th>
                                            <th rowspan="2">NO.</th>
                                            <th rowspan="2">จำนวนกล่อง</th>	
                                            <th rowspan="2">จำนวนถุง</th>	
                                            <th rowspan="2">น้ำหนักผลิตภัณฑ์/P</th>
                                            <th rowspan="2">น้ำหนักผลิตภัณฑ์/F</th>	
                                            <th rowspan="2">จำนวนพาเลท</th>	
                                            <th rowspan="2">จำนวนกล่องพาเลทสุดท้าย</th>
							

                                        </tr>
                                        <tr>
                                            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                                            <th>วันที่ผลิต</th>
                                            <th>วันที่หมดอายุ</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sumqty = 0;
                                            $sumkg = 0;
                                        @endphp
                                        @foreach ($packpaper->packpaperdlots()->get() as $item)

                                        <tr>
                                            
                                            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                                            @php
                                                $phpformatc =  str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$packageObj->pack_date_format))));
                                                $lotSymbolc = strpos($packageObj->pack_date_format,"LOT");
                                                $noSymbolc = strpos($packageObj->pack_date_format,"No");
                                                $phpformate =  str_replace('No.','' ,str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$packageObj->exp_date_format)))));
                                                $lotSymbole = strpos($packageObj->exp_date_format,"LOT");
                                                $noSymbole = strpos($packageObj->exp_date_format,"No");

                                                $sumqty += $item->nbox;
                                                $sumkg += $item->fweight;
                                            @endphp
                                            <td>@if (empty($packageObj->pack_date_format))
                                                    ไม่ระบุ
                                                @else
                                                    {{ date($phpformatc,strtotime($item->pack_date)) }}
                                                @endif
                                            </td>
                                            <td>@if (empty($packageObj->exp_date_format))
                                                    ไม่ระบุ
                                                @else
                                                    {{ date($phpformate,strtotime($item->exp_date)) }}
                                                @endif</td>
                                            @endforeach
                                            <td>{{ $item->lot }}</td>
                                            <td>{{ number_format($item->frombox,0,'.',',') }} - {{ number_format($item->tobox,0,'.',',') }}</td>
                                            <td>{{ number_format($item->nbox,0,'.',',') }}</td>
                                            <td>{{ number_format($item->nbag,0,'.',',') }}</td>
                                            <td>{{ number_format($item->pweight,2,'.',',')}}</td>
                                            <td>{{ number_format($item->fweight,2,'.',',') }}</td>
                                            <td>{{ $item->pallet }}</td>
                                            <td>{{ $item->pbag }}</td>
                                        </tr>    
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class='table table-bordered'>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>CUST.</th>
                                            <th>ORDER</th>
                                            <th>Product Fac</th>
                                            <th>Product Name</th>
                                            <th>QUANTITY (kg.)</th>
                                            <th>CARTON</th>
                                            <th>LOADING</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>{{ $packpaper->packaging->product->customer->name }}</td>
                                            <td>{{ $packpaper->order_no }}</td>
                                            <td>{{ $packpaper->packaging->product->desc }}</td>
                                            <td>{{ $packpaper->packaging->product->name }}</td>
                                            <td>{{ number_format($sumkg,2,'.',',') }}</td>
                                            <td>{{ number_format($sumqty,0,'.',',') }}</td>
                                            <td>{{ $packpaper->loading_date }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3>ตำแหน่งการ Stamp ถุงและกล่อง</h3>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)   
                            <div class="col-md-3">
                                <h4>{{ $packageObj->packaging->packagetype->name }} ด้านหน้า</h4>
                                @if (isset($packageObj->front_img))
                                    <img src="{{ url($packageObj->front_img) }}"  height='100px'/>
                                @else 
                                    <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                                @endif
                                @if (isset($packageObj->front_stamp))
                                    <br/>FORMAT การStamp:{{ $packageObj->front_stamp }}
                                @endif
                                 @if (isset($packageObj->front_locstamp))
                                    <br/>ตำแหน่งการStamp:{{ $packageObj->front_locstamp }}
                                @endif
                            </div>
                            <div class="col-md-3">
                                <h4>{{ $packageObj->packaging->packagetype->name }} ด้านหลัง</h4>
                                @if (isset($packageObj->back_img))
                                    <img src="{{ url($packageObj->back_img) }}"  height='100px'/>
                                @else 
                                    <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                                @endif
                                @if (isset($packageObj->back_stamp))
                                    <br/>FORMAT การStamp:{{ $packageObj->back_stamp }}
                                @endif
                                @if (isset($packageObj->back_locstamp))
                                    <br/>ตำแหน่งการStamp:{{ $packageObj->back_locstamp }}
                                @endif
                            </div>
                            @endforeach
                            <div class="col-md-3">
                                <h4>รูปแบบการรัดสาย</h4>
                                @if (isset($packpaper->cable_img))
                                    <img src="{{ url($packpaper->cable_img) }}"  height='100px'/>
                                @else 
                                    <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <h4>การเรียงสินค้าในกล่อง</h4>
                                @if (isset($packpaper->inbox_img))
                                    <img src="{{ url($packpaper->inbox_img) }}"  height='100px'/>
                                @else 
                                    <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <h4>การเรียงสินค้าในพาเลท</h4>
                                @if (isset($packpaper->pallet_img))
                                    <img src="{{ url($packpaper->pallet_img) }}"  height='100px'/>
                                @else 
                                    <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
