@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">FT Form Application - งานผลิตวันที่ {{ $date  }}</div>

                <div class="panel-body">
                  <a href="{{ url('/log-pst-selects/?status=active') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        
                    <div class="row">
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
                            <th>สะสมรวม</th>
                            <th>Total</th>
                            <th>SAP REF</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                               $sum = 0; 
                           @endphp
                           @foreach ($logselectds as $item)
                           @php
                               $sum += $item->output_kg;
                           @endphp
                          <tr>
                          <td>{{ date('H:i',strtotime($item->process_datetime)) }}</td>
                          <td>{{ $item->logpstselectm->shift->name }}</td>
                          <td>{{ $item->logpstselectm->pstproduct->name }}</td>
                          <td>{{ number_format($item->input_kg,0,".",",") }}/{{ number_format($item->output_kg,0,".",",") }}</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          <td>{{ $item->num_classify }}</td>
                          <td>{{ $item->ref_note }}</td>
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
      //google.charts.setOnLoadCallback(drawVisualization2);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time-Product', 'Output (kg)','STD Productivity','Productivity (Output/MH)' ],
          @foreach ($logselectds as $item)
            ['{{ date('H:i',strtotime($item->process_datetime)) }}\n{{ $item->logpstselectm->pstproduct->name }}',  
            {{ $item->output_kg }}, 
            {{ $item->logpstselectm->stdselectpst->std_rate_per_h_m }}, 
            @if($item->num_classify > 0 && $item->workhours > 0)
            {{ round(($item->output_kg/$item->num_classify)/$item->workhours,2) }},
            @else
            0,
            @endif
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
      title : 'อัตราการผลิตวันที่ {{ $date }}',
    @else 
      title : 'อัตราการผลิตวันที่ {{ $date }}',
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

      

    </script>

@endsection