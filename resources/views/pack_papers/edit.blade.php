@extends('layouts.apppackpaper')

@section('content')
    <div class="container">
        @php
            // $lot = $packpaper->packpaperdlots->count();
        @endphp
        <form method="POST"
                            action="{{ url('/pack_papers/update_genOrder/' . $packpaper->id . '/' . $lot) }}"
                            accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>แก้ไข ใบแจ้งการบรรจุผลิตภัณฑ์แช่แข็งสำเร็จรูป สินค้า {{ $packpaper->packaging->product->name }} @if($packpaper->revise_version>0) (V. {{ $packpaper->revise_version }}) @endif</h2>                        
                        @if($packpaper->revise_version>0)
                            <h5>Old version 
                                @foreach($relate_id as $key) 
                                    <a href="{{ url('/pack_papers/view/' . $key->id) }}" target="_blank">@if($key->revise_version==""){{ "V.0 " }}@else{{ "V.".$key->revise_version.' ' }}@endif</a>                           
                                @endforeach
                            </h5>
                        @endif
                    </div>
                    <div class="card-body">
                        
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">ลูกค้า</th>
                                        <th colspan="{{ $packpaper->packpaperpackages->count() }}">ชนิดบรรจุภัณฑ์</th>
                                        <th colspan="3">ขนาดบรรจุ</th>
                                    </tr>
                                    <tr>
                                        @foreach ($packpaper->packaging->package as $packageObj)
                                            <th>{{ $packageObj->packagetype->name }}</th>
                                        @endforeach
                                        <th>น้ำหนักต่อถุง</th>
                                        <th>จำนวนต่อกล่อง</th>
                                        <th>น้ำหนักต่อกล่อง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $packpaper->packaging->product->customer->name }}</td>
                                        @foreach ($packpaper->packaging->package as $packageObj)
                                            <td>{{ $packageObj->name }}</td>
                                        @endforeach
                                        <td rowspan="2">{{ number_format($packpaper->packaging->inner_weight_g, 2, '.', ',') }} กรัม</td>
                                        <td rowspan="2">{{ $packpaper->packaging->number_per_pack }} ถุง</td>
                                        <td rowspan="2">{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>วิธีการ Stamp</td>
                                        @foreach ($packpaper->packaging->package as $packageObj)
                                            <td>
                                                @if (isset($packageexp[$packageObj->id]))
                                                    {{ $packageexp[$packageObj->id] }}
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Stamp วันที่ผลิต<br>
                                            <input type="checkbox" name="pack_thai_year" id="pack_thai_year" value="Use" @if(isset($packpaper->pack_thai_year)) checked @endif> ใช้ปี พ.ศ.
                                            <input type="hidden" name="revise_version" id="revise_version" value="@if(empty($packpaper->revise_version)) {{ 1 }} @else {{ $packpaper->revise_version+1 }}@endif">
                                        </td>
                                        @foreach ($packpaper->packpaperpackages as $packageObj)
                                            <td>
                                                <input class="form-control" name="starttxtpack{{ $packageObj->id }}"
                                                    type="text" id="starttxtpack{{ $packageObj->id }}" 
                                                    @if (isset($packageObj->pack_date_format))
                                                        value="{{ $packageObj->pack_date_format }}"
                                                    @endif
                                                    >
                                            </td>
                                        @endforeach
                                        <td>
                                            <label for="weight_with_bag" class="control-label">{{ 'น้ำหนักชั่งรวมถุง (กรัม)' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="weight_with_bag" type="text" id="weight_with_bag" required
                                                value="{{ $packpaper->weight_with_bag }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Stamp วันที่หมดอายุ</td>
                                        @foreach ($packpaper->packpaperpackages as $packageObj)
                                            <td>
                                                <input class="form-control" name="exptxtpack{{ $packageObj->id }}"
                                                    type="text" id="exptxtpack{{ $packageObj->id }}" 
                                                    @if (isset($packageObj->exp_date_format))
                                                        value="{{ $packageObj->exp_date_format }}"
                                                    @endif
                                                    >
                                            </td>
                                        @endforeach
                                        <td>
                                            <label for="order_no" class="control-label">{{ 'Order No.' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="order_no" type="text" id="order_no" required
                                                value="{{ $packpaper->order_no }}">
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Stamp เพิ่มเติม</td>
                                        @foreach ($packpaper->packpaperpackages as $packageObj)
                                            <td>
                                                <input class="form-control" name="extrastamp{{ $packageObj->id }}"
                                                    type="text" id="extrastamp{{ $packageObj->id }}" 
                                                    @if (isset($packageObj->extra_stamp))
                                                        value="{{ $packageObj->extra_stamp }}"
                                                    @endif
                                                    >
                                            </td>
                                        @endforeach
                                        <td><label for="exp_month"
                                                class="control-label">{{ 'ระยะเวลาที่หมดอายุ (เดือน)' }}</label></td>
                                        <td colspan="2"><input class="form-control calexpdateall" name="exp_month"
                                                type="number" id="exp_month"  
                                                value="{{ $packpaper->exp_month }}" required></td>
                                    </tr>
                                    <tr>
                                        <td>LOT</td>
                                        @foreach ($packpaper->packpaperpackages as $packageObj)
                                            <td>
                                                <select name="lottxt{{ $packageObj->id }}" class="form-control" id="lottxt{{ $packageObj->id }}">
                                                    <option value="" @if(empty($packageObj->lot)) selected @endif>ไม่ระบุ</option>
                                                    <option value="ระบุ" @if(!empty($packageObj->lot)) selected @endif>ระบุ</option>
                                                </select>  
                                            </td>
                                        @endforeach
                                        <td>
                                            <label for="cable_file" class="control-label">{{ 'รูปแบบการรัดสาย' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="cable_file" type="file" id="cable_file" >
                                            @if (isset($packpaper->cable_img))
                                                <div class="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    <img  src="{{ url($packpaper->cable_img) }}"  height='100px'/>
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
                                        @foreach ($packpaper->packpaperpackages as $packageObj)
                                            <td>
                                                <input class="form-control" name="front_img{{ $packageObj->id }}"
                                                    type="file" id="front_img{{ $packageObj->id }}" >
                                                <input class="form-control" name="front_stamp{{ $packageObj->id }}"
                                                    type="text" id="front_stamp{{ $packageObj->id }}" placeholder="FORMAT การStamp"
                                                    @if (isset($packageObj->front_stamp))   
                                                     value="{{ $packageObj->front_stamp }}" 
                                                    @endif
                                                    >
                                                <input class="form-control" name="front_locstamp{{ $packageObj->id }}"
                                                    type="text" id="front_locstamp{{ $packageObj->id }}" placeholder="ตำแหน่งการStamp"
                                                    @if (isset($packageObj->front_locstamp))   
                                                     value="{{ $packageObj->front_locstamp }}" 
                                                    @endif
                                                    >
                                                     @if (isset($packageObj->front_img))
                                                     <img    
                                                     src="{{ url($packageObj->front_img) }}"  height='100px'/>
                                                    @endif
                                            </td>
                                        @endforeach
                                        <td><label for="inbox_file"
                                                class="control-label">{{ 'การเรียงสินค้าในกล่อง' }}</label></td>
                                        <td colspan="2"><input class="form-control" name="inbox_file"
                                                type="file" id="inbox_file" >
                                            @if (isset($packpaper->inbox_img))
                                             <img  
                                                     src="{{ url($packpaper->inbox_img) }}"  height='100px'/>
                                                @endif
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>ภาพด้านหลัง</td>
                                        @foreach ($packpaper->packpaperpackages as $packageObj)
                                            <td>
                                                <input class="form-control" name="back_img{{ $packageObj->id }}"
                                                    type="file" id="back_img{{ $packageObj->id }}" value="">
                                                    <input class="form-control" name="back_stamp{{ $packageObj->id }}"
                                                    type="text" id="back_stamp{{ $packageObj->id }}" placeholder="FORMAT การStamp"
                                                    @if (isset($packageObj->back_stamp))   
                                                     value="{{ $packageObj->back_stamp }}" 
                                                    @endif
                                                    >
                                                    <input class="form-control" name="back_locstamp{{ $packageObj->id }}"
                                                    type="text" id="back_locstamp{{ $packageObj->id }}" placeholder="ตำแหน่งการStamp"
                                                    @if (isset($packageObj->back_locstamp))   
                                                     value="{{ $packageObj->back_locstamp }}" 
                                                    @endif
                                                    >
                                                     @if (isset($packageObj->back_img))
                                                     <img    
                                                     src="{{ url($packageObj->back_img) }}"  height='100px'/>
                                                    @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            {{-- <div class="position-relative">
                                                <div class="position-absolute top-0 start-0"> --}}
                                                    <label for="pallet_file"class="control-label">{{ 'การเรียงสินค้าในพาเลท' }}</label>
                                                {{-- </div>
                                                <div class="position-absolute bottom-0 start-0">
                                                    <label for="artwork_file" class="control-label">{{ 'Art Work ถุง, กล่อง' }}</label>
                                                </div> --}}
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            {{-- <div class="position-relative">
                                                <div class="position-absolute top-0 start-0"> --}}
                                                    <input class="form-control" name="pallet_file" type="file" id="pallet_file" > 
                                                    @if (isset($packpaper->pallet_img))
                                                        <img src="{{ url($packpaper->pallet_img) }}"  height='100px'/>
                                                    @endif
                                                {{-- </div>
                                                <div class="position-absolute top-0 start-0">
                                                    <input class="form-control" name="artwork_file" type="file" id="artwork_file" > 
                                                    @if (isset($packpaper->artwork_file))
                                                        <img src="{{ url($packpaper->artwork_file) }}"  height='100px'/>
                                                    @endif
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Art Work ถุง, กล่อง</td>                                        
                                        <td>
                                            <input class="form-control" name="artwork_file" type="file" id="artwork_file" >                                           
                                        </td>
                                        <td>
                                            @if (isset($packpaper->artwork_img))
                                                <img src="{{ url($packpaper->artwork_img) }}"  height='100px'/>
                                            @endif                                            
                                        </td>
                                        @for($i = 0; $i < $packpaper->packpaperpackages->count()+1; $i++)
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
            <div class="col-md-4"><label for="product_fac" class="control-label">{{ 'Product Fac' }}</label>
                <input class="form-control" name="product_fac" type="text" id="product_fac"
                                                value="{{ $packpaper->product_fac }}"></div>
            <div class="col-md-4"><label for="plan_version" class="control-label">{{ 'Plan version' }}</label>
                <input class="form-control" name="plan_version" type="text" id="plan_version"
                                                value="{{ $packpaper->plan_version }}"></div>
            <div class="col-md-4"><label for="loading_date" class="control-label">{{ 'LOADING' }}</label>
                <input class="form-control" name="loading_date" type="date"
                        id="loading_date" required value="{{ $packpaper->loading_date }}"></div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="pallet_base" class="control-label">{{ 'ฐานจัดเรียง (กล่อง)' }}</label>
                <input class="form-control" name="pallet_base" data-ref="{{ $lot }}" type="number" id="pallet_base" required value="{{ $packpaper->pallet_base }}">
            </div>
            <div class="col-md-4">
                <label for="pallet_low" class="control-label">{{ 'จัดเรียงแบบที่ 1 (ชั้น)' }}</label>
                <input class="form-control" name="pallet_low" type="number" id="pallet_low" required value="{{ $packpaper->pallet_low }}">
            </div>
            <div class="col-md-4">
                <label for="pallet_height" class="control-label">{{ 'จัดเรียงแบบที่ 2 (ชั้น)' }}</label>
                <input class="form-control" name="pallet_height" type="number" id="pallet_height" required value="{{ $packpaper->pallet_height }}">
            </div>
        </div>
        
        <br/>
        <input type="hidden" name="number_per_pack" id="number_per_pack" value="{{ $packpaper->packaging->number_per_pack }}" />
        <input type="hidden" name="outer_weight_kg" id="outer_weight_kg" value="{{ $packpaper->packaging->outer_weight_kg }}" />
        
        จัดการ LOT <a href="{{ url('/pack_papers/edit_genOrder/' . $packpaper->id . '/' . ($lot + 1)) }}"><i
                class="fa fa-plus-circle" aria-hidden="true"></i></a>
        @if ($lot > 1)
            <a href="{{ url('/pack_papers/edit_genOrder/' . $packpaper->id . '/' . ($lot - 1)) }}"><i
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
                    @for ($i = 0; $i<$lot; $i++)
                        <tr>
                            <td><input class="form-control calexpdatelot" name="packdate{{ $i }}" type="date"
                                    id="packdate{{ $i }}" data-ref="{{ $i }}" 
                                    value="@if(!empty($package_lot[$i]->pack_date)){{ $package_lot[$i]->pack_date }}@else{{ \Carbon\Carbon::now()->format('Y-m-d') }}@endif">
                                <br /><input class="form-control" name="expdate{{ $i }}" type="date"
                                    id="expdate{{ $i }}" value="@if(!empty($package_lot[$i]->exp_date)){{ $package_lot[$i]->exp_date }}@endif">
                            </td>
                            <td><input class="form-control" name="lot{{ $i }}" type="text"
                                    id="lot{{ $i }}" value="@if(!empty($package_lot[$i]->lot)) {{ $package_lot[$i]->lot }} @endif" required>
                                <br />
                                <select name="pattern_pallet{{ $i }}" class="form-control col w-75 pattern_format" id="pattern_pallet{{ $i }}" required>
                                    <option value="1"@if($package_lot[$i]->pattern_pallet==1) selected @endif>จัดเรียงแบบที่ 1</option>
                                    <option value="2"@if($package_lot[$i]->pattern_pallet==2) selected @endif>จัดเรียงแบบที่ 2</option>
                                </select>
                            </td>
                            <td><input class="form-control calbox" name="fbox{{ $i }}"
                                    data-ref="{{ $i }}" type="number" id="fbox{{ $i }}" value="@if(!empty($package_lot[$i]->frombox)){{ $package_lot[$i]->frombox }}@endif" readonly>
                                <br /><input class="form-control calbox" name="tbox{{ $i }}"
                                    data-ref="{{ $i }}" type="number" id="tbox{{ $i }}" value="@if(!empty($package_lot[$i]->tobox)){{ $package_lot[$i]->tobox }}@endif" readonly>
                            </td>
                            <td><input class="form-control" name="nbox{{ $i }}" type="text"
                                    id="nbox{{ $i }}" value="@if(!empty($package_lot[$i]->nbox)) {{ $package_lot[$i]->nbox }} @endif" readonly>
                                <br /><input class="form-control" name="nbag{{ $i }}" type="text"
                                    id="nbag{{ $i }}" value="@if(!empty($package_lot[$i]->nbag)) {{ $package_lot[$i]->nbag }} @endif" readonly>
                            </td>
                            <td><input class="form-control" name="pweight{{ $i }}" type="text"
                                    id="pweight{{ $i }}" value="@if(!empty($package_lot[$i]->pweight)) {{ number_format($package_lot[$i]->pweight,2) }} @endif" readonly>
                                <br /><input class="form-control" name="fweight{{ $i }}" type="text"
                                    id="fweight{{ $i }}" value="@if(!empty($package_lot[$i]->fweight)) {{ number_format($package_lot[$i]->fweight,2) }} @endif" readonly>
                            </td>
                            <td><input class="form-control npallet" name="pallet{{ $i }}" type="text"
                                    id="pallet{{ $i }}" value="@if(!empty($package_lot[$i]->pallet)) {{ $package_lot[$i]->pallet }} @endif" required>
                                <br /><input class="form-control npbag" name="pbag{{ $i }}" type="text"
                                    id="pbag{{ $i }}" value="@if(!empty($package_lot[$i]->pbag)) {{ $package_lot[$i]->pbag }} @endif">
                            </td>
                            <td><input class="form-control" name="note{{ $i }}" type="text"
                                    id="note{{ $i }}" value="@if(!empty($package_lot[$i]->note)) {{ $package_lot[$i]->note }} @endif">
                                {{-- <div class="row"> --}}
                                    <label for="cablecover{{ $i }}" class="control-label col">{{ 'สายรัด' }}</label>
                                    
                                    <select name="cablecover{{ $i }}" class="form-control col w-75" id="cablecover{{ $i }}" required>
                                        <option value="" @if(empty($package_lot[$i]->cablecover)){{ 'selected' }}@endif>-</option>
                                        @foreach ($cablecoverlist as $optionKey => $optionValue)
                                            <option value="{{ $optionKey }}"@if((!empty($package_lot[$i]->cablecover)) && ($package_lot[$i]->cablecover== $optionKey)){{ 'selected' }}@endif>{{ $optionValue }}</option>
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
