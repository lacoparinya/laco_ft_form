@extends('layouts.appweightchart')

@section('content')
<div class="container">
        <div class="row">
            @foreach ($data as $key=>$item)
            <div class="col-md-12">
                <canvas id="my_Chart{{$key}}" height=22vh" width="90vw"></canvas>
            </div>    
            @endforeach
            
        </div>
</div>
<script>
@foreach ($data as $key=>$item)
var myData{{$key}} = {
        labels: [
            @foreach ($item as $key1=>$item1)
        '{{$key1}}',
        @endforeach
        ],
        datasets: [
            {
            label: 'OK',
            data: [
                @foreach ($item as $key1=>$item1)
                    @if(isset($item1['OK']))
                        {{$item1['OK']}}
                    @else
                        0
                    @endif,
                    @endforeach
               ],
            fill: false,

            backgroundColor: [
                @foreach ($item as $key1=>$item1)
              'rgba(255, 0, 0, 0.9)',
               @endforeach
            ],
             borderColor: [
                 @foreach ($item as $key1=>$item1)
              'rgb(255, 0, 0)',
              @endforeach
            ],
            tension: 0.1
            },
           {
            label: 'NG',
            data: [
                @foreach ($item as $key1=>$item1)
                    @if(isset($item1['NG']))
                        {{$item1['NG']}}
                    @else
                        0
                    @endif,
                    @endforeach
               ],
            fill: false,

            backgroundColor: [
                @foreach ($item as $key1=>$item1)
              'rgba(0, 255, 0, 0.9)',
               @endforeach
            ],
             borderColor: [
                 @foreach ($item as $key1=>$item1)
              'rgb(0, 255, 0)',
              @endforeach
            ],
            tension: 0.1
            },
            {
            label: 'NC',
            data: [
                @foreach ($item as $key1=>$item1)
                    @if(isset($item1['NC']))
                        {{$item1['NC']}}
                    @else
                        0
                    @endif,
                    @endforeach
               ],
            fill: false,
            backgroundColor: [
                @foreach ($item as $key1=>$item1)
              'rgba(0, 0, 255, 0.9)',
               @endforeach
            ],
             borderColor: [
                 @foreach ($item as $key1=>$item1)
              'rgb(0, 0, 255)',
              @endforeach
            ],
            tension: 0.1
            }
        ]
    };
var myoption = {
            title: {
                display: true,
                text: '{{$mlist[$key]}} of {{ date('d M Y')}}'
            },
    responsive: true,  
};

var ctx = document.getElementById('my_Chart{{$key}}').getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',    	// Define chart type
				data: myData{{$key}},    	// Chart data
				options: myoption 	// Chart Options [This is optional paramenter use to add some extra things in the chart].
			});
@endforeach

setTimeout(function(){
       location.reload();
   },300000);
</script>
@endsection