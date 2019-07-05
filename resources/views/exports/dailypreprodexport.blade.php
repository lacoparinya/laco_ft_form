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
                <th>ผลิตภัณฑ์</th>
                <th>กะ</th>
                <th>Target</th>
                <th>Input</th>
                <th>Output</th>
                <th>สะสม</th>
                <th>จำนวนเตรียมการ</th>
                <th>จำนวน IQF/F</th>
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                    <tr>
                        <td>{{ $item->process_date }}</td>
                        <td>{{ date('H:i',strtotime($item->process_time)) }}</td>
                        <td>{{ $item->preprod->name }}</td>
                        <td>{{ $item->shift->name }}</td>
                        <td>{{ $item->targets }}</td>
                        <td>{{ $item->input }}</td>
                        <td>{{ $item->output }}</td>
                        <td>{{ $item->output_sum }}</td>
                        <td>{{ $item->num_pre }}</td>
                        <td>{{ $item->num_iqf }}</td>
                        <td>{{ $item->note }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>