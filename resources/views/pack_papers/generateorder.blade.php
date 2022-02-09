@extends('layouts.apppackpaper')

@section('content')
    <div class="container">
        <form method="POST"
                            action="{{ url('/pack_papers/generateOrderAction/' . $packaging->id . '/' . $set . '/' . $lot) }}"
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
                                        <td rowspan="2">{{ $packaging->number_per_pack }} แพ็ค</td>
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
                                        <td>Stamp วันที่ผลิต</td>
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
                                            <label for="weight_with_bag" class="control-label">{{ 'น้ำหนักชั่งรวมถุง' }}</label>
                                        </td>
                                        <td colspan="2">
                                            <input class="form-control" name="weight_with_bag" type="text" id="weight_with_bag" required
                                                value="">
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
                                                class="control-label">{{ 'ระยะเวลาที่หมดอายุ' }}</label></td>
                                        <td colspan="2"><input class="form-control calexpdateall" name="exp_month"
                                                type="number" id="exp_month"  
                                                value="{{ $packaging->product->shelf_life }}"></td>
                                    </tr>
                                    <tr>
                                        <td>LOT</td>
                                        @foreach ($packaging->package as $packageObj)
                                            <td>
                                                <input class="form-control" name="lottxt{{ $packageObj->id }}"
                                                    type="text" id="lottxt{{ $packageObj->id }}" value="">
                                            </td>
                                        @endforeach
                                        <td><label for="cable_file"
                                                class="control-label">{{ 'รูปแบบการรัดสาย' }}</label></td>
                                        <td colspan="2"><input class="form-control" name="cable_file"
                                                type="file" id="cable_file" >
                                            
                                            @if (isset($productinfo->cable_img))
                                             <img  
                                                     src="{{ url($productinfo->cable_img) }}"  height='100px'/>
                                                @endif
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
                                        <td><label for="pallet_file"
                                                class="control-label">{{ 'การเรียงสินค้าในพาเลท' }}</label></td>
                                        <td colspan="2"><input class="form-control" name="pallet_file"
                                                type="file" id="pallet_file" > 
                                                @if (isset($productinfo->pallet_img))
                                             <img  
                                                     src="{{ url($productinfo->pallet_img) }}"  height='100px'/>
                                                @endif
                                            </td></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"><label for="product_fac" class="control-label">{{ 'Product Fac' }}</label>
                <input class="form-control" name="product_fac" type="text" id="product_fac"
                                                value=""></div>
            <div class="col-md-6"><label for="loading_date" class="control-label">{{ 'LOADING' }}</label>
        <input class="form-control" name="loading_date" type="date"
                        id="loading_date" required value=""></div>
        </div>
        
        <br/>
        <input type="hidden" name="number_per_pack" id="number_per_pack" value="{{ $packaging->number_per_pack }}" />
        <input type="hidden" name="outer_weight_kg" id="outer_weight_kg" value="{{ $packaging->outer_weight_kg }}" />
        จัดการบรรจุ <a href="{{ url('/pack_papers/generateOrder/' . $packaging->id . '/' . ($set + 1) . '/' . $lot) }}"><i
                class="fa fa-plus-circle" aria-hidden="true"></i></a>
        @if ($set > 1)
            <a href="{{ url('/pack_papers/generateOrder/' . $packaging->id . '/' . ($set - 1) . '/' . $lot) }}"><i
                    class="fa fa-minus-circle" aria-hidden="true"></i></a>
        @endif
        @for ($iset = 1; $iset <= $set; $iset++)
            <div class="row">
                <div class="col-md-2 {{ $errors->has('pack_date' . $iset) ? 'has-error' : '' }}">
                    <label for="pack_date{{ $iset }}" class="control-label">{{ 'วันที่บรรจุ' }}</label>
                    <input class="form-control calexpdate" name="pack_date{{ $iset }}"
                        data-ref="{{ $iset }}" type="date" id="pack_date{{ $iset }}"
                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    {!! $errors->first('pack_date' . $iset, '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2 {{ $errors->has('exp_date' . $iset) ? 'has-error' : '' }}">
                    <label for="exp_date{{ $iset }}" class="control-label">{{ 'วันที่หมดอายุ' }}</label>
                    <input class="form-control" name="exp_date{{ $iset }}" type="date"
                        id="exp_date{{ $iset }}" required value="">
                    {!! $errors->first('exp_date' . $iset, '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2 {{ $errors->has('all_weight' . $iset) ? 'has-error' : '' }}">
                    <label for="all_weight{{ $iset }}" class="control-label">{{ 'ปริมาณ กก.' }}</label>
                    <input class="form-control" name="all_weight{{ $iset }}" type="number"
                        id="all_weight{{ $iset }}" readonly value="">
                    {!! $errors->first('all_weight' . $iset, '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2 {{ $errors->has('all_bpack' . $iset) ? 'has-error' : '' }}">
                    <label for="all_bpack{{ $iset }}" class="control-label">{{ 'ปริมาณ กล่อง' }}</label>
                    <input class="form-control recalweight" data-ref="{{ $iset }}"  name="all_bpack{{ $iset }}" type="number"
                        id="all_bpack{{ $iset }}" required value="">
                    {!! $errors->first('all_bpack' . $iset, '<p class="help-block">:message</p>') !!}
                </div>
                <div class="col-md-2 {{ $errors->has('cablecover' . $iset) ? 'has-error' : '' }}">
                    <label for="cablecover{{ $iset }}" class="control-label">{{ 'สายรัด' }}</label>
                    
                        <select name="cablecover{{ $iset }}" class="form-control" id="cablecover{{ $iset }}" required>
                            <option value="">-</option>
                        @foreach ($cablecoverlist as $optionKey => $optionValue)
                            <option value="{{ $optionKey }}" {{ (isset($matpackrate->mat_pack_id) && $matpackrate->mat_pack_id == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('all_bpack' . $iset, '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        @endfor
        <br />
        <div class="row">
        </div>
        <br />
        จัดการ LOT <a href="{{ url('/pack_papers/generateOrder/' . $packaging->id . '/' . $set . '/' . ($lot + 1)) }}"><i
                class="fa fa-plus-circle" aria-hidden="true"></i></a>
        @if ($lot > 1)
            <a href="{{ url('/pack_papers/generateOrder/' . $packaging->id . '/' . $set . '/' . ($lot - 1)) }}"><i
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
                                    id="lot{{ $i }}" value=""></td>
                            <td><input class="form-control calbox" name="fbox{{ $i }}"
                                    data-ref="{{ $i }}" type="number" id="fbox{{ $i }}" value="0">
                                <br /><input class="form-control calbox" name="tbox{{ $i }}"
                                    data-ref="{{ $i }}" type="number" id="tbox{{ $i }}" value="0">
                            </td>
                            <td><input class="form-control" name="nbox{{ $i }}" type="text"
                                    id="nbox{{ $i }}" value="">
                                <br /><input class="form-control" name="nbag{{ $i }}" type="text"
                                    id="nbag{{ $i }}" value="">
                            </td>
                            <td><input class="form-control" name="pweight{{ $i }}" type="text"
                                    id="pweight{{ $i }}" value="">
                                <br /><input class="form-control" name="fweight{{ $i }}" type="text"
                                    id="fweight{{ $i }}" value="">
                            </td>
                            <td><input class="form-control" name="pallet{{ $i }}" type="text"
                                    id="pallet{{ $i }}" value="">
                                <br /><input class="form-control" name="pbag{{ $i }}" type="text"
                                    id="pbag{{ $i }}" value="">
                            </td>
                            <td><input class="form-control" name="note{{ $i }}" type="text"
                                    id="note{{ $i }}" value=""></td>
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
