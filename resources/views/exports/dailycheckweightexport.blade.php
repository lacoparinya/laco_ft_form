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
                                        <th>Mechine</th>
                                        <th>Process Date</th>
                                        <th>ลูกค้า</th>
                                        <th>สินค้า</th>
                                        <th>น้ำหนักมาตรฐาน</th>
                                        <th>น้ำหนักที่อ่าน</th>
                                        <th>สถานะน้ำหนัก</th>
                                        <th>เลขข้างกล่อง 1 มาตรฐาน</th>
                                        <th>เลขข้างกล่อง 1 อ่านได้</th>
                                        <th>สถานะเลขข้างกล่อง 1</th>
                                        <th>เลขข้างกล่อง 2 มาตรฐาน</th>
                                        <th>เลขข้างกล่อง 2 อ่านได้</th>
                                        <th>สถานะเลขข้างกล่อง 2</th>
                                        <th>สถานะรวม</th>
                                    </tr>
                                </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                <td>{{ $item->mchckweight->name }}</td>
                <td>{{ $item->datetime }}</td>
                <td>{{ $item->cus_name }}</td>
                <td>{{ $item->prod_name }}</td>
                <td>{{ $item->weight_st }}</td>
                <td>{{ $item->weight_read }}</td>
                <td>{{ $item->weight_check }}</td>
                <td>{{ $item->code1_st }}</td>
                <td>{{ $item->code1_read }}</td>
                <td>{{ $item->code1_check }}</td>
                <td>{{ $item->code2_st }}</td>
                <td>{{ $item->code2_read }}</td>
                <td>{{ $item->code2_check }}</td>
                <td>{{ $item->overall_status }}</td>
                </tr>                                   
            @endforeach
        </tbody>
    </table>
</body>
</html>