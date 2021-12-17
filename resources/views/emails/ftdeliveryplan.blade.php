@php
    $monthlist = array(
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec'
        );
@endphp
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
    <p><strong>{{ $dataset['subject'] }}</strong></p>
    <p>บรรจุได้ {{ $dataset['data']['current'][1] }} Shipment  สำหรับ  order   ส่งมอบเดือน {{ $monthlist[$dataset['data']['rawcurrent']->month] }} {{ $dataset['data']['rawcurrent']->year }}</p>
    <p>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>ยืนยัน Order</th>
                <th>ไม่ยืนยัน Order</th>
                <th>รวม</th>
            </tr>
            <tr>
                <th>{{ $monthlist[$dataset['data']['rawprev']->month] }} {{ $dataset['data']['rawprev']->year }}</th>
                <th>{{ $dataset['data']['all']['prev']['num_confirm'] }}</th>
                <th>{{ $dataset['data']['prev'][0] - $dataset['data']['all']['prev']['num_confirm'] }}</th>
                <th>{{ $dataset['data']['prev'][0]}}</th>
            </tr>
            <tr>
                <th>{{ $monthlist[$dataset['data']['rawcurrent']->month] }} {{ $dataset['data']['rawcurrent']->year }}</th>
                <th>{{ $dataset['data']['all']['current']['num_confirm'] }}</th>
                <th>{{ $dataset['data']['current'][0] - $dataset['data']['all']['current']['num_confirm'] }}</th>
                <th>{{ $dataset['data']['current'][0]}}</th>
            </tr>
        </thead>
    </table>
    </p>
    <p><img src="{{ url('/') }}/ft_form/{{ $dataset['graph']['region']['link'] }}" alt=""></p><br/>
    <p><img src="{{ url('/') }}/ft_form/{{ $dataset['graph']['all']['link'] }}" alt=""></p><br/>
    <p>หมายเหตุ : {{$dataset['data']['rawcurrent']->note}}</p>
    <p>จึงเรียนมาเพื่อทราบ</p>
    <p>FT Form Alert</p>
</body>
</html>