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

    tr td.diffred {
        border: 1px solid #000000;
        word-wrap: normal;
        background-color:#ff0000;
        color:#ffffff;
    }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>กะ</th>
                <th>เครื่อง</th>
                <th>เป้าพนักงาน</th>
                <th>Staff</th>
                <th>พนง.PF</th>
                <th>พนง.PK</th>
                <th>พนง.PST</th>
                <th>พนง.Diff</th>
                <th>งาน/Product</th>
                <th>Plan</th>
                <th>Actual</th>
                <th>Diff</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $date=>$dataMainObj)
                    <tr>
                    <td colspan="13">{{ $date }}</td>
                    </tr>
                    @if (isset($dataMainObj['freeze']))
                    <tr>
                    <td colspan="13">Freeze</td>
                    </tr>
                        @foreach ($dataMainObj['freeze'] as $item)

                            <tr>
                        <td>{{  $item->shiftname }}</td>
                        <td></td>
                        <td>{{  $item->staff_target }}</td>
                        <td>{{  $item->staff_operate }}</td>
                        <td>{{  $item->staff_pf }}</td>
                        <td>{{  $item->staff_pk }}</td>
                        <td>{{  $item->staff_pst }}</td>
                        @if ($item->staff_diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->staff_diff }}</td>
                        <td>{{  $item->productname }}</td>
                        <td>{{  $item->Plan }}</td>
                        <td>{{  $item->Actual }}</td>
                        @if ($item->diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                            {{  $item->diff }}</td>
                        <td>{{  $item->Remark }}</td>
                            </tr>
                        @endforeach
                    @endif
                    
                    @if (isset($dataMainObj['prepare']))
                    <tr>
                    <td colspan="13">Prepare</td>
                    </tr>
                        @foreach ($dataMainObj['prepare'] as $item)
                            <tr>
                        <td>{{  $item->shiftname }}</td>
                        <td></td>
                        <td>{{  $item->staff_target }}</td>
                        <td>{{  $item->staff_operate }}</td>
                        <td>{{  $item->staff_pf }}</td>
                        <td>{{  $item->staff_pk }}</td>
                        <td>{{  $item->staff_pst }}</td>
                        @if ($item->staff_diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->staff_diff }}</td>
                        <td>{{  $item->productname }}</td>
                        <td>{{  $item->Plan }}</td>
                        <td>{{  $item->Actual }}</td>
                        @if ($item->diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->diff }}</td>
                        <td>{{  $item->Remark }}</td>
                    </tr>
                        @endforeach
                    @endif

                    @if (isset($dataMainObj['select']))
                    <tr>
                    <td colspan="13">Select</td>
                    </tr>
                        @foreach ($dataMainObj['select'] as $item)
                            <tr>
                        
                        <td>{{  $item->shiiftname }}</td>
                        <td></td>
                        <td>{{  $item->staff_target }}</td>
                        <td>{{  $item->staff_operate }}</td>
                        <td>{{  $item->staff_pf }}</td>
                        <td>{{  $item->staff_pk }}</td>
                        <td>{{  $item->staff_pst }}</td>
                        @if ($item->staff_diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->staff_diff }}</td>
                        <td>{{  $item->productname }}</td>
                        <td>{{  $item->Plan }}</td>
                        <td>{{  $item->Actual }}</td>
                        @if ($item->diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->diff }}</td>
                        <td>{{  $item->Remark }}</td>
                    </tr>
                        @endforeach
                    @endif

                    @if (isset($dataMainObj['pack']))
                    <tr>
                    <td colspan="13">Pack</td>
                    </tr>
                        @foreach ($dataMainObj['pack'] as $item)
                           <tr>
                      <td>{{  $item->shiftname }}</td>
                        <td>{{  $item->methodname }}</td>
                        
                        <td>{{  $item->staff_target }}</td>
                        <td>{{  $item->staff_operate }}</td>
                        <td>{{  $item->staff_pf }}</td>
                        <td>{{  $item->staff_pk }}</td>
                        <td>{{  $item->staff_pst }}</td>
                        @if ($item->staff_diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->staff_diff }}</td>
                        <td>{{  $item->packagename }}</td>
                        <td>{{  $item->Plan }}</td>
                        <td>{{  $item->Actual }}</td>
                        @if ($item->diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->diff }}</td>
                        <td>{{  $item->Remark }}</td>
                    </tr>
                        @endforeach
                    @endif

                    @if (isset($dataMainObj['stamp']))
                    <tr>
                    <td colspan="13">Stamp</td>
                    </tr>
                        @foreach ($dataMainObj['stamp'] as $item)
                           <tr>
                        <td>{{  $item->shiftname }}</td>
                        <td>{{  $item->stampmachinename }}</td>
                        
                        <td>{{  $item->staff_target }}</td>
                        <td>{{  $item->staff_operate }}</td>
                        <td colspan="3">{{  $item->staff_actual }}</td>
                        @if ($item->staff_diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->staff_diff }}</td>
                        <td>{{  $item->matname }} / {{  $item->packname or '' }}</td>
                        <td>{{  $item->targetperjob }}</td>
                        <td>{{  $item->Actual }}</td>
                        @if ($item->diff >= 0)
                            <td>
                        @else
                            <td class="diffred" >
                        @endif
                        {{  $item->diff }}</td>
                        <td>{{  $item->Remark }}</td>
                    </tr>
                        @endforeach
                    @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>