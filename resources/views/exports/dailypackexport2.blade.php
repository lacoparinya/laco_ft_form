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
                <th>กะ</th>
                <th>วิธี</th>
                <th>บรรจุผลิตภัณฑ์</th>
                <th>Order No.</th>
                <th>Loading</th>
                <th>Output (กล่อง หรือ EA)</th>
                <th>Output สะสม (กล่อง หรือ EA)</th>
                <th>Input</th>
                <th>Output/Kg</th>
                <th>บรรจุได้สะสม</th>
                <th>STD Productivity</th>
                <th>Productivity</th>
                <th>% yield</th>
                <th>จำนวนคน</th>
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $subdata)
            @foreach($subdata->logpackd()->orderBy('process_datetime')->get() as $item)
                    <tr>
                        <td>{{ $subdata->process_date }}</td>
                        <td>{{ $item->process_datetime or '' }}</td>
                        <td>{{ $item->shift->name or ''}}</td>
                        <td>{{ $subdata->method->name or ''}}</td>
                        <td>{{ $subdata->package->name or '' }}</td>
                        <td>{{ $subdata->order->order_no or ''}}</td>
                        <td>{{ $subdata->order->loading_date }}</td>
                        <td>{{ $item->output_pack }}</td>
                        <td>{{ $item->output_pack_sum }}</td>
                        <td>{{ $item->input_kg }}</td>
                        <td>{{ $item->output_kg  }}</td>
                        <td>{{ $item->output_kg_sum }}</td>
                        <td>{{ $item->stdpack->std_rate or 0 }}</td>
                        <td>{{ $item->productivity }}</td>
                        <td>{{ $item->yeild_percent }}</td>
                        <td>{{ $item->num_pack }}</td>
                        <td>{{ $item->note }}</td>
                    </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>