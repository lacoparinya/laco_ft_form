@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">FT Form Application - {{ $stampm->stampmachine->name }} - {{ $stampm->matpack->matname }}</div>
 <br />
            <a href="{{ url('/stamp-ms') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                       
                        <br />
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
                            <th>เครื่อง</th>
                            <th>สินค้า</th>
                            <th>Plan</th>
                            <th>Actual</th>
                            <th>สะสม</th>
                            <th>คงค้าง</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                               $sum = 0;
                              $remain = 0; 
                              
                           @endphp
                           @foreach ($stampm->stampd()->orderBy('process_datetime')->get() as $item)
                           @php
                               $sum += $item->output;
                              $remain = $stampm->stampd->sum('workhours')*$stampm->rateperhr - $sum;
                           @endphp
                          <tr>
                          <td>{{ date('d/m/y H:i',strtotime($item->process_datetime)) }}</td>
                          <td>{{ $stampm->stampmachine->name }}</td>
                          <td>{{ $stampm->matpack->matname }}</td>
                          <td>{{ number_format(($stampm->rateperhr)*($item->workhours),0,".",",") }}</td>
                          <td>{{ number_format($item->output,0,".",",") }}</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          <td>{{ number_format($remain,0,".",",") }} / {{  $stampm->rateperhr }}</td>
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
          ['Time-Product', 'Plan','Actual','Actual สะสม','Remain' ],
          @php
              $sum = 0; 
              $remain = 0;
          @endphp
          @foreach ($stampm->stampd()->orderBy('process_datetime')->get() as $item)
          @php
            $sum += $item->output;
            $remain = $stampm->stampd->sum('workhours')*$stampm->rateperhr - $sum;
        @endphp
            ['{{ date('d/m/y H:i',strtotime($item->process_datetime)) }}',  
            {{ ($stampm->rateperhr)*($item->workhours) }}, 
            {{ $item->output }}, 
            {{ $sum }}, 
            {{ $remain }}, 
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
      title : '{{ $stampm->stampmachine->name }} - {{ $stampm->matpack->matname }} - อัตราการStampสะสมวันที่ {{ $stampm->process_date }}',
          
          legend: { position: 'top', maxLines: 3 },


          vAxes: {
            0: {
              title: 'ปริมาณสินค้า',
                viewWindow: {
               // max : max1 -1500,
              },
            },
              1: {
                title: 'ปริมาณสินค้า',
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
            },
            3: {
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
    },
    4,
    {
      calc: "stringify",
      sourceColumn: 4,
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