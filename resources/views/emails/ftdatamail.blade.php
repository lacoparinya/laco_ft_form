<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FT Form Alert</title>
    <style>
        table {
            border: solid 2px black;
        }
        thead tr th{
            border: solid 1px black;
            font-weight: bold;
            font-style: italic;
        }
        tbody tr td{
            border: solid 1px black;
        }
    </style>
</head>
<body>
    <p><strong>TO..ALL</strong></p>
    <p><strong>FT Form Alert System</strong></p>
    <p>
        <table >
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
            @foreach($ftdataobj['data'] as $item)
                    <tr>
                        <td>{{ $item->process_date }}</td>
                        <td>{{ $item->timeslot->name }}</td>
                        <td>{{ $item->shift->name }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->input_kg }}</td>
                        <td>{{ $item->output_kg }}</td>
                        <td>{{ $item->sum_in_kg }}</td>
                        <td>{{ $item->sum_kg }}</td>
                        <td>{{ round($item->stdprocess->std_rate,2) }}</td>
                        <td>{{ round(($item->output_kg/$item->num_classify)/$item->timeslot->gap,2)  }}</td>
                        <td>{{ round($item->yeild_percent,2) }}</td>
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
    </p>
</body>
</html>