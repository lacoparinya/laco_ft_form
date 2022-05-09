@extends('layouts.app')
<style>
   table.myFont { 
      font-size: 12px; 
      margin-left: auto;
      margin-right: auto;
   }
   tr th.tleft {
       border: none;
       text-align: left;
       word-wrap: normal;
   }
   tr th.tright {
       border: none;
       text-align: right;
       word-wrap: normal;
   }
   tr th.tcenter {
       border: none;
       text-align: center;
       word-wrap: normal;
   }    
   tr th.tcenterb {
       border: 1px solid #000000;
       text-align: center;
       word-wrap: normal;
   }    
   tr th.tcenterbnt {
        border-top: none;
        border-right: 1px solid #000000;
        border-bottom: 1px solid #000000;
        border-left: 1px solid #000000;
        text-align: center;
        word-wrap: normal;
   }       
   tr th.tcenterbnb {
        border-top: 1px solid #000000;
        border-right: 1px solid #000000;
        border-bottom: none;
        border-left: 1px solid #000000;
        text-align: center;
        word-wrap: normal;
   }

   tr td.tcentertna {
        border-top: 1px solid #000000;
        border-right: none;
        border-bottom: none;
        border-left: none;
        text-align: center;
        word-wrap: normal;
   }
   tr td.tleft {
       border: none;
       text-align: left;
       word-wrap: normal;
   }
   tr td.tright {
       border: none;
       text-align: right;
       word-wrap: normal;
   }
   tr td.tcenter {
       border: none;
       text-align: center;
       word-wrap: normal;
   }
   tr td.tleftb {
       border: 1px solid #000000;
       text-align: left;
       word-wrap: normal;
   }
   tr td.trightb {
       border: 1px solid #000000;
       text-align: right;
       word-wrap: normal;
   }
   tr td.tcenterb {
       border: 1px solid #000000;
       text-align: center;
       word-wrap: normal;
   }
   /*tr td.noborder {
       border: none;
   }
    tr th.noborder-last {
       border: none;
       word-wrap: normal;
   }
   tr th.noborderr {
       border: none;
       text-align: right;
       word-wrap: break-word;
   }
   tr th.noborderc {
       border: none;
       text-align: center;
       word-wrap: break-word;
       font: bolder;
   }
    tr td {
       border: 1px solid #000000;
       word-wrap: normal;
   } */
