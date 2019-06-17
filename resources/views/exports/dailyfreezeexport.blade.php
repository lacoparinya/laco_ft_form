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
                <th>เวลา</th>
                <th>Target</th>
                <th>บรรจุผลิตภัณฑ์</th>
                @php
                    $str = "";
                    $lp = 0;
                @endphp
                @foreach ($iqfmapcollist as $key=>$item)
                @php
                    if($lp == 0){
                        $str .= $item;
                    }else{
                        $str .= " , ".$item;
                    }
                    $lp++;
                @endphp

                <th>{{ $item }}</th>

                @endforeach
                <th>รวม {{ $str }}</th>
                <th>ปริมาณ RM คงเหลือ</th>
                <th>ฟรีสสะสม</th>
                <th>ปริมาณ RM รับเข้า</th>
                <th>รีฟรีส (kg.)</th>
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                    <tr>
                        <td>{{ $item->process_date }}</td>
                        <td>{{ $item->process_time }}</td>
                        <td>{{ $item->target }}</td>
                        <td>{{ $item->iqfjob->name }}</td>
                        @foreach ($iqfmapcollist as $key2=>$item2)
                        <td>{{ $item->$key2 }}</td>
                        @endforeach
                        <td>{{ $item->output_sum }}</td>
                        <td>{{ $item->current_RM }}</td>
                        <td>{{ $item->output_all_sum }}</td>
                        <td>{{ $item->recv_RM }}</td>
                        <td></td>
                        <td></td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>