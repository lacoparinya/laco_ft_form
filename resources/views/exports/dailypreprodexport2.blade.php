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
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                @foreach($item->logprepared()->orderBy('process_datetime')->get() as $itemd)
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
                        <td>{{ $itemd->note }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>