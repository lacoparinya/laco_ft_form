<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stamp</title>
    <style>
    tr th {
        border: 1px solid #000000;
        word-wrap: normal;
    }
    tr th.noborder {
        border: none;
        word-wrap: normal;
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
    }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                                        <th rowspan="3">Process Date</th>
                                        <th rowspan="3">Mechine</th>                                        
                                        <th rowspan="3">ลูกค้า</th>
                                        <th rowspan="3">สินค้า</th>
                                        <th colspan="9">Check weight</th>
                                        <th colspan="9">กล้อง 1</th>
                                        <th colspan="9">กล้อง 2</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th rowspan="2">All</th>
                                        <th colspan="2">OK</th>
                                        <th colspan="2">Over</th>
                                        <th colspan="2">Under</th>
                                        <th colspan="2">BYPASS</th>
                                        <th rowspan="2">All</th>
                                        <th colspan="2">OK</th>
                                        <th colspan="2">NG</th>
                                        <th colspan="2">NC</th>
                                        <th colspan="2">BYPASS</th>
                                        <th rowspan="2">All</th>
                                        <th colspan="2">OK</th>
                                        <th colspan="2">NG</th>
                                        <th colspan="2">NC</th>
                                        <th colspan="2">BYPASS</th>
                                        
                                        
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>จำนวน</th>
                                        <th>%</th>                                        
                                        <th>จำนวน</th>
                                        <th>%</th>   
                                        <th>จำนวน</th>
                                        <th>%</th>   
                                        <th>จำนวน</th>
                                        <th>%</th> 
                                        
                                        <th></th>
                                        <th>จำนวน</th>
                                        <th>%</th>                                        
                                        <th>จำนวน</th>
                                        <th>%</th>   
                                        <th>จำนวน</th>
                                        <th>%</th>   
                                        <th>จำนวน</th>
                                        <th>%</th> 
                                        
                                        <th></th>
                                        <th>จำนวน</th>
                                        <th>%</th>                                        
                                        <th>จำนวน</th>
                                        <th>%</th>   
                                        <th>จำนวน</th>
                                        <th>%</th>   
                                        <th>จำนวน</th>
                                        <th>%</th>   
                                    </tr>
                                </thead>
        <tbody>
            @foreach($datawegihtsum as $day=>$item1)
                @foreach ($item1 as  $mechine=>$item2)
                    @foreach ($item2 as $cus=>$item3)
                        @foreach ($item3 as $prod=>$item)
                            <tr>
                            <td>{{ $day }}</td>
                            <td>{{ $mechine }}</td>
                            <td>{{ $cus }}</td>
                            <td>{{ $prod }}</td>
                            <td>{{ $item['WEIGHT']['SUM'] }}</td>
                            <td>
                                @if (isset($item['WEIGHT']['OK']))
                                    {{ $item['WEIGHT']['OK'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['WEIGHT']['OK']))
                                    {{ round($item['WEIGHT']['OK']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['WEIGHT']['OVER']))
                                    {{ $item['WEIGHT']['OVER'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['WEIGHT']['OVER']))
                                    {{ round($item['WEIGHT']['OVER']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['WEIGHT']['UNDER']))
                                    {{ $item['WEIGHT']['UNDER'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['WEIGHT']['UNDER']))
                                    {{ round($item['WEIGHT']['UNDER']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['WEIGHT']['BYPASS']))
                                    {{ $item['WEIGHT']['BYPASS'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['WEIGHT']['BYPASS']))
                                    {{ round($item['WEIGHT']['BYPASS']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>{{ $item['WEIGHT']['SUM'] }}</td>
                            <td>
                                @if (isset($item['LABEL1']['OK']))
                                    {{ $item['LABEL1']['OK'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL1']['OK']))
                                    {{ round($item['LABEL1']['OK']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL1']['NG']))
                                    {{ $item['LABEL1']['NG'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL1']['NG']))
                                    {{ round($item['LABEL1']['NG']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL1']['NC']))
                                    {{ $item['LABEL1']['NC'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL1']['NC']))
                                    {{ round($item['LABEL1']['NC']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL1']['BYPASS']))
                                    {{ $item['LABEL1']['BYPASS'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL1']['BYPASS']))
                                    {{ round($item['LABEL1']['BYPASS']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>{{ $item['WEIGHT']['SUM'] }}</td>
                            <td>
                                @if (isset($item['LABEL2']['OK']))
                                    {{ $item['LABEL2']['OK'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL2']['OK']))
                                    {{ round($item['LABEL2']['OK']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL2']['NG']))
                                    {{ $item['LABEL2']['NG'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL2']['NG']))
                                    {{ round($item['LABEL2']['NG']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL2']['NC']))
                                    {{ $item['LABEL2']['NC'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL2']['NC']))
                                    {{ round($item['LABEL2']['NC']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL2']['BYPASS']))
                                    {{ $item['LABEL2']['BYPASS'] }}
                                @else
                                    0
                                @endif
                            </td>
                            <td>
                                @if (isset($item['LABEL2']['BYPASS']))
                                    {{ round($item['LABEL2']['BYPASS']*100/$item['WEIGHT']['SUM'],2) }}
                                @else
                                    0
                                @endif
                            </td>
                            </tr>  
                        @endforeach
                    @endforeach
                @endforeach
                                                 
            @endforeach
        </tbody>
    </table>
</body>
</html>