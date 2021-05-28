@extends('layouts.appweightchart')

@section('content')
<div class="container">
        <div class="row">
            @foreach ($data as $key=>$item)
            @foreach ($item as $key2=>$item2)
            <div class="col-md-12">
                <canvas id="my_Chart{{$key}}{{ str_replace("-","",str_replace("#","",$key2)) }}" height=20vh" width="90vw"></canvas>
            </div>    
            @endforeach
            @endforeach
            
        </div>
</div>
<script>
@foreach ($data as $key=>$item)
@foreach ($item as $key2=>$item2)
var myData{{$key}}{{ str_replace("-","",str_replace("#","",$key2)) }} = {
        labels: [
        @foreach ($item2 as $key3=>$item3)
        '{{substr($key3,0,16)}}',
        @endforeach
        ],
        datasets: [{
            label: '{{$mlist[$key]}} - {{$key2}}',
            data: [@foreach ($item2 as $key3=>$item3)
            {{$item3}},
            @endforeach],
            borderWidth: 1
        }]
    };
var myoption = {
    responsive: true,  
};

var ctx = document.getElementById('my_Chart{{$key}}{{ str_replace("-","",str_replace("#","",$key2)) }}').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',    	// Define chart type
				data: myData{{$key}}{{ str_replace("-","",str_replace("#","",$key2)) }},    	// Chart data
				options: myoption 	// Chart Options [This is optional paramenter use to add some extra things in the chart].
			});

@endforeach
@endforeach

setTimeout(function(){
       location.reload();
   },300000);
</script>


@endsection