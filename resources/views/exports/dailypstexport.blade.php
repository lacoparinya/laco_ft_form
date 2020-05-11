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
                <th>ประเภท</th>
                <th>ผลิตภัณฑ์</th>
                <th>เวลา</th>
                <th>Target</th>
                <th>Input</th>
                <th>Output</th>
                <th>สะสม</th>
                <th>จำนวนคน</th>
                <th>หมายเหตุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $itemm)
            @foreach($itemm->logpstselectd()->orderBy('process_datetime')->get() as $item)
                    <tr>
                        <td>{{ $itemm->process_date }}</td>
                        <td>{{ $itemm->shift->name }}</td>
                        <td>{{ $itemm->psttype->name or ''}}</td>
                        <td>{{ $itemm->pstproduct->name }}</td>
                        <td>{{ date('H:i',strtotime($item->process_datetime)) }}</td>
                        <td>{{ $itemm->stdselectpst->std_rate_per_h_m }}</td>
                        <td>{{ $item->input_kg }}</td>
                        <td>{{ $item->output_kg }}</td>
                        <td>{{ $item->sum_kg }}</td>
                        <td>{{ $item->num_classify }}</td>
                        <td>{{ $item->note }}</td>
                    </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>