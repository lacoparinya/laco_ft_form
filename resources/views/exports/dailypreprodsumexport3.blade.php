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
                <th>งาน</th>
                <th>จำนวนชั่วโมงรวม</th>
                <th>MH รวม</th>
                <th>RATE เฉลี่ย/กะ</th>
                <th>Produtivity </th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataSum as $item)
                <tr>
                    <td>{{ $item->process_date }}</td>
                    <td>{{ $item->shiftname }}</td>
                    <td>{{ $item->preprodname }}</td>
                    <td>{{ $item->sumworkhours }}</td>
                    <td>{{ $item->sumMH }}</td>
                    <td>{{ round($item->resultsum/$item->sumworkhours,2) }}</td>
                    <td>{{ round($item->resultsum/$item->sumMH,2) }}</td>                     
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>