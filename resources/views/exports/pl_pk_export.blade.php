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
                <th>กะ</th>
                <th>ประเภทงาน</th>
                <th>เป้าพนักงาน</th>
                <th>Staff</th>
                <th>พนง.PK</th>
                <th>พนง.PF ช่วยงาน</th>
                <th>พนง.PST ช่วยงาน</th>
                <th>พนง.Diff</th>
                <th>งาน/Product</th>
                <th>Plan</th>
                <th>Actual</th>
                <th>Diff</th>
                <th>Shipment</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $date=>$dataMainObj)
                    <tr>
                    <td colspan="14">{{ $date }}</td>
                    </tr>
                    @if (isset($dataMainObj['Select']))
                        @foreach ($dataMainObj['Select'] as $dataObj)
                            <tr>
                                <td>{{ $dataObj->shiiftname }}</td>
                                <td>{{ $dataObj->methodname }}</td>
                                <td>{{ $dataObj->staff_target }}</td>
                                <td>{{ $dataObj->staff_operate }}</td>
                                <td>{{ $dataObj->staff_pk }}</td>
                                <td>{{ $dataObj->staff_pf }}</td>
                                <td>{{ $dataObj->staff_pst }}</td>
                                <td>{{ $dataObj->staff_diff }}</td>
                                <td>{{ $dataObj->packagename }}</td>
                                <td>{{ $dataObj->Plan }}</td>
                                <td>{{ $dataObj->Actual }}</td>
                                <td>{{ $dataObj->diff }}</td>
                                <td>{{ $dataObj->Shipment }}</td>
                                <td>{{ $dataObj->Remark }}</td>
                            </tr>
                        @endforeach
                    @endif
                    
                    @if (isset($dataMainObj['Pack']))
                        @foreach ($dataMainObj['Pack'] as $dataObj)
                            <tr>
                                <td>{{ $dataObj->shiiftname }}</td>
                                <td>{{ $dataObj->methodname }}</td>
                                <td>{{ $dataObj->staff_target }}</td>
                                <td>{{ $dataObj->staff_operate }}</td>
                                <td>{{ $dataObj->staff_pk }}</td>
                                <td>{{ $dataObj->staff_pf }}</td>
                                <td>{{ $dataObj->staff_pst }}</td>
                                <td>{{ $dataObj->staff_diff }}</td>
                                <td>{{ $dataObj->packagename }}</td>
                                <td>{{ $dataObj->Plan }}</td>
                                <td>{{ $dataObj->Actual }}</td>
                                <td>{{ $dataObj->diff }}</td>
                                <td>{{ $dataObj->Shipment }}</td>
                                <td>{{ $dataObj->Remark }}</td>
                            </tr>
                        @endforeach
                    @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>