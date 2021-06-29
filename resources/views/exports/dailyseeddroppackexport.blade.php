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
                @foreach ($methodlist as $item)
                    <th colspan="7">{{ $item }}</th>
                @endforeach
                <th colspan="7">รวม AutoPack</th>
                <th rowspan="2">หมายเหตุ</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                @foreach ($methodlist as $item)
                    <th>บริเวณลากกระบะ (KG.)</th>
                    <th>สายพานจุดปล่อยถั่ว (KG.)</th>
                    <th>สายพาน Intralox/โครง Z (KG.)</th>
                    <th>หัวชั่ง</th>
                    <th>Shaker</th>
                    <th>ในเครื่องบรรจุ (KG.)</th>
                    <th>โต๊ะบรรจุ</th>
                @endforeach
                <th>บริเวณลากกระบะ (KG.)</th>
                <th>สายพานจุดปล่อยถั่ว (KG.)</th>
                <th>สายพาน Intralox/โครง Z (KG.)</th>
                <th>หัวชั่ง</th>
                <th>Shaker</th>
                <th>ในเครื่องบรรจุ (KG.)</th>
                <th>โต๊ะบรรจุ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $chackdate => $itemmain)
                @foreach ($itemmain as $shiftid => $item)
                    <tr>
                        <td>{{ $chackdate }}</td>
                        <td>{{ $shiftlist[$shiftid] }}</td>
                        @php
                            $sumdata = [];
                            $notesum = '';
                        @endphp
                        @foreach ($methodlist as $methodid => $methodname)

                            @if (isset($item[$methodid]))

                                @php
                                    if (isset($item[$methodid]->note)) {
                                        $notesum .= $item[$methodid]->note . ' , ';
                                    }
                                @endphp
                                <td>
                                    @if (isset($item[$methodid]->cabin))
                                        {{ number_format($item[$methodid]->cabin, 2, '.', ',') }}
                                        @php
                                            if (isset($sumdata['cabin'])) {
                                                $sumdata['cabin'] += $item[$methodid]->cabin;
                                            } else {
                                                $sumdata['cabin'] = $item[$methodid]->cabin;
                                            }
                                        @endphp
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if (isset($item[$methodid]->belt_start))
                                        {{ number_format($item[$methodid]->belt_start, 2, '.', ',') }}
                                        @php
                                            if (isset($sumdata['belt_start'])) {
                                                $sumdata['belt_start'] += $item[$methodid]->belt_start;
                                            } else {
                                                $sumdata['belt_start'] = $item[$methodid]->belt_start;
                                            }
                                        @endphp
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if (isset($item[$methodid]->belt_Intralox))
                                        {{ number_format($item[$methodid]->belt_Intralox, 2, '.', ',') }}
                                        @php
                                            if (isset($sumdata['belt_Intralox'])) {
                                                $sumdata['belt_Intralox'] += $item[$methodid]->belt_Intralox;
                                            } else {
                                                $sumdata['belt_Intralox'] = $item[$methodid]->belt_Intralox;
                                            }
                                        @endphp
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if (isset($item[$methodid]->weight_head))
                                        {{ number_format($item[$methodid]->weight_head, 2, '.', ',') }}
                                        @php
                                            if (isset($sumdata['weight_head'])) {
                                                $sumdata['weight_head'] += $item[$methodid]->weight_head;
                                            } else {
                                                $sumdata['weight_head'] = $item[$methodid]->weight_head;
                                            }
                                        @endphp
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if (isset($item[$methodid]->shaker))
                                        {{ number_format($item[$methodid]->shaker, 2, '.', ',') }}
                                        @php
                                            if (isset($sumdata['shaker'])) {
                                                $sumdata['shaker'] += $item[$methodid]->shaker;
                                            } else {
                                                $sumdata['shaker'] = $item[$methodid]->shaker;
                                            }
                                        @endphp
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if (isset($item[$methodid]->pack_part))
                                        {{ number_format($item[$methodid]->pack_part, 2, '.', ',') }}
                                        @php
                                            if (isset($sumdata['pack_part'])) {
                                                $sumdata['pack_part'] += $item[$methodid]->pack_part;
                                            } else {
                                                $sumdata['pack_part'] = $item[$methodid]->pack_part;
                                            }
                                        @endphp
                                    @else
                                        0
                                    @endif
                                </td>
                                <td>
                                    @if (isset($item[$methodid]->table))
                                        {{ number_format($item[$methodid]->table, 2, '.', ',') }}
                                        @php
                                            if (isset($sumdata['table'])) {
                                                $sumdata['table'] += $item[$methodid]->table;
                                            } else {
                                                $sumdata['table'] = $item[$methodid]->table;
                                            }
                                        @endphp
                                    @else
                                        0
                                    @endif
                                </td>
                            @else
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            @endif
                        @endforeach
                        <td>
                            @if (isset($sumdata['cabin']))
                                {{ number_format($sumdata['cabin'], 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if (isset($sumdata['belt_start']))
                                {{ number_format($sumdata['belt_start'], 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if (isset($sumdata['belt_Intralox']))
                                {{ number_format($sumdata['belt_Intralox'], 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if (isset($sumdata['weight_head']))
                                {{ number_format($sumdata['weight_head'], 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if (isset($sumdata['shaker']))
                                {{ number_format($sumdata['shaker'], 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if (isset($sumdata['pack_part']))
                                {{ number_format($sumdata['pack_part'], 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if (isset($sumdata['table']))
                                {{ number_format($sumdata['table'], 2, '.', ',') }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            {{ $notesum }}
                        </td>
                    </tr>
                @endforeach
            @endforeach

        </tbody>
    </table>
</body>

</html>
