<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
                <th>วันที่</th>
                <th>กะ</th>
                <th>ผลิตภัณฑ์</th>
                <th>เวลา</th>
                <th>Target</th>
                <th>Input</th>
                <th>Output</th>
                <th>สะสม</th>
                <th>สะสม</th>
                <th>จำนวนเตรียมการ</th>
                <th>จำนวน IQF/F</th>
                <th>จำนวนคนรวม</th>
                <th>จำนวนชั่วโมง</th>
                <th>MH รวม</th>
                <th>RATE เฉลี่ย/กะ</th>
                <th>Produtivity</th>
                <th>หมายเหตุ</th>
                <th>ปัญหา</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            @php
            $totalHour = 0;
            $totalMH = 0;
            $numberItem = $item->logprepared()->orderBy('process_datetime')->count();
            $loopItem = 0;
            @endphp
                @foreach($item->logprepared()->orderBy('process_datetime')->get() as $itemd)
                @php
                    $totalHour += $itemd->workhours;
                    $totalMH += ($itemd->workhours)*($itemd->num_iqf + $itemd->num_pre);
                    $loopItem++;
                @endphp    
                    <tr>
                        <td>{{ $item->process_date }}</td>
                        <td>{{ $itemd->shift->name }}</td>
                        <td>{{ $itemd->preprod->name }}</td>
                        <td>{{ date('H:i',strtotime($itemd->process_datetime)) }}</td>
                        <td>{{ $itemd->targets }}</td>
                        <td>{{ $itemd->input }}</td>
                        <td>{{ $itemd->output }}</td>
                        <td>{{ $itemd->input_sum }}</td>
                        <td>{{ $itemd->output_sum }}</td>
                        <td>{{ $itemd->num_pre }}</td>
                        <td>{{ $itemd->num_iqf }}</td>
                        <td>{{ $itemd->num_iqf + $itemd->num_pre }}</td>
                        <td>{{ $itemd->workhours }}</td>
                        <td>{{ ($itemd->workhours)*($itemd->num_iqf + $itemd->num_pre) }}</td>
                        @if ($numberItem ==  $loopItem)
                            @if ($itemd->output_sum > 0)
                                <td>{{ round($itemd->output_sum/$totalHour,2) }}</td>
                                <td>{{ round($itemd->output_sum/$totalMH,2) }}</td>
                            @else
                                <td>{{ round($itemd->input_sum/$totalHour,2) }}</td>
                                <td>{{ round($itemd->input_sum/$totalMH,2) }}</td>
                            @endif
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        
                        <td>{{ $itemd->note }}</td>
                        <td>{{ $itemd->problem }}</td>
                    </tr>

                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>