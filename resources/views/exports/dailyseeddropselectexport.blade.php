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
                <th rowspan="2">วันที่</th>
                <th rowspan="2">กะ</th>
                <th rowspan="2">ประเภท</th>
                <th colspan="2">RM</th>
                <th colspan="2">Incline</th>
                <th colspan="2">สายพานรับถั่วจากRecheck</th>
                <th colspan="2">สายพานลำเลียงถั่วเข้า Auto weight</th>
                <th colspan="2">ใต้สายพานไลน์คัด (ของตกเกรด)</th>
                <th colspan="2">รวม</th>
                <th rowspan="2">% ตกพื้นเทียบ input</th>
                <th rowspan="2">หมายเหตุ</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>Input (Kg)</th>
                <th>Output (Kg)</th>
                <th>Machine</th>
                <th>Man</th>
                <th>Machine</th>
                <th>Man</th>
                <th>Machine</th>
                <th>Man</th>
                <th>Machine</th>
                <th>Man</th>
                <th>Machine</th>
                <th>Man</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->check_date }}</td>
                    <td>{{ $shiftlist[$item->shift_id] }}</td>
                    <td>{{ $item->material }}</td>
                    <td>{{ number_format($item->input_w, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->output_w, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->incline_a, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->incline_m, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->beltrecheck_a, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->beltrecheck_m, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->beltautoweight_a, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->beltautoweight_m, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->underbelt_a, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->underbelt_m, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->total_a, 2, '.', ',') }}</td>
                    <td>{{ number_format($item->total_m, 2, '.', ',') }}</td>
                    <td>{{ number_format(($item->total_a * 100) / $item->input_w, 2, '.', ',') . '%' }}</td>
                    <td>{{ $item->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
