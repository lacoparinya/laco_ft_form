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
                <th>วันที่</th>
                <th>เวลา</th>
                <th>กะ</th>
                <th>เครื่อง Stamp</th>
                <th>บรรจุภัณฑ์</th>
                <th>Order No.</th>
                <th>วันที่ใช้บรรจุ</th>
                <th>Loading</th>
                <th>Target/Hr</th>
                <th>Actual (EA)</th>
                <th>Actual สะสม (EA)</th>
                <th>จำนวนพนักงานที่ใช้</th>
                <th>หมายเหตุ</th>
                <th>ปัญหา</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            @php
            $totalHour = 0;
            $totalMH = 0;
            $numberItem = $item->stampd()->orderBy('process_datetime')->count();
            $loopItem = 0;
            @endphp
                @foreach($item->stampd()->orderBy('process_datetime')->get() as $itemd)
                @php
                    $totalHour += $itemd->workhours;
                    $totalMH += ($itemd->workhours)*($itemd->num_iqf + $itemd->num_pre);
                    $loopItem++;
                @endphp    
                    <tr>
                        <td>{{ $item->process_date }}</td>
                        <td>{{ date('Y-m-d H:i',strtotime($itemd->process_datetime)) }}</td>
                        <td>{{ $item->shift->name }}</td>
                        <td>{{ $item->stampmachine->name }}</td>
                        <td>{{ $item->matpack->packname }}</td>
                        <td>{{ $item->order_no }}</td>
                        <td>{{ $item->pack_date }}</td>
                        <td>{{ $item->loading_date }}</td>
                        <td>{{ $item->rateperhr }}</td>
                        <td>{{ $itemd->output }}</td>
                        <td>{{ $itemd->outputSum }}</td>
                        <td>{{ $item->staff_actual }}</td>
                        <td>{{ $itemd->note }}</td>
                        <td>{{ $itemd->problem }}</td>
                    </tr>

                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>