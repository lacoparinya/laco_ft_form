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
    tr th.noborderl {
        border: none;
        text-align: left;
        word-wrap: break-word;
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
                <th colspan="2" class='noborderl'>LACO.</th>
                <th class='noborderr'>Issue Date: 12/05/16</th>
            </tr>
            <tr>
                <th colspan="3" class='noborderc'>Confirmation of Packing and Stamping of the Package</th>
            </tr>
            <tr>
                <th colspan="3" class='noborderc'>การยืนยันรูปแบบการบรรจุ และการพิมพ์บรรจุภัณฑ์</th>
            </tr>
            <tr>
                <th colspan="2" class='noborderl'>Document No. : F-QP-07/1</th>
                <th class='noborderr'>Issue No.: 01</th>
            </tr>
            <tr>
                <th>No.</th>
                <th>Topic</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Product Code SAP /โค้ดผลิตภัณฑ์ </td>
                <td>{{ $packaging->product->name }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Customer/ลูกค้า</td>
                <td>{{ $packaging->product->customer->desc }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Customer Code/ลูกค้า</td>
                <td>{{ $packaging->product->customer->name }}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Shelf Life/อายุการจัดเก็บ </td>
                <td></td>
            </tr>
            @php
                $counter = 4;
            @endphp
            @foreach ($packaging->package()->get() as $subitem)                            
            <tr>
                <td>{{ $counter+1 }}</td>
                <td>Code SAP Package ({{$subitem->packagetype->name}})</td>
                <td>{{ $subitem->name }}</td>
            </tr>
            <tr>
                <td>{{ $counter+2 }}</td>
                <td>Package Material & Description/วัสดุ และรายละเอียด</td>
                <td>{{ $subitem->desc }}</td>
            </tr>
            <tr>
                <td>{{ $counter+3 }}</td>
                <td>Package Size/ขนาด</td>
                <td>{{ $subitem->size }}</td>
            </tr>
            <tr>
                <td>{{ $counter+4 }}</td>
                <td>Format of EXP.date or MFG.date / รูปแบบการพิมพ์วันผลิตหรือวันหมดอายุ</td>
                <td>-</td>
            </tr>
            @php
                $counter = $counter + 4;
            @endphp
            @endforeach
            <tr>
                <td>{{ $counter+1 }}</td>
                <td>Weight/Package/น้ำหนักบรรจุต่อบรรจุภัณฑ์ย่อย (กรัม)</td>
                <td>{{ round($packaging->inner_weight_g,3) }}</td>
            </tr>
            <tr>
                <td>{{ $counter+2 }}</td>
                <td>Packing/Package/จำนวนบรรจุต่อบรรจุภัณฑ์</td>
                <td>{{ $packaging->number_per_pack }}</td>
            </tr>
            <tr>
                <td>{{ $counter+3 }}</td>
                <td>Weight/Package/น้ำหนักบรรจุต่อบรรจุภัณฑ์ใหญ่ (กิโลกรัม)</td>
                <td>{{ round($packaging->outer_weight_kg,3) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>