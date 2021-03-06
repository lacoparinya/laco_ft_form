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
                <th>คัดผลิตภัณฑ์</th>
                <th>Input/kg.</th>
                <th>Output/kg.</th>
                <th>inputสะสม</th>
                <th>คัดได้สะสม</th>
                <th>STD Productivity</th>
                <th>Productivity</th>
                <th>% yield</th>
                <th>PK</th>
                <th>PF</th>
                <th>PST</th>
                <th>จำนวนคน</th>
                <th>เปิดไลน์ฝั่ง A</th>
                <th>เปิดไลน์ฝั่ง B</th>
                <th>เปิดไลน์คัด</th>
                <th>REF SAP</th>
                <th>เกรดถั่วแระ</th>
                <th>สถานการณ์คัด</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                    <tr>
                        <td>{{ $item->process_date }}</td>
                        <td>{{ $item->timeslot->name }}</td>
                        <td>{{ $item->shift->name }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->input_kg }}</td>
                        <td>{{ $item->output_kg }}</td>
                        <td>{{ $item->sum_in_kg }}</td>
                        <td>{{ $item->sum_kg }}</td>
                        <td>{{ $item->stdprocess->std_rate }}</td>
                        <td>{{ round(($item->output_kg/$item->num_classify)/$item->timeslot->gap,2)  }}</td>
                        <td>{{ $item->yeild_percent }}</td>
                        <td>{{ $item->num_pk }}</td>
                        <td>{{ $item->num_pf }}</td>
                        <td>{{ $item->num_pst }}</td>
                        <td>{{ $item->num_classify }}</td>
                        <td>{{ $item->line_a }}</td>
                        <td>{{ $item->line_b }}</td>
                        <td>{{ $item->line_classify }} 
                        @if ($item->classifyunit->name == 'table')
                            {{ "Table" }}
                        @endif
                        </td>
                        <td>{{ $item->ref_note }}</td>
                        <td>{{ $item->grade }}</td>
                        <td>{{ $item->note }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>