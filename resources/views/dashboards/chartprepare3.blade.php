@extends('layouts.graph')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">FT Form Application - งานเตรียมการ - {{ $logpreparem->process_date }}</div>
        <br />
        <a href="{{ url('/log-prepare-ms') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>


        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <div id="chart_div2" style=" height: 600px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawVisualization2);

  function drawVisualization2() {
    // Some raw data (not necessarily accurate)
    var data2 = google.visualization.arrayToDataTable([
      ['Time', 'Target', 'Input หรือ Output', 'Forecast', 'สะสม+forecast'],
      @foreach($logpreparem->logprepared()->orderBy('process_datetime')->get() as $item)[
        '{{ date("H:i",strtotime($item->process_datetime)) }}', 
        {{ $item->targets }},
        @if($item->input > 0) 
          {{ $item->input }},
        @else 
          {{ $item->output }},
          0,
        @endif @if($item->input_sum > 0) 
          {{ $item->input_sum }},
        @else 
          {{ $item->output_sum }},
        @endif
      ],
      @endforeach
      @foreach($estimateData as $item2)
      [
        'ชม.ที่ {{$item2['time']}}',
        0,
        0,
        {{ $item2['realrate'] }},
        {{ $item2['realtotal'] }}
      ],
      @endforeach
    ]);



    var options = {
      displayAnnotations: true,
      chartArea: {
        top: 85,
        right: 110,
        height: '65%'
      },
      annotations: {
        alwaysOutside: false
      },
      title: 'งานเตรียมการ {{ $logpreparem->preprod->name }} - อัตราสะสมวันที่ {{ $logpreparem->process_date }}',


      legend: {
        position: 'top',
        maxLines: 3
      },


      vAxes: {
        0: {
          title: 'ปริมาณ',
          viewWindow: {
            // max : max1 -1500,
          },
        },
        1: {
          title: 'ปริมาณ',
          viewWindow: {
            //  max : max1 + 100,
          },
        },
      },
      hAxis: {
        title: 'เวลา'
      },
      seriesType: 'bars',
      series: {
        0: {
          type: 'bar',
          targetAxisIndex: 0
        },
        1: {
          type: 'bar',
          targetAxisIndex: 0
        },
        2: {
          type: 'bar',
          targetAxisIndex: 0
        },
        3: {
          type: 'line',
          targetAxisIndex: 1,

        }
      }
    };

    var view = new google.visualization.DataView(data2);

    view.setColumns([
      0,
      1,
      {
        calc: "stringify",
        sourceColumn: 1,
        type: "string",
        role: "annotation"
      },
      2,
      {
        calc: "stringify",
        sourceColumn: 2,
        type: "string",
        role: "annotation"
      },
      3,
      {
        calc: "stringify",
        sourceColumn: 3,
        type: "string",
        role: "annotation"
      },
      4,
      {
        calc: "stringify",
        sourceColumn: 4,
        type: "string",
        role: "annotation"
      }
    ]);

    var container = document.getElementById('chart_div2');
    var chart = new google.visualization.ComboChart(container);

    google.visualization.events.addListener(chart, 'ready', function() {
      container.innerHTML = '<img src="' + chart.getImageURI() + '">';
      //console.log(chart_div.innerHTML);
    });

    chart.draw(view, options);
  }
</script>

@endsection