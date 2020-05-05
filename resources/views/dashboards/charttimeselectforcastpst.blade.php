@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">FT Form Application - {{ $logselectm->pstproduct->name  }}</div>

                <div class="panel-body">
                  <a href="{{ url('/log-pst-selects/?status='.$logselectm->status) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        
                    <div class="row">
                      <div class="col-md-12">
                    <div id="chart_div2" style=" height: 600px;"></div>
                    </div>
                    <div class="col-md-12">
                    <div id="chart_div" style=" height: 600px;"></div>
                    </div>
                    <div class="col-md-12">
                      <table class='table'>
                        <thead>
                          <tr>
                            <th>Time</th>
                            <th>Shift</th>
                            <th>Product</th>
                            <th>Input/Output</th>
                            <th>forecast</th>
                            <th>สะสมรวม</th>
                            <th>SAP REF</th>
                            <th>Grade</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                               $sum = 0; 
                           @endphp
                           @foreach ($logselectm->logpstselectd()->orderBy('process_datetime')->get() as $item)
                           @php
                               $sum += $item->output_kg;
                           @endphp
                          <tr>
                          <td>{{ date('H:i',strtotime($item->process_datetime)) }}</td>
                          <td>{{ $logselectm->shift->name }}</td>
                          <td>{{ $logselectm->pstproduct->name }}</td>
                          <td>{{ number_format($item->input_kg,0,".",",") }}/{{ number_format($item->output_kg,0,".",",") }}</td>
                          <td>-</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          <td>{{ $item->ref_note }}</td>
                          <td>{{ $item->grade }}</td>
                          </tr>
                          @endforeach
                          @foreach ($estimateData as $item)
                           @php
                               $sum += $item['realrate'];
                           @endphp
                          <tr>
                          <td>ชม.ที่ {{ $item['time'] }}</td>
                          <td>{{ $logselectm->shift->name }}</td>
                          <td>{{ $logselectm->pstproduct->name }}</td>
                          <td> 0 / 0</td>
                          <td>{{ number_format($item['realrate'],0,".",",") }}</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          <td> - </td>
                          <td> - </td>
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
      google.charts.setOnLoadCallback(drawVisualization);
      google.charts.setOnLoadCallback(drawVisualization2);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time-Product', 'Output (kg)','STD Productivity','Productivity (Output/MH)' ],
          @foreach ($logselectm->logpstselectd()->orderBy('process_datetime')->get() as $item)
            ['{{ date('H:i',strtotime($item->process_datetime)) }}',  
            {{ $item->output_kg }}, 
            {{$logselectm->stdselectpst->std_rate_per_h_m}}, 
            {{ round(($item->output_kg/$item->num_classify)/$item->workhours,2) }},
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
        alwaysOutside : false
    },
    @if(isset($logselectm->shift))
      title : '{{ $logselectm->pstproduct->name }} - อัตราการผลิตวันที่ {{ $logselectm->process_date }} - กะ {{ $logselectm->shift->name }}',
    @else 
      title : '{{ $logselectm->pstproduct->name }} - อัตราการผลิตวันที่ {{ $logselectm->process_date }}',
    @endif
          legend: { position: 'top', maxLines: 3 },
          vAxes: {
            0: {
              title: 'ปริมาณสินค้า (kg)',
              viewWindow: {
          }
              }, 
            1: {
              title: 'Productivity',
              format: '###.00',
              viewWindow: {
          }
              }
          },
          hAxis: {title: 'เวลา'},
          seriesType: 'bars',
          series: {
            0: {
            
        targetAxisIndex: 0
      },

            1: {
            type: 'line',
            targetAxisIndex:1,
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

        var view = new google.visualization.DataView(data);

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

var container = document.getElementById('chart_div');
        var chart = new google.visualization.ComboChart(container);

        google.visualization.events.addListener(chart, 'ready', function () {
        container.innerHTML = '<img src="' + chart.getImageURI() + '">';
        //console.log(chart_div.innerHTML);
      });

        chart.draw(view, options);
      }

      function drawVisualization2() {
        // Some raw data (not necessarily accurate)
        var data2 = google.visualization.arrayToDataTable([
          ['Time-Product', { label:'Output (kg)',type:'number'}, { label:'Forecast (kg)',type:'number'},'Actual สะสม' ],
          @php
              $sum = 0; 
          @endphp
          @foreach ($logselectm->logpstselectd()->orderBy('process_datetime')->get() as $item)
          @php
            $sum += $item->output_kg;
          @endphp
            ['{{ date('H:i',strtotime($item->process_datetime)) }}',
            {{ $item->output_kg }}, 
            null,
            {{ $sum }}, 
            ],
          @endforeach
          @foreach ($estimateData as $item)
          @php
            $sum += $item['realrate'];
          @endphp
            ['ชมที่. {{ $item['time'] }}',  
            null,
            {{ $item['realrate'] }}, 
            {{ $sum }}, 
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
        alwaysOutside : false
    },
    @if(isset($logselectm->shift))
      title : '{{ $logselectm->pstproduct->name }} - อัตราการผลิตสะสมวันที่ {{ $logselectm->process_date }} - กะ {{ $logselectm->shift->name }}',
    @else 
      title : '{{ $logselectm->pstproduct->name }} - อัตราการผลิตสะสมวันที่ {{ $logselectm->process_date }}',
    @endif
          
          legend: { position: 'top', maxLines: 3 },
          vAxes: {
            0: {
              title: 'ปริมาณสินค้า (kg)',
              viewWindow: {
         //   max : max1 + 1500,
          }
              }, 
            1: {
              title: 'ปริมาณสินค้าสะสม (kg)',
              viewWindow: {
           // max : max2 + 1500,
          }
              }
          },
          hAxis: {title: 'เวลา'},
          seriesType: 'bars',
          series: {
            0: {
        targetAxisIndex: 0
        },
        1: {
        targetAxisIndex: 0
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
      role: "annotation"
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