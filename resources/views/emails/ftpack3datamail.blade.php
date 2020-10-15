<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FT Form Alert</title>
    <style>
        table {
            border: solid 2px black;
        }
        thead tr th{
            border: solid 1px black;
            font-weight: bold;
            font-style: italic;
        }
        tbody tr td{
            border: solid 1px black;
        }
    </style>
</head>
<body>
    <p><strong>TO..ALL</strong></p>
    <p><strong>FT Form Alert System</strong></p>
    @if (!empty($packdataobj['datapl']))
        <p>
            <table>
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>เครื่อง</th>
                        <th>กะ</th>
                        <th>เป้าพนักงาน</th>
                        <th>ผู้ดูแล</th>
                        <th>พนักงาน PK</th>
                        <th>ผู้ช่วยงานจาก PF</th>
                        <th>ผู้ช่วยงานจาก PST</th>
                        <th>ผลต่างจำนวนคน</th>
                        <th>สินค้า</th>
                        <th>Plan</th>
                        <th>Actual</th>
                        <th>Diff</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                     @foreach ($packdataobj['datapl'] as $item)
                    <tr>
                        <td>{{  $item->process_date }}</td>
                        <td>{{  $item->methodname }}</td>
                        <td>{{  $item->shiftname }}</td>
                        <td>{{  $item->staff_target }}</td>
                        <td>{{  $item->staff_operate }}</td>
                        <td>{{  $item->staff_pk }}</td>
                        <td>{{  $item->staff_pf }}</td>
                        <td>{{  $item->staff_pst }}</td>
                        <td>{{  $item->staff_diff }}</td>
                        <td>{{  $item->packagename }}</td>
                        <td>{{  $item->Plan }}</td>
                        <td>{{  $item->Actual }}</td>
                        <td>{{  $item->diff }}</td>
                        <td>{{  $item->Remark }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </p>
    @endif
            
  
            @foreach($packdataobj['graph'] as $key1 => $item2)
            @foreach($item2 as $key2 => $item1)
            @foreach($item1 as $key3 => $item)
            <p>
                        <img src="{{ url('/') }}/ft_form/{{ $item }}" alt="">
                        <h3>{!! $packdataobj['result'][$key1][$key2][$key3]['txt'] !!}</h3>
                        <h3>ปัญหาที่พบ : 
                        @if (!empty($packdataobj['result'][$key1][$key2][$key3]['problem']))                            
                           @foreach ($packdataobj['result'][$key1][$key2][$key3]['problem'] as $problem)
                               {{ $problem }} <br/> 
                           @endforeach 
                        @else
                            ไม่พบปัญหา
                        @endif
                        </h3>
                       @if (!empty($packdataobj['result'][$key1][$key2][$key3]['problem_img']))                            
                           @foreach ($packdataobj['result'][$key1][$key2][$key3]['problem_img'] as $problemimg)
                               <a href="{{ url('/') }}/ft_form/{{ $problemimg }}" target="_blank">{{ HTML::image('/ft_form/'.$problemimg, 'alt', array( 'height' => 200 )) }}</a>                                
                            @endforeach 
                        @endif
 <br/></p>
 @endforeach
            @endforeach
            @endforeach
    
</body>
</html>