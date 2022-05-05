@extends('layouts.apppackpaper')

@section('content')
    <div class="container">
        <form method="POST"
                            action="{{ url('/pack_papers/generateOrderAction/' . $packaging->id . '/' . $lot) }}"
                            accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>สร้างใบแจ้งการบรรจุผลิตภัณฑ์แช่แข็งสำเร็จรูป สินค้า {{ $packaging->product->name }}</h2>
                    </div>
                    <div class="card-body">
                        
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">ลูกค้า</th>
                                        <th colspan="{{ $packaging->package->count() }}">ชนิดบรรจุภัณฑ์</th>
                                        <th colspan="3">ขนาดบรรจุ</th>
                                    </tr>
                                    <tr>
                                        @foreach ($packaging->package as $packageObj)
                                            <th>{{ $packageObj->packagetype->name }}</th>
                                        @endforeach
                                        <th>น้ำหนักต่อถุง</th>
                                        <th>จำนวนต่อกล่อง</th>
                                        <th>น้ำหนักต่อกล่อง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $packaging->product->customer->name }}</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>{{ $packageObj->name }}</td>
                                        @endforeach
                                        <td rowspan="2">{{ number_format($packaging->inner_weight_g, 2, '.', ',') }} กรัม</td>
                                        <td rowspan="2">{{ $packaging->number_per_pack }} ถุง</td>
                                        <td rowspan="2">{{ number_format($packaging->outer_weight_kg, 3, '.', ',') }} กก.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>วิธีการ Stamp</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                @if (isset($packageexp[$packageObj->id]))
                                                    {{ $packageexp[$packageObj->id] }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Stamp วันที่ผลิต<br>                                            
                                            {{-- <input type="hidden" name="pack_version" id="pack_version" value="1"> --}}
                                            <input type="checkbox" name="pack_thai_year" id="pack_thai_year" value="Use" @if(isset($productinfo->pack_thai_year)) checked @endif> ใช้ปี พ.ศ.</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                <input class="form-control" name="starttxtpack{{ $packageObj->id }}"
                                                    type="text" id="starttxtpack{{ $packageObj->id }}" 
                                                    @if (isset($packageinfos[$packageObj->id]))
                                                        value="{{ $packageinfos[$packageObj->id]->pack_date_format }}"
                                                    @endif
                                                    >
                                            </td>
                                        @endforeach
                                        <td>
                                            <label for="weight_with_bag" class="control-label">{{ 'น้ำหนักชั่งรวมถุง (กรัม)' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="weight_with_bag" type="text" id="weight_with_bag" required
                                                value="{{ $packaging->product->weight_with_bag }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Stamp วันที่หมดอายุ</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                <input class="form-control" name="exptxtpack{{ $packageObj->id }}"
                                                    type="text" id="exptxtpack{{ $packageObj->id }}" 
                                                    @if (isset($packageinfos[$packageObj->id]))
                                                        value="{{ $packageinfos[$packageObj->id]->exp_date_format }}"
                                                    @endif
                                                    >
                                            </td>
                                        @endforeach
                                        <td>
                                            <label for="order_no" class="control-label">{{ 'Order No.' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="order_no" type="text" id="order_no" required
                                                value="">
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Stamp เพิ่มเติม</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                <input class="form-control" name="extrastamp{{ $packageObj->id }}"
                                                    type="text" id="extrastamp{{ $packageObj->id }}" 
                                                    @if (isset($packageinfos[$packageObj->id]))
                                                        value="{{ $packageinfos[$packageObj->id]->extra_stamp }}"
                                                    @endif
                                                    >
                                            </td>
                                        @endforeach
                                        <td><label for="exp_month"
                                                class="control-label">{{ 'ระยะเวลาที่หมดอายุ (เดือน)' }}</label></td>
                                        <td colspan="2"><input class="form-control calexpdateall" name="exp_month"
                                                type="number" id="exp_month"  
                                                value="{{ $packaging->product->shelf_life }}" required></td>
                                    </tr>
                                    <tr>
                                        <td>LOT</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                {{-- <input class="form-control" name="lottxt{{ $packageObj->id }}"
                                                    type="text" id="lottxt{{ $packageObj->id }}" value=""> --}}
                                                <select name="lottxt{{ $packageObj->id }}" class="form-control" id="lottxt{{ $packageObj->id }}">
                                                    {{-- <option value="">-</option> --}}
                                                    <option value="">ไม่ระบุ</option>
                                                    <option value="ระบุ">ระบุ</option>
                                                </select>  
                                            </td>
                                        @endforeach
                                        <td>
                                            <label for="cable_file" class="control-label">{{ 'รูปแบบการรัดสาย' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="cable_file" type="file" id="cable_file" >                                            
                                            @if (isset($productinfo->cable_img))
                                                <div class="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    <img  src="{{ url($productinfo->cable_img) }}"  height='100px'/>
                                                    <input type="hidden" name="img_cable" id="img_cable" value="1" />
                                                </div>
                                              {{-- <img  src="{{ url($productinfo->cable_img) }}"  height='100px'/> --}}
                                            @endif
                                            {{-- <div>
                                                <input type="radio" name="chk_user" id="chk_user" value="Use" checked>ใช้รูป
                                                &nbsp;&nbsp;
                                                <input type="radio" name="chk_user" id="chk_user" value="No">ไม่ใช้รูป
                                            </div> --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ด้านหน้า</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                <input class="form-control" name="front_img{{ $packageObj->id }}"
                                                    type="file" id="front_img{{ $packageObj->id }}" >
                                                <input class="form-control" name="front_stamp{{ $packageObj->id }}"
                                                    type="text" id="front_stamp{{ $packageObj->id }}" placeholder="FORMAT การStamp"
                                                    @if (isset($packageinfos[$packageObj->id]->front_stamp))   
                                                     value="{{ $packageinfos[$packageObj->id]->front_stamp }}" 
                                                    @endif
                                                    >
                                                <input class="form-control" name="front_locstamp{{ $packageObj->id }}"
                                                    type="text" id="front_locstamp{{ $packageObj->id }}" placeholder="ตำแหน่งการStamp"
                                                    @if (isset($packageinfos[$packageObj->id]->front_locstamp))   
                                                     value="{{ $packageinfos[$packageObj->id]->front_locstamp }}" 
                                                    @endif
                                                    >
                                                     @if (isset($packageinfos[$packageObj->id]->front_img))
                                                     <img    
                                                     src="{{ url($packageinfos[$packageObj->id]->front_img) }}"  height='100px'/>
                                                    @endif
                                            </td>
                                        @endforeach
                                        <td><label for="inbox_file"
                                                class="control-label">{{ 'การเรียงสินค้าในกล่อง' }}</label></td>
                                        <td colspan="2"><input class="form-control" name="inbox_file"
                                                type="file" id="inbox_file" >
                                            @if (isset($productinfo->inbox_img))
                                             <img  
                                                     src="{{ url($productinfo->inbox_img) }}"  height='100px'/>
                                                @endif
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>ภาพด้านหลัง</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                <input class="form-control" name="back_img{{ $packageObj->id }}"
                                                    type="file" id="back_img{{ $packageObj->id }}" value="">
                                                    <input class="form-control" name="back_stamp{{ $packageObj->id }}"
                                                    type="text" id="back_stamp{{ $packageObj->id }}" placeholder="FORMAT การStamp"
                                                    @if (isset($packageinfos[$packageObj->id]->back_stamp))   
                                                     value="{{ $packageinfos[$packageObj->id]->back_stamp }}" 
                                                    @endif
                                                    >
                                                    <input class="form-control" name="back_locstamp{{ $packageObj->id }}"
                                                    type="text" id="back_locstamp{{ $packageObj->id }}" placeholder="ตำแหน่งการStamp"
                                                    @if (isset($packageinfos[$packageObj->id]->back_locstamp))   
                                                     value="{{ $packageinfos[$packageObj->id]->back_locstamp }}" 
                                                    @endif
                                                    >
                                                     @if (isset($packageinfos[$packageObj->id]->back_img))
                                                     <img    
                                                     src="{{ url($packageinfos[$packageObj->id]->back_img) }}"  height='100px'/>
                                                    @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            <label for="pallet_file" class="control-label">{{ 'การเรียงสินค้าในพาเลท' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="pallet_file" type="file" id="pallet_file" > 
                                            @if (isset($productinfo->pallet_img))
                                                <img src="{{ url($productinfo->pallet_img) }}"  height='100px'/>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Art Work ถุง, กล่อง</td>                                        
                                        <td>
                                            <input class="form-control" name="artwork_file" type="file" id="artwork_file" >                                           
                                        </td>
                                        <td>
                                            @if (isset($packpaper->artwork_file))
                                                <img src="{{ url($packpaper->artwork_file) }}"  height='100px'/>
                                            @endif                                            
                                        </td>
                                        @for($i = 0; $i < $packaging->package->count()+1; $i++)
                                            <td></td>
                                        @endfor
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="product_fac" class="control-label">{{ 'Product Fac' }}</label>
                <input class="form-control" name="product_fac" type="text" id="product_fac" required value="@if (isset($productinfo->product_fac)){{ $productinfo->product_fac }}@endif">
            </div>
            <div class="col-md-6">
                <label for="loading_date" class="control-label">{{ 'LOADING' }}</label>
                <input class="form-control" name="loading_date" type="date" id="loading_date" required value="">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="pallet_base" class="control-label">{{ 'ฐานจัดเรียง (กล่อง)' }}</label>
                <input class="form-control" name="pallet_base" data-ref="{{ $lot }}" type="number" id="pallet_base" required value="@if (isset($productinfo->pallet_base)){{ $productinfo->pallet_base }}@endif">
            </div>
            <div class="col-md-4">
                <label for="pallet_low" class="control-label">{{ 'จัดเรียงแบบที่ 1 (ชั้น)' }}</label>
                <input class="form-control" name="pallet_low" type="number" id="pallet_low" required value="@if (isset($productinfo->pallet_low)){{ $productinfo->pallet_low }}@endif">
            </div>
            <div class="col-md-4">
                <label for="pallet_height" class="control-label">{{ 'จัดเรียงแบบที่ 2 (ชั้น)' }}</label>
                <input class="form-control" name="pallet_height" type="number" id="pallet_height" required value="@if (isset($productinfo->pallet_height)){{ $productinfo->pallet_height }}@endif">
            </div>
        </div>
        
        <br/>
        <input type="hidden" name="number_per_pack" id="number_per_pack" value="{{ $packaging->number_per_pack }}" />
        <input type="hidden" name="outer_weight_kg" id="outer_weight_kg" value="{{ $packaging->outer_weight_kg }}" />
        
        จัดการ LOT <a href="{{ url('/pack_papers/generateOrder/' . $packaging->id  . '/' . ($lot + 1)) }}"><i
                class="fa fa-plus-circle" aria-hidden="true"></i></a>
        @if ($lot > 1)
            <a href="{{ url('/pack_papers/generateOrder/' . $packaging->id . '/' . ($lot - 1)) }}"><i
                    class="fa fa-minus-circle" aria-hidden="true"></i></a>
        @endif
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>วันแพ็ค<br />/วันหมดอายุ</th>
                        <th>LOT</th>
                        <th>จากกล่อง<br />/ถึงกล่อง</th>
                        <th>จำนวนกล่อง<br />/จำนวนถุง</th>
                        <th>น้ำหนัก/P<br />/น้ำหนัก/F</th>
                        <th>จำนวนพาเลท<br />/จำนวนกล่องเศษ</th>
                        <th>หมายเหตุ</th>

                    </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i <= $lot; $i++)
                        <tr>
                            <td><input class="form-control calexpdatelot" name="packdate{{ $i }}" type="date"
                                    id="packdate{{ $i }}" data-ref="{{ $i }}" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                <br /><input class="form-control" name="expdate{{ $i }}" type="date"
                                    id="expdate{{ $i }}" value="">
                            </td>
                            <td><input class="form-control" name="lot{{ $i }}" type="text"
                                    id="lot{{ $i }}" value="" required><br />
                                <select name="pattern_pallet{{ $i }}" class="form-control col w-75 pattern_format" id="pattern_pallet{{ $i }}" required>
                                    <option value="1">จัดเรียงแบบที่ 1</option>
                                    <option value="2">จัดเรียงแบบที่ 2</option>
                                </select>
                            </td>
                            <td><input class="form-control calbox" name="fbox{{ $i }}"
                                    data-ref="{{ $i }}" type="number" id="fbox{{ $i }}" value="" readonly>
                                <br /><input class="form-control calbox" name="tbox{{ $i }}"
                                    data-ref="{{ $i }}" type="number" id="tbox{{ $i }}" value="" readonly>
                            </td>
                            <td><input class="form-control" name="nbox{{ $i }}" type="text"
                                    id="nbox{{ $i }}" value="" readonly>
                                <br /><input class="form-control" name="nbag{{ $i }}" type="text"
                                    id="nbag{{ $i }}" value="" readonly>
                            </td>
                            <td><input class="form-control" name="pweight{{ $i }}" type="text"
                                    id="pweight{{ $i }}" value="" readonly>
                                <br /><input class="form-control" name="fweight{{ $i }}" type="text"
                                    id="fweight{{ $i }}" value="" readonly>
                            </td>
                            <td><input class="form-control npallet" name="pallet{{ $i }}" type="text"
                                    id="pallet{{ $i }}" value="" required>
                                <br /><input class="form-control npbag" name="pbag{{ $i }}" type="text"
                                    id="pbag{{ $i }}" value="">
                            </td>
                            <td><input class="form-control" name="note{{ $i }}" type="text"
                                    id="note{{ $i }}" value="">
                                {{-- <div class="row"> --}}
                                    <label for="cablecover{{ $i }}" class="control-label col">{{ 'สายรัด' }}</label>
                                    
                                    <select name="cablecover{{ $i }}" class="form-control col w-75" id="cablecover{{ $i }}" required>
                                        <option value="">-</option>
                                        @foreach ($cablecoverlist as $optionKey => $optionValue)
                                            <option value="{{ $optionKey }}" {{ (isset($matpackrate->mat_pack_id) && $matpackrate->mat_pack_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                                        @endforeach
                                    </select>
                                {{-- </div>     --}}
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class='col-12'><input type="submit"></div>
        </div>
        <br />
        <br />
        <br />
        </form>
    </div>
@endsection
