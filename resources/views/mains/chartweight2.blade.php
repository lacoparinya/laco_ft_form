@extends('layouts.appweightchart')

@section('content')
<div class="container">
        <div class="row">
            @foreach ($data2 as $key=>$item)
            <div class="col-md-12">
                <canvas id="my_Chart{{$key}}" height=22vh" width="90vw"></canvas>
            </div>    
            @endforeach
            
        </div>
</div>
<script>
@foreach ($data2 as $key=>$item)
var myData{{$key}} = {
        labels: [
        @foreach ($item as $key3=>$item3)
        '{{substr($key3,0,16)}}',
        @endforeach
        ],
        datasets: [
            @php
                $chekdata = 1;
            @endphp
            @foreach ($data[$key] as $key11=>$item11)
            {
            label: '{{$key11}}',
            data: [
                @foreach ($item as $key3=>$item3)
                    @if(isset($item3[$key11]))
                        {{$item3[$key11]}},
                    @else
                        0,
                    @endif
                @endforeach],
            fill: false,
            borderColor: 'rgb({{$chekdata*($key)*25}}, {{255 - ($chekdata*($key)*25)}},{{($chekdata*50) - ($key*25)}})',
            tension: 0.1
            },
            @php
                $chekdata++;
            @endphp
            @endforeach
    ]
    };
var myoption = {
            title: {
                display: true,
                text: '{{$mlist[$key]}}'
            },
    responsive: true,  
};

var ctx = document.getElementById('my_Chart{{$key}}').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'line',    	// Define chart type
				data: myData{{$key}},    	// Chart data
				options: myoption 	// Chart Options [This is optional paramenter use to add some extra things in the chart].
			});
@endforeach
setTimeout(function(){
       location.reload();
   },300000);
</script>
@endsection