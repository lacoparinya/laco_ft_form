@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">FT Form Application - {{ $logpackm->method->name }} - {{ $logpackm->package->name }}</div>
  <br />
            <a href="{{ url('/log-pack-ms/?status='.$logpackm->status) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                       
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
                            <th>Shift</th>
                            <th>Method</th>
                            <th>Package</th>
                            <th>Plan</th>
                            <th>Actual</th>
                            <th>forecast</th>
                            <th>สะสม</th>
                            <th>คงค้าง</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                               $sum = 0;
                              $remain = 0; 
                              
                           @endphp
                           @foreach ($logpackm->logpackd()->orderBy('process_datetime')->get() as $item)
                           @php
                               $sum += $item->output_pack;
                              $remain = $logpackm->targetperday - $sum;
                           @endphp
                          <tr>
                          <td>{{ date('d/m/y H:i',strtotime($item->process_datetime)) }}</td>
                          <td>{{ $logpackm->shift->name }}</td>
                          <td>{{ $logpackm->method->name }}</td>
                          <td>{{ $logpackm->package->name }}</td>
                          <td>{{ number_format(($logpackm->stdpack->std_rate)*($item->workhours)*($item->num_pack),0,".",",") }}</td>
                          <td>{{ number_format($item->output_pack,0,".",",") }}</td>
                          <td>-</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          <td>{{ number_format($remain,0,".",",") }} {{  $logpackm->targetperday }}</td>
                          </tr>
                          @endforeach
                          @foreach ($estimateData as $item)
                          @php
                               $sum += $item['realrate'];
                              $remain = $logpackm->targetperday - $sum;
                           @endphp
                          <tr>
                          <td>ชม.ที่ {{ $item['time'] }}</td>
                          <td>{{ $logpackm->shift->name }}</td>
                          <td>{{ $logpackm->method->name }}</td>
                          <td>{{ $logpackm->package->name }}</td>
                          <td>-</td>
                          <td>-</td>
                          <td>{{  round($item['realrate'],2) }}</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          <td>{{ number_format($remain,0,".",",") }} {{  $logpackm->targetperday }}</td>
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
           ['Time-Product', 
          {label: 'Plan', type: 'number'},
          {label: 'Actual', type: 'number'},
          {label: 'Forecast', type: 'number'},
          {label: 'Actual สะสม', type: 'number'},
          {label: 'Remain', type: 'number'}],
          @php
              $sum = 0; 
              $remain = 0;
          @endphp
          @foreach ($logpackm->logpackd()->orderBy('process_datetime')->get() as $item)
          @php
            $sum += $item->output_pack;
            $remain = (empty($logpackm->targetperday) ? 0 : $logpackm->targetperday) - $sum;
          @endphp
            ['{{ date('d/m/y H:i',strtotime($item->process_datetime)) }}',  
            {{ ($logpackm->stdpack->std_rate)*($item->workhours)*($item->num_pack) }}, 
            {{ $item->output_pack }}, 
            null,
            {{ $sum }}, 
            {{ $remain }}, 
            ],
          @endforeach
          @foreach ($estimateData as $item)
          @php
            $sum += $item['realrate'];
            $remain = (empty($logpackm->targetperday) ? 0 : $logpackm->targetperday) - $sum;
          @endphp
            ['ชม.ที่ {{$item['time']}}',  
            null, 
            null, 
            {{ round($item['realrate'],2) }},
            {{ $sum }}, 
            {{ $remain }}, 
            ],
          @endforeach
        ]);

        var max1 = {{ $sum }} ;
        var max2 = {{ $sum }}  ;

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
    @if(isset($logpackm->shift->name))
      title : '{{ $logpackm->method->name }} - {{ $logpackm->package->name }} - อัตราการผลิตสะสม และประมาณการ วันที่ {{ $logpackm->process_date }} - กะ {{ $logpackm->shift->name }}',
    @else 
      title : '{{ $logpackm->method->name }} - {{ $logpackm->package->name }} - อัตราการผลิตสะสม และประมาณการ วันที่ {{ $logpackm->process_date }}',
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
            type: 'bar',
            targetAxisIndex:0,
            },
            3: {
            type: 'line',
            targetAxisIndex:1,
            },
            4: {
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
    },
    5,
    {
      calc: "stringify",
      sourceColumn: 5,
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