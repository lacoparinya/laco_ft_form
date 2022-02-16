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
        $count_pack = $packpaper->packpaperpackages()->count();
        $count_col = 9 + $count_pack;
        $i=0; $p=0;
   @endphp
   
   <table style="width: 99%" class="myFont">
      <tr>
         <th style="text-align: left;width: 5%">LACO</th>
         <th style="width: 20%"></th>         
         <th style="text-align:right;width: 75%">ประกาศใช้วันที่ :01/04/64</th>     
      </tr>
      <tr>
         <th colspan="3" style="text-align:center">ใบแจ้งการบรรจุผลิตภัณฑ์แช่แข็งสำเร็จรูป</th>
      </tr>
      <tr>
         <th style="text-align: left" colspan="2">รหัสเอกสาร:F-PL-PK-001/1</th>
         <th style="text-align:right">การประกาศใช้ครั้งที่ : 03</th>
      </tr>
      <tr>
         <th style="text-align: left">วันที่</th>
         <th style="text-align: left">{{ date('d') }}/{{ date('m') }}/{{ substr((date('Y')+543), 2, 2) }}</th>
         <th></th>
      </tr>
   </table>

   <br>

   @if($count_pack>2)
      <table class="myFont" style="width: 99%">
         <tr>
            <th style="width: 5%"></th>
            <th rowspan="2" class="tcenterb" style="width: 14.5%">ผลิตภัณฑ์</th>
            <th rowspan="2" class="tcenterb" style="width: 3.5%">ลูกค้า</th>
            <th rowspan="2" class="tcenterb" style="width: 5.5%">วันที่บรรจุ</th>
            <th class="tcenterbnb" style="width: 9%">ORDER </th>
            <th class="tcenterb" colspan="{{ $packpaper->packpaperpackages()->count() }}">ชนิดของถุงและกล่อง</th>
         </tr>
         <tr>
            <th></th>
            <th class="tcenterbnt">NUMBER</th> 
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <th class="tcenterb" style="width: {{ 62.5/$count_pack }}%">{{ $packageObj->packaging->packagetype->name }}</th>
            @endforeach    
         </tr>
         <tr>
            <td class="tleft">std.</td>
            <td class="tcenterb">{{ $packpaper->packaging->product->name }}</td>
            <td class="tcenterb">{{ $packpaper->packaging->product->customer->name }}</td>
            <td class="tcenterb">ว/ด/ป</td>
            <td class="tcenterb">ตามใบแจ้งโหลด</td>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">{{ $packageObj->packaging->name }}</td>
            @endforeach            
         </tr>
         <tr>
            <td>&nbsp;</td>
            @for($i=0;$i<($count_col-5);$i++)
               <td class="tcenterb" style="background-color: #DCDCDC"></td>
            @endfor
         </tr>
         @foreach ($packpaper->packpaperds()->get() as $packpaperd)
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->product->name }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->product->customer->name }}</td>
               <td class="tcenterb">{{ date("d", strtotime($packpaperd->pack_date)) }}/{{ date("m", strtotime($packpaperd->pack_date)) }}/{{ substr((date("Y", strtotime($packpaperd->pack_date))+543),2,2) }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->order_no }}</td>
               @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                  <td class="tcenterb" rowspan="2">{{ $packageObj->packaging->name }}</td>
               @endforeach            
            </tr>
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb">{{ date("d", strtotime($packpaperd->exp_date)) }}/{{ date("m", strtotime($packpaperd->exp_date)) }}/{{ substr((date("Y", strtotime($packpaperd->exp_date))+543),2,2) }}</td>              
            </tr>
         @endforeach
      </table>
      <br>
      <table class="myFont" style="width: 99%">
         <tr>
            <th style="width: 5%"></th>
            <th rowspan="2" class="tcenterb" style="width: 14.5%">ผลิตภัณฑ์</th>
            <th rowspan="2" class="tcenterb" style="width: 3.5%">ลูกค้า</th>
            <th rowspan="2" class="tcenterb" style="width: 5.5%">วันที่บรรจุ</th>
            <th class="tcenterbnb" style="width: 9%">ORDER </th>
            <th class="tcenterb" colspan="3">ขนาดบรรจุ</th>
            <th class="tcenterb" rowspan="2">สีสายรัด</th>
         </tr>
         <tr>
            <th></th>
            <th class="tcenterbnt">NUMBER</th>    
            <th class="tcenterb">น้ำหนัก / ถุง</th>
            <th class="tcenterb">จำนวนถุง / กล่อง</th>
            <th class="tcenterb">น้ำหนัก / กล่อง</th>
         </tr>
         <tr>
            <td class="tleft">std.</td>
            <td class="tcenterb">{{ $packpaper->packaging->product->name }}</td>
            <td class="tcenterb">{{ $packpaper->packaging->product->customer->name }}</td>
            <td class="tcenterb">ว/ด/ป</td>
            <td class="tcenterb">ตามใบแจ้งโหลด</td>        
            <td class="tcenterb">{{ number_format($packpaper->packaging->inner_weight_g, 2, '.', ',') }} กรัม</td>
            <td class="tcenterb">{{ $packpaper->packaging->number_per_pack }} แพ็ค</td>
            <td class="tcenterb">{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
            <td class="tcenterb">ไม่มีการรัดสาย</td>
         </tr>
         <tr>
            <th></th>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <th class="tcenterb">น้ำหนักชั่งรวมถุง</th>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
         </tr>
         @foreach ($packpaper->packpaperds()->get() as $packpaperd)
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->product->name }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->product->customer->name }}</td>
               <td class="tcenterb">{{ date("d", strtotime($packpaperd->pack_date)) }}/{{ date("m", strtotime($packpaperd->pack_date)) }}/{{ substr((date("Y", strtotime($packpaperd->pack_date))+543),2,2) }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->order_no }}</td>           
               <td class="tcenterb" rowspan="2">{{ $packpaper->weight_with_bag  }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->number_per_pack }} แพ็ค</td>
               <td class="tcenterb" rowspan="2">{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
               <td class="tcenterb" rowspan="2">{{ $packpaperd->cablecover  }}</td>
            </tr>
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb">{{ date("d", strtotime($packpaperd->exp_date)) }}/{{ date("m", strtotime($packpaperd->exp_date)) }}/{{ substr((date("Y", strtotime($packpaperd->exp_date))+543),2,2) }}</td>              
            </tr>
         @endforeach
      </table>
   @else
      <table class="myFont" style="width: 99%">
         <tr>
            <th style="width: 5%"></th>
            <th rowspan="2" class="tcenterb" style="width: 14.5%">ผลิตภัณฑ์</th>
            <th rowspan="2" class="tcenterb" style="width: 3.5%">ลูกค้า</th>
            <th rowspan="2" class="tcenterb" style="width: 5.5%">วันที่บรรจุ</th>
            <th class="tcenterbnb" style="width: 9%">ORDER </th>
            <th class="tcenterb" colspan="{{ $packpaper->packpaperpackages()->count() }}">ชนิดของถุงและกล่อง</th>
            <th class="tcenterb" colspan="3">ขนาดบรรจุ</th>
            <th class="tcenterb" rowspan="2">สีสายรัด</th>
         </tr>
         <tr>
            <th></th>
            <th class="tcenterbnt">NUMBER</th> 
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <th class="tcenterb">{{ $packageObj->packaging->packagetype->name }}</th>
            @endforeach    
            <th class="tcenterb">น้ำหนัก / ถุง</th>
            <th class="tcenterb">จำนวนถุง / กล่อง</th>
            <th class="tcenterb">น้ำหนัก / กล่อง</th>
         </tr>
         <tr>
            <td class="tleft">std.</td>
            <td class="tcenterb">{{ $packpaper->packaging->product->name }}</td>
            <td class="tcenterb">{{ $packpaper->packaging->product->customer->name }}</td>
            <td class="tcenterb">ว/ด/ป</td>
            <td class="tcenterb">ตามใบแจ้งโหลด</td>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">{{ $packageObj->packaging->name }}</td>
            @endforeach            
            <td class="tcenterb">{{ number_format($packpaper->packaging->inner_weight_g, 2, '.', ',') }} กรัม</td>
            <td class="tcenterb">{{ $packpaper->packaging->number_per_pack }} แพ็ค</td>
            <td class="tcenterb">{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
            <td class="tcenterb">ไม่มีการรัดสาย</td>
         </tr>
         <tr>
            <td></td>
            @for($i=0;$i<($count_col-5);$i++)
               <td class="tcenterb" style="background-color: #DCDCDC"></td>
            @endfor
            <td class="tcenterb">น้ำหนักชั่งรวมถุง</td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
            <td class="tcenterb" style="background-color: #DCDCDC"></td>
         </tr>
         @foreach ($packpaper->packpaperds()->get() as $packpaperd)
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->product->name }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->product->customer->name }}</td>
               <td class="tcenterb">{{ date("d", strtotime($packpaperd->pack_date)) }}/{{ date("m", strtotime($packpaperd->pack_date)) }}/{{ substr((date("Y", strtotime($packpaperd->pack_date))+543),2,2) }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->order_no }}</td>
               @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                  <td class="tcenterb" rowspan="2">{{ $packageObj->packaging->name }}</td>
               @endforeach            
               <td class="tcenterb" rowspan="2">{{ $packpaper->weight_with_bag  }}</td>
               <td class="tcenterb" rowspan="2">{{ $packpaper->packaging->number_per_pack }} แพ็ค</td>
               <td class="tcenterb" rowspan="2">{{ number_format($packpaper->packaging->outer_weight_kg, 3, '.', ',') }} กก.</td>
               <td class="tcenterb" rowspan="2">{{ $packpaperd->cablecover  }}</td>
            </tr>
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb">{{ date("d", strtotime($packpaperd->exp_date)) }}/{{ date("m", strtotime($packpaperd->exp_date)) }}/{{ substr((date("Y", strtotime($packpaperd->exp_date))+543),2,2) }}</td>              
            </tr>
         @endforeach
      </table>
   @endif

   <br>

   @if($count_pack>2)
      @php
         $arr_pack = array();
         foreach($packpaper->packpaperpackages()->get() as $packageObj){
            $arr_pack[] = $packageObj;
         }
         // for($i=0;$i<$count_pack;$i){
         //    echo $arr_pack[$i]."</br></br>";
         // }
      @endphp
      @for($p=0;$p<($count_pack-1);$p++)
         <table class="myFont" style="width: 99%">
            <tr>
               <td style="width: 5%"></td>
               <th colspan="2" class="tcenterb">ปริมาณ</th>
               <th class="tcenterbnb" style="width: 9%">ระยะเวลาที่หมด</th>
               <th rowspan="2" class="tcenterb" style="width: 7.5%">วันที่หมดอายุ</th>
               @for($i=0; $i<2;$i++)  
                  @php
                     if($i==0 && $p<>0) $p++;   
                  @endphp          
                  <th class="tcenterb" rowspan="2" style="width: 12%">วันที่ผลิต บน {{ $arr_pack[($i+$p)]->packaging->packagetype->name }}</th>
                  <th class="tcenterb" rowspan="2" style="width: 14%">วันที่หมดอายุ บน {{ $arr_pack[($i+$p)]->packaging->packagetype->name }}</th>
                  <th class="tcenterb" rowspan="2" style="width: 9%">Lot บน {{ $arr_pack[($i+$p)]->packaging->packagetype->name }}</th>
               @endfor 
            </tr>
            <tr>
               <td></td>
               <th class="tcenterb" style="width: 5%">กก.</th>
               <th class="tcenterb" style="width: 3.5%">กล่อง</th>
               <th class="tcenterbnt">อายุ (เดือน)</th>            
            </tr>
            <tr>
               <td class="tleft">std.</td>
               <td class="tcenterb">-</td>
               <td class="tcenterb">-</td>
               <td class="tcenterb">{{ $packpaper->exp_month }}</td>
               <td class="tcenterb">ว/ด/ป</td>
               @for($i=0; $i<2;$i++) 
                  <td class="tcenterb">
                     @if (empty($arr_pack[($i+$p)]->pack_date_format))
                        ไม่ระบุ
                     @else
                        {{ $arr_pack[($i+$p)]->pack_date_format }}
                     @endif
                  </td>
                  <td class="tcenterb">
                     @if (empty($arr_pack[($i+$p)]->exp_date_format))
                        ไม่ระบุ
                     @else
                        {{ $arr_pack[($i+$p)]->exp_date_format }}
                     @endif
                  </td>
                  <td class="tcenterb">
                     @if (empty($arr_pack[($i+$p)]->lot))
                        ไม่ระบุ
                     @else
                        {{ $arr_pack[($i+$p)]->lot }}
                     @endif
                  </td>
               @endfor
            </tr>
            @foreach ($packpaper->packpaperds()->get() as $packpaperd)
               <tr>
                  <td class="tleft"></td>
                  <td class="tcenterb">{{ number_format($packpaperd->all_weight,2) }}</td>
                  <td class="tcenterb">{{ $packpaperd->all_bpack }}</td>
                  <td class="tcenterb">{{ $packpaper->exp_month  }}</td>
                  <td class="tcenterb">{{ date("d", strtotime($packpaperd->exp_date)) }}/{{ date("m", strtotime($packpaperd->exp_date)) }}/{{ substr((date("Y", strtotime($packpaperd->exp_date))+543),2,2) }}</td>
                  @for($i=0; $i<2;$i++)
                     <td class="tcenterb">
                        @if (empty($arr_pack[($i+$p)]->pack_date_format))
                           ไม่ระบุ
                        @else
                           @php
                              $phpformat =  str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$arr_pack[($i+$p)]->pack_date_format))));
                           @endphp
                           {{ date($phpformat,strtotime($packpaperd->exp_month)) }}
                        @endif
                     </td>
                     <td class="tcenterb">
                        @if (empty($arr_pack[($i+$p)]->exp_date_format))
                           ไม่ระบุ
                        @else
                           @php
                              $phpformat =  str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$arr_pack[($i+$p)]->exp_date_format))));
                              $lotSymbol = strpos($arr_pack[($i+$p)]->exp_date_format,"LOT");
                              $noSymbol = strpos($arr_pack[($i+$p)]->exp_date_format,"No");
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
                     <td class="tcenterb">
                        @if (empty($arr_pack[($i+$p)]->lot))
                           ไม่ระบุ
                        @else
                           {{ $arr_pack[($i+$p)]->lot }}
                        @endif
                     </td>
                  @endfor
               </tr>    
            @endforeach
         </table>
         <br>
      @endfor
   @else
      <table class="myFont" style="width: 99%">
         <tr>
            <td style="width: 5%"></td>
            <th colspan="2" class="tcenterb">ปริมาณ</th>
            <th class="tcenterbnb" style="width: 9%">ระยะเวลาที่หมด</th>
            <th rowspan="2" class="tcenterb" style="width: 7.5%">วันที่หมดอายุ</th>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <th class="tcenterb" rowspan="2" style="width: 12%">วันที่ผลิต บน {{ $packageObj->packaging->packagetype->name }}</th>
               <th class="tcenterb" rowspan="2" style="width: 14%">วันที่หมดอายุ บน {{ $packageObj->packaging->packagetype->name }}</th>
               <th class="tcenterb" rowspan="2" style="width: 9%">Lot บน {{ $packageObj->packaging->packagetype->name }}</th>
            @endforeach  
         </tr>
         <tr>
            <td></td>
            <th class="tcenterb" style="width: 5%">กก.</th>
            <th class="tcenterb" style="width: 3.5%">กล่อง</th>
            <th class="tcenterbnt">อายุ (เดือน)</th>            
         </tr>
         <tr>
            <td class="tleft">std.</td>
            <td class="tcenterb">-</td>
            <td class="tcenterb">-</td>
            <td class="tcenterb">{{ $packpaper->exp_month }}</td>
            <td class="tcenterb">ว/ด/ป</td>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)                                             
               <td class="tcenterb">
                  @if (empty($packageObj->pack_date_format))
                     ไม่ระบุ
                  @else
                     {{ $packageObj->pack_date_format }}
                  @endif
               </td>
               <td class="tcenterb">
                  @if (empty($packageObj->exp_date_format))
                     ไม่ระบุ
                  @else
                     {{ $packageObj->exp_date_format }}
                  @endif
               </td>
               <td class="tcenterb">
                  @if (empty($packageObj->lot))
                     ไม่ระบุ
                  @else
                     {{ $packageObj->lot }}
                  @endif
               </td>
            @endforeach
         </tr>
         @foreach ($packpaper->packpaperds()->get() as $packpaperd)
            <tr>
               <td class="tleft"></td>
               <td class="tcenterb">{{ number_format($packpaperd->all_weight,2) }}</td>
               <td class="tcenterb">{{ $packpaperd->all_bpack }}</td>
               <td class="tcenterb">{{ $packpaper->exp_month  }}</td>
               <td class="tcenterb">{{ date("d", strtotime($packpaperd->exp_date)) }}/{{ date("m", strtotime($packpaperd->exp_date)) }}/{{ substr((date("Y", strtotime($packpaperd->exp_date))+543),2,2) }}</td>
               @foreach ($packpaper->packpaperpackages()->get() as $packageObj)                                             
                  <td class="tcenterb">
                     @if (empty($packageObj->pack_date_format))
                        ไม่ระบุ
                     @else
                        @php
                           $phpformat =  str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$packageObj->pack_date_format))));
                           // $lotSymbol = strpos($packageObj->exp_date_format,"LOT");
                           // $noSymbol = strpos($packageObj->exp_date_format,"No");
                        @endphp
                        {{ date($phpformat,strtotime($packpaperd->exp_month)) }}
                     @endif
                  </td>
                  <td class="tcenterb">
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
                  <td class="tcenterb">
                     @if (empty($packageObj->lot))
                        ไม่ระบุ
                     @else
                        {{ $packageObj->lot }}
                     @endif
                  </td>
               @endforeach
            </tr>    
         @endforeach
      </table>
      <br>
   @endif

   <div style="page-break-after: always"></div>

   @if($count_pack>3)
      <table class="myFont" style="width: 99%">
         <thead>
            <tr>
               @php
                     $allcols = 1 + (2 * $packpaper->packpaperpackages()->count() );
               @endphp
               <th  colspan="{{ $allcols }}" class="tcenterb">การ STAMP ถุง และกล่อง </th>
            </tr>
            <tr>
               @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                  <th colspan="2" class="tcenterb">การ STAMP {{ $packageObj->packaging->packagetype->name }}สำเร็จรูป</th>
               @endforeach
               <th rowspan="2" class="tcenterb">Lot</th>
            </tr>
            <tr>
               @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
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
               <tr>                  
                  @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                     @php
                        $phpformatc =  str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$packageObj->pack_date_format))));
                        // $lotSymbolc = strpos($packageObj->pack_date_format,"LOT");
                        // $noSymbolc = strpos($packageObj->pack_date_format,"No");
                        $phpformate =  str_replace('No.','' ,str_replace('LOT','' ,str_replace('DD','d' ,str_replace('MM','m' ,str_replace('YYYY','Y' ,$packageObj->exp_date_format)))));
                        // $lotSymbole = strpos($packageObj->exp_date_format,"LOT");
                        // $noSymbole = strpos($packageObj->exp_date_format,"No");

                        $sumqty += $item->nbox;
                        $sumkg += $item->fweight;
                     @endphp
                     <td class="tcenterb">
                        @if (empty($packageObj->pack_date_format))
                           ไม่ระบุ
                        @else
                           {{ date($phpformatc,strtotime($item->pack_date)) }}
                        @endif
                     </td>
                     <td class="tcenterb">
                        @if (empty($packageObj->exp_date_format))
                           ไม่ระบุ
                        @else
                           {{ date($phpformate,strtotime($item->exp_date)) }}
                        @endif
                     </td>
                  @endforeach
                  <td class="tcenterb">{{ $item->lot }}</td>
               </tr>    
            @endforeach
            
         </tbody>
      </table>
      <br>
      <table class="myFont" style="width: 99%">
         <thead>
            <tr>
               @php
                     $allcols = 8;
               @endphp
               <th  colspan="{{ $allcols }}" class="tcenterb">การ STAMP ถุง และกล่อง </th>
            </tr>
            <tr>
               <th rowspan="2" class="tcenterb">Lot</th>
               <th rowspan="2" class="tcenterb">NO.</th>
               <th rowspan="2" class="tcenterb">จำนวนกล่อง</th>	
               <th rowspan="2" class="tcenterb">จำนวนถุง</th>	
               <th rowspan="2" class="tcenterb">น้ำหนักผลิตภัณฑ์/P</th>
               <th rowspan="2" class="tcenterb">น้ำหนักผลิตภัณฑ์/F</th>	
               <th rowspan="2" class="tcenterb">จำนวนพาเลท</th>	
               <th rowspan="2" class="tcenterb">จำนวนกล่องพาเลทสุดท้าย</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($packpaper->packpaperdlots()->get() as $item)
               <tr>       
                  <td class="tcenterb">{{ $item->lot }}</td>
                  <td class="tcenterb">{{ number_format($item->frombox,0,'.',',') }} - {{ number_format($item->tobox,0,'.',',') }}</td>
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
   @else
      <table class="myFont" style="width: 99%">
         <thead>
            <tr>
               @php
                     $allcols = 8 + (2 * $packpaper->packpaperpackages()->count() );
               @endphp
               <th  colspan="{{ $allcols }}" class="tcenterb">การ STAMP ถุง และกล่อง </th>
            </tr>
            <tr>
                  @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
                        <th colspan="2" class="tcenterb">การ STAMP {{ $packageObj->packaging->packagetype->name }}สำเร็จรูป</th>
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
                  @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
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
                  <td class="tcenterb">
                     @if (empty($packageObj->pack_date_format))
                        ไม่ระบุ
                     @else
                        {{ date($phpformatc,strtotime($item->pack_date)) }}
                     @endif
                  </td>
                  <td class="tcenterb">
                     @if (empty($packageObj->exp_date_format))
                        ไม่ระบุ
                     @else
                        {{ date($phpformate,strtotime($item->exp_date)) }}
                     @endif</td>
                  @endforeach
                  <td class="tcenterb">{{ $item->lot }}</td>
                  <td class="tcenterb">{{ number_format($item->frombox,0,'.',',') }} - {{ number_format($item->tobox,0,'.',',') }}</td>
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
   @endif

   <div class="row">
      <div class="col-md-1">
          <h5>หมายเหตุ : </h5>
      </div>
  </div>

   <br>

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

   <table class="myFont" style="width: 99%;">      
      <tr>
         <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
         <td style="width: 2%"></td>
         <td style="width: 48">จัดทำโดย…………….……………………………...หัวหน้าแผนกขึ้นไป</td>   
         <td style="width: 2%"></td>     
         <td style="width: 48">ตรวจสอบโดย….….....……………….……………. ผู้ช่วยผู้จัดการแผนกคัดและบรรจุ/แผนกผลิตแช่แข็งขึ้นไป</td>
      </tr>
      <tr>
         <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
         <td></td>
         <td>ตรวจทานโดย……..…..………….………………… ผู้ช่วยผู้จัดการแผนกวางแผนการผลิตขึ้นไป</td>
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
         <td>อนุมัติโดย……….………………..…………….......ผู้ช่วยผู้จัดการจัดการฝ่ายโรงงานขึ้นไป</td>
      </tr>
   </table>

   <br>

   <div style="page-break-after: always"></div>

   @if($count_pack>3)
      <table class="myFont" style="width: 99%;">      
         <tr>
            <td colspan="{{ ($count_pack*2) }}" class="tcenterb">ตำแหน่งการ Stamp ถุงและกล่อง  </td>
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb" colspan="2">{{ $packageObj->packaging->packagetype->name }}</td>
            @endforeach
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)         
               <td class="tcenterb">ด้านหน้า</td>
               <td class="tcenterb">ด้านหลัง</td>         
            @endforeach
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">
                  @if (isset($packageObj->front_img))
                     <img src="{{ url($packageObj->front_img) }}"  height='100px'/></td>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                  @endif
               </td>
               <td class="tcenterb">
                  @if (isset($packageObj->back_img))
                     <img src="{{ url($packageObj->back_img) }}"  height='100px'/>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                  @endif
               </td>
            @endforeach
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">FORMAT การStamp : 
                  @if (isset($packageObj->front_stamp))
                     {{ $packageObj->front_stamp }}
                  @endif
               </td>
               <td class="tcenterb">FORMAT การStamp : 
                  @if (isset($packageObj->back_stamp))
                  {{ $packageObj->back_stamp }}
                  @endif
               </td>
            @endforeach
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">ตำแหน่งการStamp : 
                  @if (isset($packageObj->front_locstamp))
                     {{ $packageObj->front_locstamp }}
                  @endif
               </td>
               <td class="tcenterb">ตำแหน่งการStamp : 
                  @if (isset($packageObj->back_locstamp))
                     {{ $packageObj->back_locstamp }}
                  @endif
               </td>
            @endforeach
         </tr>
      </table> 
      <br>
      <table class="myFont" style="width: 40%;">      
         <tr>
            <td colspan="3" class="tcenterb">ตำแหน่งการ Stamp ถุงและกล่อง  </td>
         </tr>
         <tr>
            <td class="tcenterb">รูปแบบการรัดสาย</td>
            <td class="tcenterb">การเรียงสินค้าในกล่อง</td>
            <td class="tcenterb">การเรียงสินค้าในพาเลท</td>
         </tr>
         <tr>            
            <td class="tcenterb">
               @if (isset($packpaper->cable_img))
                  <img src="{{ url($packpaper->cable_img) }}"  height='100px'/>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
               @endif
            </td>
            <td class="tcenterb">
               @if (isset($packpaper->inbox_img))
                  <img src="{{ url($packpaper->inbox_img) }}"  height='100px'/>
               @else 
                  <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
               @endif
            </td>
            <td class="tcenterb">
               @if (isset($packpaper->pallet_img))
                  <img src="{{ url($packpaper->pallet_img) }}"  height='100px'/>
               @else 
                  <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
               @endif
            </td>
         </tr>
      </table>
   @else
      <table class="myFont" style="width: 99%;">      
         <tr>
            <td colspan="{{ ($count_pack*2)+3 }}" class="tcenterb">ตำแหน่งการ Stamp ถุงและกล่อง  </td>
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb" colspan="2">{{ $packageObj->packaging->packagetype->name }}</td>
            @endforeach
            <td rowspan="2" class="tcenterb">รูปแบบการรัดสาย</td>
            <td rowspan="2" class="tcenterb">การเรียงสินค้าในกล่อง</td>
            <td rowspan="2" class="tcenterb">การเรียงสินค้าในพาเลท</td>
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)         
               <td class="tcenterb">ด้านหน้า</td>
               <td class="tcenterb">ด้านหลัง</td>         
            @endforeach
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">
                  @if (isset($packageObj->front_img))
                     <img src="{{ url($packageObj->front_img) }}"  height='100px'/></td>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                  @endif
               </td>
               <td class="tcenterb">
                  @if (isset($packageObj->back_img))
                     <img src="{{ url($packageObj->back_img) }}"  height='100px'/>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
                  @endif
               </td>
            @endforeach
            <td class="tcenterb">
               @if (isset($packpaper->cable_img))
                  <img src="{{ url($packpaper->cable_img) }}"  height='100px'/>
                  @else 
                     <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
               @endif
            </td>
            <td class="tcenterb">
               @if (isset($packpaper->inbox_img))
                  <img src="{{ url($packpaper->inbox_img) }}"  height='100px'/>
               @else 
                  <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
               @endif
            </td>
            <td class="tcenterb">
               @if (isset($packpaper->pallet_img))
                  <img src="{{ url($packpaper->pallet_img) }}"  height='100px'/>
               @else 
                  <img src="{{ url('/images/noimg.png') }}"  height='100px'/>
               @endif
            </td>
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">FORMAT การStamp : 
                  @if (isset($packageObj->front_stamp))
                     {{ $packageObj->front_stamp }}
                  @endif
               </td>
               <td class="tcenterb">FORMAT การStamp : 
                  @if (isset($packageObj->back_stamp))
                  {{ $packageObj->back_stamp }}
                  @endif
               </td>
            @endforeach
         </tr>
         <tr>
            @foreach ($packpaper->packpaperpackages()->get() as $packageObj)
               <td class="tcenterb">ตำแหน่งการStamp : 
                  @if (isset($packageObj->front_locstamp))
                     {{ $packageObj->front_locstamp }}
                  @endif
               </td>
               <td class="tcenterb">ตำแหน่งการStamp : 
                  @if (isset($packageObj->back_locstamp))
                     {{ $packageObj->back_locstamp }}
                  @endif
               </td>
            @endforeach
         </tr>
      </table>  
   @endif 
   <div class="row">
      <div class="col-md-1">
          <h5>หมายเหตุ : </h5>
      </div>
   </div>
   <br>
   <br>

@endsection