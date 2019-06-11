@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">FT Form Application - {{ $methodObj->name }} - {{ $packageObj->name }}</div>

                <div class="panel-body">
                    <div class="row">
                    <div class="col-md-12">
                    <div id="chart_div2" style=" height: 600px;"></div>
                    </div>
                    <div class="col-md-12">
                      <table class='table'>
                        <thead>
                          <tr>
                            <th>Time</th>
                            <th>Shift</th>
                            <th>Method</th>
                            <th>Package</th>
                            <th>Plan</th>
                            <th>Actual</th>
                            <th>สะสม</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                               $sum = 0; 
                           @endphp
                           @foreach ($rawdata as $item)
                           @php
                               $sum += $item->actual;
                           @endphp
                          <tr>
                          <td>{{ $item->timename }}</td>
                          <td>{{ $item->shiftname }}</td>
                          <td>{{ $item->methodname }}</td>
                          <td>{{ $item->packagename }}</td>
                          <td>{{ number_format($item->planning,0,".",",") }}</td>
                          <td>{{ number_format($item->actual,0,".",",") }}</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

     <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization2);

      function drawVisualization2() {
        // Some raw data (not necessarily accurate)
        var data2 = google.visualization.arrayToDataTable([
          ['Time-Product', 'Plan','Actual','Actual สะสม' ],
          @php
              $sum = 0; 
          @endphp
          @foreach ($rawdata as $item)
          @php
            $sum += $item->actual;
        @endphp
            ['{{ $item->timename }}',  
            {{ $item->planning }}, 
            {{ $item->actual }}, 
            {{ $sum }}, 
            ],
          @endforeach
        ]);

        var max1 = {{ $sum }} ;
        var max2 = 500  ;

        var options = {
          displayAnnotations: true,
            chartArea: {
       top: 85,
       right: 110,
       height: '65%' 
    },
    annotations: {
        alwaysOutside : false
    },
    @if(isset($shiftData))
      title : '{{ $methodObj->name }} - {{ $packageObj->name }} - อัตราการผลิตสะสมวันที่ {{ $current_date }} - กะ {{ $shiftData->name }}',
    @else 
      title : '{{ $methodObj->name }} - {{ $packageObj->name }} - อัตราการผลิตสะสมวันที่ {{ $current_date }}',
    @endif
          
          legend: { position: 'top', maxLines: 3 },


          vAxes: {
            0: {
              title: 'ปริมาณสินค้า (กล่อง หรือ EA)',
                viewWindow: {
               // max : max1 -1500,
              },
            },
              1: {
                title: 'ปริมาณสินค้า (กล่อง หรือ EA)',
                viewWindow: {
              //  max : max1 + 100,
              },
            },
          },
          hAxis: {title: 'เวลา'},
          seriesType: 'bars',
          series: {
            0: {
            
        targetAxisIndex: 0
      },

            1: {
            type: 'bar',
            targetAxisIndex:0,
            },
            2: {
            type: 'line',
            targetAxisIndex:1,
            }
          },
          
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
      role: "annotation",
      pointShape: 'square',
      pointsVisible: true
    },
    3,
    {
      calc: "stringify",
      sourceColumn: 3,
      type: "string",
      role: "annotation",
      pointShape: 'square',
      pointsVisible: true
    }]);

var container = document.getElementById('chart_div2');
        var chart = new google.visualization.ComboChart(container);

        google.visualization.events.addListener(chart, 'ready', function () {
        container.innerHTML = '<img src="' + chart.getImageURI() + '">';
        //console.log(chart_div.innerHTML);
      });

        chart.draw(view, options);
      }

    </script>

@endsection