</style>
@section('content')
   @php      
      $arr_pack = array();
      foreach($packpaper->packpaperpackages()->get() as $packageObj){
         // echo $packageObj->packaging->name.'--';
         // echo $packageObj->packaging->name.'->'.strpos($packageObj->packaging->name,'COV').'--';
         if(strpos($packageObj->packaging->name,'COV') === False){          
            if((substr($packageObj->packaging->name,0,2) == 'KI') || (substr($packageObj->packaging->name,0,2) == 'KC')){
               // if((strpos($packpaper->packaging->product->name,"CCB") === true) || (strpos($packpaper->packaging->product->name,"CCS") === true)  || 
               // (strpos($packpaper->packaging->product->name,"RPN") === true) || (strpos($packpaper->packaging->product->name,"TRA") === true)){
                  $arr_pack[$packageObj->packaging->packagetype->name]['pack_name'][] = $packageObj->packaging->name;
                  $arr_pack[$packageObj->packaging->packagetype->name]['sap_name'][] = $packageObj->packaging->sapnote; 
                  $arr_pack[$packageObj->packaging->packagetype->name]['pack_date'][] = $packageObj->pack_date_format; 
                  $arr_pack[$packageObj->packaging->packagetype->name]['exp_date'][] = $packageObj->exp_date_format; 
                  $arr_pack[$packageObj->packaging->packagetype->name]['lot'][] = $packageObj->lot; 
                  $arr_pack[$packageObj->packaging->packagetype->name]['front_img'][] = $packageObj->front_img; 
                  $arr_pack[$packageObj->packaging->packagetype->name]['back_img'][] = $packageObj->back_img;  
                  $arr_pack[$packageObj->packaging->packagetype->name]['front_stamp'][] = $packageObj->front_stamp; 
                  $arr_pack[$packageObj->packaging->packagetype->name]['back_stamp'][] = $packageObj->back_stamp;  
                  $arr_pack[$packageObj->packaging->packagetype->name]['front_locstamp'][] = $packageObj->front_locstamp; 
                  $arr_pack[$packageObj->packaging->packagetype->name]['back_locstamp'][] = $packageObj->back_locstamp;        
                  // $count_pack += 1;
                  // $arr_pack[] = $packageObj;

               // }
            }else{
               if((strpos($packpaper->packaging->product->name,"CCB") === False) && (strpos($packpaper->packaging->product->name,"CCS") === False)  && 
               (strpos($packpaper->packaging->product->name,"RPN") === False) && (strpos($packpaper->packaging->product->name,"TRA") === False)){ 
                  if((substr($packageObj->packaging->name,0,2) === 'KB') || (substr($packageObj->packaging->name,0,2) === 'KT')){
                     $arr_pack[$packageObj->packaging->packagetype->name]['pack_name'][] = $packageObj->packaging->name;
                     $arr_pack[$packageObj->packaging->packagetype->name]['sap_name'][] = $packageObj->packaging->sapnote;
                     $arr_pack[$packageObj->packaging->packagetype->name]['pack_date'][] = $packageObj->pack_date_format; 
                     $arr_pack[$packageObj->packaging->packagetype->name]['exp_date'][] = $packageObj->exp_date_format; 
                     $arr_pack[$packageObj->packaging->packagetype->name]['lot'][] = $packageObj->lot; 
                     $arr_pack[$packageObj->packaging->packagetype->name]['front_img'][] = $packageObj->front_img; 
                     $arr_pack[$packageObj->packaging->packagetype->name]['back_img'][] = $packageObj->back_img;  
                     $arr_pack[$packageObj->packaging->packagetype->name]['front_stamp'][] = $packageObj->front_stamp; 
                     $arr_pack[$packageObj->packaging->packagetype->name]['back_stamp'][] = $packageObj->back_stamp; 
                     $arr_pack[$packageObj->packaging->packagetype->name]['front_locstamp'][] = $packageObj->front_locstamp; 
                     $arr_pack[$packageObj->packaging->packagetype->name]['back_locstamp'][] = $packageObj->back_locstamp;
                     // $count_pack += 1;
                     // $arr_pack[] = $packageObj;
                  }
               }
            }
            
         }
      }
      // dd($arr_pack);
      $count_pack = 0;
      $max_pack = 0;
      if(count($arr_pack)>0){
         foreach($arr_pack as $ktype=>$vtype){
            $show_pack[] = $ktype;  //ใช้ในตาราง 5
            if($max_pack < count($arr_pack[$ktype]['pack_name'])){
               $max_pack = count($arr_pack[$ktype]['pack_name']); //ใช้ในตาราง 1
            }
         }
         $count_pack = count($arr_pack);
      }
      // print_r($arr_pack);
      $count_col = 9 + $count_pack;
      $i=0; $p=0;
      foreach ($packpaper->packpaperds()->get() as $packpaperd){
         $pack_d[] = $packpaperd;
      }
   @endphp
   
   {{-- หัวตาราง --}}
   <table style="width: 99%" class="myFont">
      <tr>
         <th style="text-align: left;width: 5%">LACO</th>
         <th style="width: 20%"></th>         
         <th style="text-align:right;width: 75%">ประกาศใช้วันที่ :01/04/65</th>     
      </tr>
      <tr>
         <th colspan="3" style="text-align:center">ใบแจ้งการบรรจุผลิตภัณฑ์แช่แข็งสำเร็จรูป</th>
      </tr>
      <tr>
         <th style="text-align: left" colspan="2">รหัสเอกสาร:F-PL-PK-001/1</th>
         <th style="text-align:right">การประกาศใช้ครั้งที่ : 04</th>
      </tr>
      <tr>
         <th style="text-align: left">วันที่</th>
         <th style="text-align: left">{{ date('d',strtotime($packpaper->created_at)) }}/{{ date('m',strtotime($packpaper->created_at)) }}/{{ substr((date('Y',strtotime($packpaper->created_at))+543), 2, 2) }}</th>
         <th style="text-align:right">plan version : {{ $packpaper->plan_version }}</th>
      </tr>
   </table>

   <br>

   {{-- ตาราง 1 --}}   
   <table class="myFont" style="width: 99%">
      <tr>
         <th style="width: 3%"></th>
         <th rowspan="2" class="tcenterb" style="width: 14.5%">ผลิตภัณฑ์</th>
         <th rowspan="2" class="tcenterb" style="width: 3.5%">ลูกค้า</th>
         <th rowspan="2" class="tcenterb" style="width: 5.5%">วันที่บรรจุ</th>
         <th class="tcenterbnb" style="width: 9%">ORDER </th>
         <th class="tcenterb" colspan="{{ $count_pack }}">ชนิดของถุงและกล่อง</th>
         <th class="tcenterb" colspan="3">ขนาดบรรจุ</th>
         <th class="tcenterb" rowspan="2">สีสายรัด</th>
      </tr>
      <tr>
         <th></th>
         <th class="tcenterbnt">NUMBER</th>
         @foreach($arr_pack as $ktype=>$vtype)
               <th class="tcenterb">@if(!empty(config('myconfig.head_column.'.$ktype))){{ config('myconfig.head_column.'.$ktype) }}@else{{ $ktype }}@endif</th> 
         @endforeach 
         <th class="tcenterb">น้ำหนัก / ถุง</th>
         <th class="tcenterb">จำนวนถุง / กล่อง</th>
         <th class="tcenterb">น้ำหนัก / กล่อง</th>
      </tr>
      <tr>
         <td class="tcenter">std.</td>
         <td class="tcenterb">{{ $packpaper->packaging->product->name }}</td>
         <td class="tcenterb">{{ $packpaper->packaging->product->customer->name }}</td>
         <td class="tcenterb">ว/ด/ป</td>
         <td class="tcenterb">ตามใบแจ้งโหลด</td>
         @foreach($arr_pack as $ktype=>$vtype)  
            <td class="tcenterb">                    
               <table class="myFont" style="width: 100%">
                  @foreach($arr_pack[$ktype]['pack_name'] as $kno=>$vno)  
                     @if(!empty($vno))
                        <tr>
                           <td class="@if($kno==0) tcenter @else tcentertna @endif">
                              {{ $vno }}
                           </td>
                        </tr>
                     @endif
                     @if(!empty($arr_pack[$ktype]['sap_name']) && ($kno<(count($arr_pack[$ktype]['pack_name'])-1)))
                        <tr>
                           <td class="tcentertna">
                              {{ $arr_pack[$ktype]['sap_name'][$kno] }}
                           </td>
                        </tr>
                     @endif 
                  @endforeach
               </table>
            </td>   
         @endforeach
         <td class="tcenterb">{{ number_format($packpaper->packaging->inner_weight_g, 2, '.', ',') }} กรัม</td>
         <td class="tcenterb">{{ $packpaper->packaging->number_per_pack }} ถุง</td>
         <td class="tcenterb">{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
         <td class="tcenterb">ไม่มีการรัดสาย</td>
      </tr>
      <tr>
         <td class="tcenter" style="font-size: 8px; ">Descrip</td>
         @for($i=0;$i<4;$i++)
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
         @endfor 
         @foreach($arr_pack as $ktype=>$vtype) 
            @php
               $arr = count($arr_pack[$ktype]['sap_name'])-1;
            @endphp
            <td class="tcenterb" @if(empty($arr_pack[$ktype]['sap_name'][$arr])) style="background-color: #DCDCDC" @endif>  
               {{ App\Http\Controllers\PackPapersController::check_null($arr_pack[$ktype]['sap_name'][$arr]) }}
            </td>   
         @endforeach       
         <td class="tcenterb">น้ำหนักชั่งรวมถุง</td>
         @for($i=0;$i<3;$i++)
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
         @endfor
      </tr>
      <tr>
         <td class="tleft" rowspan="{{ count($p_date) }}"></td>
         <td class="tcenterb" rowspan="{{ count($p_date) }}">{{ $packpaper->packaging->product->name }}</td>
         <td class="tcenterb" rowspan="{{ count($p_date) }}">{{ $packpaper->packaging->product->customer->name }}</td> 
         <td class="tcenterb">{{ date("d", strtotime($p_date[0])) }}/{{ date("m", strtotime($p_date[0])) }}/{{ substr((date("Y", strtotime($p_date[0]))+543),2,2) }}</td>  
         <td class="tcenterb" rowspan="{{ count($p_date) }}">{{ $packpaper->order_no }}</td>
         @foreach($arr_pack as $ktype=>$vtype)  
            <td class="tcenterb" rowspan="{{ count($p_date) }}">  
               {{-- @if(count($arr_pack[$ktype]['pack_name'])>1)                     --}}
                  <table class="myFont" style="width: 100%">
                     @foreach($arr_pack[$ktype]['pack_name'] as $kno=>$vno)
                        <tr>
                           <td class="@if($kno==0) tcenter @else tcentertna @endif">
                              {{ $vno }}
                           </td>
                        </tr>
                     @endforeach
                  </table>
               {{-- @else
                  {{ App\Http\Controllers\PackPapersController::check_null($arr_pack[$ktype]['pack_name'][0]) }}
               @endif --}}
            </td>   
         @endforeach 
         <td class="tcenterb" rowspan="{{ count($p_date) }}">{{ $packpaper->weight_with_bag  }} กรัม</td>
         <td class="tcenterb" rowspan="{{ count($p_date) }}">{{ $packpaper->packaging->number_per_pack }} ถุง</td>
         <td class="tcenterb" rowspan="{{ count($p_date) }}">{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
         <td class="tcenterb" rowspan="{{ count($p_date) }}">{{ $packpaperd->cablecover }}</td>
      </tr>
      @for($i=1;$i<count($p_date);$i++)
         <tr>
            <td class="tcenterb">{{ date("d", strtotime($p_date[$i])) }}/{{ date("m", strtotime($p_date[$i])) }}/{{ substr((date("Y", strtotime($p_date[$i]))+543),2,2) }}</td>               
         </tr>
      @endfor
   </table>

   <br>

   {{-- ตาราง 2 --}}
   <table class="myFont" style="width: 99%">
      <tr>
         <td style="width: 3%"></td>
         <th colspan="2" class="tcenterb">ปริมาณ</th>
         <th class="tcenterbnb" style="width: 9%">ระยะเวลาที่หมด</th>
         <th rowspan="2" class="tcenterb" style="width: 7.5%">วันที่หมดอายุ</th>
         @foreach ($arr_pack as $ktype=>$vtype)
            <th class="tcenterb" rowspan="2" style="width: 12%">วันที่ผลิต บน @if(!empty(config('myconfig.head_column.'.$ktype))){{ config('myconfig.head_column.'.$ktype) }}@else{{ $ktype }}@endif</th>
            <th class="tcenterb" rowspan="2" style="width: 14%">วันที่หมดอายุ บน @if(!empty(config('myconfig.head_column.'.$ktype))){{ config('myconfig.head_column.'.$ktype) }}@else{{ $ktype }}@endif</th>
            <th class="tcenterb" rowspan="2" style="width: 9%">Lot บน @if(!empty(config('myconfig.head_column.'.$ktype))){{ config('myconfig.head_column.'.$ktype) }}@else{{ $ktype }}@endif</th>               
         @endforeach  
      </tr>
      <tr>
         <td></td>
         <th class="tcenterb" style="width: 5%">กก.</th>
         <th class="tcenterb" style="width: 3.5%">กล่อง</th>
         <th class="tcenterbnt">อายุ (เดือน)</th>            
      </tr>
      <tr>
         <td class="tcenter">std.</td>
         <td class="tcenterb">-</td>
         <td class="tcenterb">-</td>
         <td class="tcenterb">{{ $packpaper->exp_month }}</td>
         <td class="tcenterb">ว/ด/ป</td>
         @foreach ($arr_pack as $ktype=>$vtype)                                             
            <td class="tcenterb">
               @if (empty($arr_pack[$ktype]['pack_date'][0]))
                  ไม่ระบุ
               @else
                  {{ App\Http\Controllers\PackPapersController::extract_int($arr_pack[$ktype]['pack_date'][0]) }}
               @endif
            </td>
            <td class="tcenterb">
               @if (empty($arr_pack[$ktype]['exp_date'][0]))
                  ไม่ระบุ
               @else
                  {{ App\Http\Controllers\PackPapersController::extract_int($arr_pack[$ktype]['exp_date'][0]) }}
               @endif
            </td>
            <td class="tcenterb">
               @if (empty($arr_pack[$ktype]['lot'][0]))
                  ไม่ระบุ
               @else
                  {{ $arr_pack[$ktype]['lot'][0] }}
               @endif
            </td>
         @endforeach
      </tr>
      @foreach ($tbl_2 as $kfdate=>$vfdate)
            @foreach ($vfdate as $ktdate=>$vtdate)
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb">{{ number_format(($tbl_2[$kfdate][$ktdate]['num_box'] * $packpaper->packaging->outer_weight_kg),2) }}</td>
               <td class="tcenterb">{{ number_format($tbl_2[$kfdate][$ktdate]['num_box']) }}</td>
               <td class="tcenterb">{{ $packpaper->exp_month  }}</td>
               <td class="tcenterb">{{ date("d", strtotime($ktdate)) }}/{{ date("m", strtotime($ktdate)) }}/{{ substr((date("Y", strtotime($ktdate))+543),2,2) }}</td>
               @foreach ($arr_pack as $ktype=>$vtype)                                             
                  <td class="tcenterb">
                     @if (empty($arr_pack[$ktype]['pack_date'][0]))
                        ไม่ระบุ
                     @else
                        {{ App\Http\Controllers\PackPapersController::format_date($arr_pack[$ktype]['pack_date'][0],$kfdate,$packpaper->pack_thai_year) }}
                     @endif
                  </td>
                  <td class="tcenterb">
                     @if (empty($arr_pack[$ktype]['exp_date'][0]))
                        ไม่ระบุ
                     @else
                        @php
                           $lotSymbol = strpos($arr_pack[$ktype]['exp_date'][0],"LOT");
                        @endphp
                        {{ App\Http\Controllers\PackPapersController::format_date($arr_pack[$ktype]['exp_date'][0],$ktdate,'') }}
                        @if ($lotSymbol > 0)
                           A
                        @endif
                     @endif
                  </td>
                  <td class="tcenterb">
                     @if (empty($arr_pack[$ktype]['lot'][0]))
                        ไม่ระบุ
                     @else
                        {{ $tbl_2[$kfdate][$ktdate]['lot'] }}
                     @endif
                  </td>
               @endforeach
            </tr>  
         @endforeach  
      @endforeach
   </table>
   <br>


   {{-- ตาราง 3 --}}
   <table class="myFont" style="width: 99%">
      <thead>
         <tr>
            @php
               $allcols = 8 + (2 * $count_pack );
            @endphp
            <th  colspan="{{ $allcols }}" class="tcenterb">การ STAMP ถุง และกล่อง </th>
         </tr>
         <tr>
            @foreach ($arr_pack as $ktype=>$vtype)
               <th colspan="2" class="tcenterb">การ STAMP @if(!empty(config('myconfig.head_column.'.$ktype))){{ config('myconfig.head_column.'.$ktype) }}@else{{ $ktype }}@endif สำเร็จรูป</th>
            @endforeach
            <th rowspan="2" class="tcenterb">Lot</th>
            <th rowspan="2" class="tcenterb">NO.</th>
            <th rowspan="2" class="tcenterb">จำนวนกล่อง</th>	
            <th rowspan="2" class="tcenterb">จำนวนถุง</th>	
            <th rowspan="2" class="tcenterb">น้ำหนักผลิตภัณฑ์/P</th>
            <th rowspan="2" class="tcenterb">น้ำหนักผลิตภัณฑ์/F</th>	
            <th rowspan="2" class="tcenterb">จำนวนพาเลท</th>	
            <th rowspan="2" class="tcenterb">จำนวนกล่องพาเลทสุดท้าย</th>
         </tr>
         <tr>
            @foreach ($arr_pack as $ktype=>$vtype)
               <th class="tcenterb">วันที่ผลิต</th>
               <th class="tcenterb">วันที่หมดอายุ</th>
            @endforeach
         </tr>
      </thead>
      <tbody>
         @php
            $sumqty = 0;
            $sumkg = 0;
         @endphp
         @foreach ($packpaper->packpaperdlots()->get() as $item)
            @php
               $sumqty += $item->nbox;
               $sumkg += $item->fweight;
            @endphp
            <tr>                  
               @foreach ($arr_pack as $ktype=>$vtype)
                  <td class="tcenterb">
                     @if (empty($arr_pack[$ktype]['pack_date'][0]))
                        ไม่ระบุ
                     @else
                        {{ App\Http\Controllers\PackPapersController::format_date($arr_pack[$ktype]['pack_date'][0],$kfdate,$packpaper->pack_thai_year) }}
                     @endif
                  </td>
                  <td class="tcenterb">
                     @if (empty($arr_pack[$ktype]['exp_date'][0]))
                        ไม่ระบุ
                     @else                           
                        {{ App\Http\Controllers\PackPapersController::format_date($arr_pack[$ktype]['exp_date'][0],$ktdate,'') }}
                     @endif
                  </td>
               @endforeach
               <td class="tcenterb">{{ $item->lot }}</td>
               <td class="tcenterb">{{ $item->frombox }} - {{ $item->tobox }}</td>
               <td class="tcenterb">{{ number_format($item->nbox,0,'.',',') }}</td>
               <td class="tcenterb">{{ number_format($item->nbag,0,'.',',') }}</td>
               <td class="tcenterb">{{ number_format($item->pweight,2,'.',',')}}</td>
               <td class="tcenterb">{{ number_format($item->fweight,2,'.',',') }}</td>
               <td class="tcenterb">{{ $item->pallet }}</td>
               <td class="tcenterb">{{ $item->pbag }}</td>
            </tr>    
         @endforeach            
      </tbody>
   </table>

   {{-- หมายเหตุ --}}
   <table style="width: 99%" class="myFont">
      <tr>
         <td style="width: 7%"><h5>หมายเหตุ : </h5></td>
         <td style="width: 93%">
            @foreach($packpaper->packpaperpackages()->get() as $packageObj)
               @if(!empty($packageObj->extra_stamp))
                  {{ $packageObj->packaging->name }}->{{ $packageObj->extra_stamp }},
               @endif
            @endforeach
         </td>              
      </tr>            
   </table>
   <br>

   @if($count_pack==3)
      <div style="page-break-after: always"></div>
   @endif

   {{-- ตาราง 4 --}}
   <table class="myFont" style="width: 99%">
      <thead>
          <tr>
              <th class="tcenterb">#</th>
              <th class="tcenterb">CUST.</th>
              <th class="tcenterb">ORDER</th>
              <th class="tcenterb">Product Fac</th>
              <th class="tcenterb">Product Name</th>
              <th class="tcenterb">QUANTITY (kg.)</th>
              <th class="tcenterb">CARTON</th>
              <th class="tcenterb">LOADING</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td class="tcenterb">1</td>
              <td class="tcenterb">{{ $packpaper->packaging->product->customer->name }}</td>
              <td class="tcenterb">{{ $packpaper->order_no }}</td>
              <td class="tcenterb">{{ $packpaper->product_fac }}</td>
              <td class="tcenterb">{{ $packpaper->packaging->product->name }}</td>
              <td class="tcenterb">{{ number_format($sumkg,2,'.',',') }}</td>
              <td class="tcenterb">{{ number_format($sumqty,0,'.',',') }}</td>
              <td class="tcenterb">{{ $packpaper->loading_date }}</td>
          </tr>
      </tbody>
   </table>
   <div class="row">
      <div class="col-md-2">
         <h5>Remark : SL Document :</h5>
      </div>
   </div>

   <br>

   {{-- เซ็นต์ชื่อ --}}
   <table class="myFont" style="width: 99%;">      
      <tr>
         <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 1%"></td>
         <td style="width: 49%">จัดทำโดย…………….……………………………...พนักงานแผนกขึ้นไป</td>   
         <td style="width: 1%"></td>     
         <td style="width: 49%">ตรวจสอบโดย….….....……………….……………. หัวหน้าแผนกคัดและบรรจุ/แผนกผลิตแช่แข็งขึ้นไป</td>
      </tr>
      <tr>
         <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
         <td></td>
         <td>ตรวจทานโดย……..…..………….………………… หัวหน้าแผนกวางแผนการผลิตขึ้นไป</td>
         <td></td>
         <td>ตรวจทานโดย……..….............…………………… ผู้ช่วยผู้จัดการแผนกประกันคุณภาพ/แผนกควบคุมคุณภาพขึ้นไป</td>
      </tr>    
      <tr>
         <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
         <td></td>
         <td>รับทราบโดย……..……….................………………หัวหน้าแผนกควบคุมคุณภาพขึ้นไป</td>
         <td></td>
         <td>อนุมัติโดย……….………………..…………….......ผู้ช่วยผู้จัดการฝ่ายโรงงานขึ้นไป </td>
      </tr>
   </table>

   <br>

   <div style="page-break-after: always"></div>

   {{-- ตาราง 5 --}}
   @if($count_pack<3)
      <table class="myFont" style="width: 99%;">      
         <tr>
            <td colspan="{{ ($count_pack*2) }}" class="tcenterb">ตำแหน่งการ Stamp ถุงและกล่อง  </td>
         </tr>
         <tr>
            @foreach ($arr_pack as $ktype=>$vtype)
               <td class="tcenterb" colspan="2">@if(!empty(config('myconfig.head_column.'.$ktype))){{ config('myconfig.head_column.'.$ktype) }}@else{{ $ktype }}@endif</td>
            @endforeach
         </tr>
         <tr>
            @foreach ($arr_pack as $ktype=>$vtype)         
               <td class="tcenterb">ด้านหน้า</td>
               <td class="tcenterb">ด้านหลัง</td>         
            @endforeach
         </tr>
         <tr>
            @foreach ($arr_pack as $ktype=>$vtype)
               <td class="tcenterb">
                  @if (isset($arr_pack[$ktype]['front_img'][0]))
                     <img src="{{ url($arr_pack[$ktype]['front_img'][0]) }}"  height='200px'/></td>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
                  @endif
               </td>
               <td class="tcenterb">
                  @if (isset($arr_pack[$ktype]['back_img'][0]))
                     <img src="{{ url($arr_pack[$ktype]['back_img'][0]) }}"  height='200px'/>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
                  @endif
               </td>
            @endforeach
         </tr>
         <tr>
            @foreach ($arr_pack as $ktype=>$vtype)
               <td class="tcenterb">FORMAT การStamp : 
                  @if (isset($arr_pack[$ktype]['front_stamp'][0]))
                     {{ $arr_pack[$ktype]['front_stamp'][0] }}
                  @endif
               </td>
               <td class="tcenterb">FORMAT การStamp : 
                  @if (isset($arr_pack[$ktype]['back_stamp'][0]))
                  {{ $arr_pack[$ktype]['back_stamp'][0] }}
                  @endif
               </td>
            @endforeach
         </tr>
         <tr>
            @foreach ($arr_pack as $ktype=>$vtype)
               <td class="tcenterb">ตำแหน่งการStamp : 
                  @if (isset($arr_pack[$ktype]['front_locstamp'][0]))
                     {{ $arr_pack[$ktype]['front_locstamp'][0] }}
                  @endif
               </td>
               <td class="tcenterb">ตำแหน่งการStamp : 
                  @if (isset($arr_pack[$ktype]['back_locstamp'][0]))
                     {{ $arr_pack[$ktype]['back_locstamp'][0] }}
                  @endif
               </td>
            @endforeach
         </tr>
      </table>       
      <br>
   @else
      @for($p=0;$p<($count_pack-1);$p++)
         @php
            if($p<>0 && $p<($count_pack-1)){
               $p++;               
            }  
         @endphp
         <table class="myFont" style="width: 99%;">      
            <tr>
               <td colspan="@if($p+1<$count_pack){{ 4 }}@else{{ 2 }}@endif" class="tcenterb">ตำแหน่งการ Stamp ถุงและกล่อง  </td>
            </tr>
            <tr>
               @for($i=0; $i<2;$i++) 
                  @if($i+$p<$count_pack)
                     @php
                        $pt = $show_pack[($i+$p)];
                     @endphp
                     <td class="tcenterb" colspan="2">@if(!empty(config('myconfig.head_column.'.$pt))){{ config('myconfig.head_column.'.$pt) }}@else{{ $pt }}@endif</td>
                  @endif
               @endfor
            </tr>
            <tr> 
               @for($i=0; $i<2;$i++) 
                  @if($i+$p<$count_pack)
                     <td class="tcenterb">ด้านหน้า</td>
                     <td class="tcenterb">ด้านหลัง</td>   
                  @endif
               @endfor
            </tr>
            <tr>
               @for($i=0; $i<2;$i++) 
                  @if($i+$p<$count_pack)
                     @php
                        $pt = $show_pack[($i+$p)];
                     @endphp
                     <td class="tcenterb">
                        @if (isset($arr_pack[$pt]['front_img'][0]))
                           <img src="{{ url($arr_pack[$pt]['front_img'][0]) }}"  height='200px'/></td>
                        @else 
                           <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
                        @endif
                     </td>
                     <td class="tcenterb">
                        @if (isset($arr_pack[$pt]['back_img'][0]))
                           <img src="{{ url($arr_pack[$pt]['back_img'][0]) }}"  height='200px'/>
                        @else 
                           <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
                        @endif
                     </td>
                  @endif
               @endfor
            </tr>
            <tr>
               @for($i=0; $i<2;$i++) 
                  @if($i+$p<$count_pack)                  
                     @php
                        $pt = $show_pack[($i+$p)];
                     @endphp
                     <td class="tcenterb">FORMAT การStamp : 
                        @if (isset($arr_pack[$pt]['front_stamp'][0]))
                           {{ $arr_pack[$pt]['front_stamp'][0] }}
                        @endif
                     </td>
                     <td class="tcenterb">FORMAT การStamp : 
                        @if (isset($arr_pack[$pt]['back_stamp'][0]))
                        {{ $arr_pack[$pt]['back_stamp'][0] }}
                        @endif
                     </td>
                  @endif
               @endfor
            </tr>
            <tr>
               @for($i=0; $i<2;$i++) 
                  @if($i+$p<$count_pack)            
                     @php
                        $pt = $show_pack[($i+$p)];
                     @endphp
                     <td class="tcenterb">ตำแหน่งการStamp : 
                        @if (isset($arr_pack[$pt]['front_locstamp'][0]))
                           {{ $arr_pack[$pt]['front_locstamp'][0] }}
                        @endif
                     </td>
                     <td class="tcenterb">ตำแหน่งการStamp : 
                        @if (isset($arr_pack[$pt]['back_locstamp'][0]))
                           {{ $arr_pack[$pt]['back_locstamp'][0] }}
                        @endif
                     </td>
                  @endif
               @endfor
            </tr>
         </table>

         @if($p % 2==0 && $p<>0)
            <div style="page-break-after: always"></div>
         @else
            <br>
         @endif         
      @endfor      
   @endif 

   <table class="myFont" style="width: 99%;">      
      <tr>
         <td colspan="4" class="tcenterb">ตำแหน่งการ Stamp ถุงและกล่อง  </td>
      </tr>
      <tr>
         <td class="tcenterb">รูปแบบการรัดสาย</td>
         <td class="tcenterb">การเรียงสินค้าในกล่อง</td>
         <td class="tcenterb">การเรียงสินค้าในพาเลท</td>
         <td class="tcenterb">Art Work ถุง, กล่อง</td>
      </tr>
      <tr>            
         <td class="tcenterb">
            @if (isset($packpaper->cable_img))
               <img src="{{ url($packpaper->cable_img) }}"  height='200px'/>
            @else 
               <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
            @endif
         </td>
         <td class="tcenterb">
            @if (isset($packpaper->inbox_img))
               <img src="{{ url($packpaper->inbox_img) }}"  height='200px'/>
            @else 
               <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
            @endif
         </td>
         <td class="tcenterb">
            @if (isset($packpaper->pallet_img))
               <img src="{{ url($packpaper->pallet_img) }}"  height='200px'/>
            @else 
               <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
            @endif
         </td>
         <td class="tcenterb">
            @if (isset($packpaper->artwork_img))
               <img src="{{ url($packpaper->artwork_img) }}"  height='200px'/>
            @else 
               <img src="{{ url('/images/noimg.png') }}"  height='200px'/>
            @endif
         </td>
      </tr>
   </table> 

   <table class="myFont" style="width: 40%;" align="left">      
      <tr>
         <th style="width: 2%"></th>
         <td colspan="3" style="text-align: left">จัดเรียงบนพาเลท</td>
      </tr>
      <tr>
         <th style="width: 2%"></th>
         <td class="tcenterb" style="width: 32.66%; height:2cm">ฐานจัดเรียง {{ $packpaper->pallet_base }} กล่อง</td>
         <td class="tcenterb" style="width: 32.66%">จัดเรียง {{ $packpaper->pallet_low }} รวม {{ $packpaper->pallet_base*$packpaper->pallet_low }} กล่อง</td>          
         <td class="tcenterb" style="width: 32.66%">จัดเรียง {{ $packpaper->pallet_height }} รวม {{ $packpaper->pallet_base*$packpaper->pallet_height }} กล่อง</td>
      </tr>     
   </table>
   <div style="clear: both"></div>
   <div class="row">
      <div class="col-md-1">
          <h5>หมายเหตุ : </h5>
      </div>
   </div>
   <br>

   <br>

@endsection