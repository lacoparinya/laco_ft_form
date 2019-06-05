@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">FT Form Application - {{ $packageObj->name }}</div>

                <div class="panel-body">
                    <div class="row">
                    <div class="col-md-12">
                    <div id="chart_div" style=" height: 600px;"></div>
                    </div>
                    <div class="col-md-12">
                    <div id="chart_div2" style=" height: 600px;"></div>
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
                            <th>PK/PF/PST</th>
                            <th>Total</th>
                            <th>LINE A/B</th>
                            <th>TOTAL LINE</th>
                            <th>SAP REF</th>
                            <th>Grade</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php
                               $sum = 0; 
                           @endphp
                           @foreach ($rawdata as $item)
                           @php
                               $sum += $item->output_kg;
                           @endphp
                          <tr>
                          <td>{{ $item->tname }}</td>
                          <td>{{ $item->shname }}</td>
                          <td>{{ $item->name }}</td>
                          <td>{{ number_format($item->input_kg,0,".",",") }}/{{ number_format($item->output_kg,0,".",",") }}</td>
                          <td>{{ number_format($sum,0,".",",") }}</td>
                          <td>{{ $item->num_pk }}/{{ $item->num_pf }}/{{ $item->num_pst }}</td>
                          <td>{{ $item->num_classify }}</td>
                          <td>{{ $item->line_a }}/{{ $item->line_b }}</td>
                          <td>{{ $item->line_classify }} {{ $item->line_unit }}</td>
                          <td>{{ $item->ref_note }}</td>
                          <td>{{ $item->grade }}</td>
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
          @foreach ($rawdata as $item)
            ['{{ $item->tname }}',  
            {{ $item->output_kg }}, 
            {{$item->std_rate}}, 
            {{ round(($item->output_kg/$item->num_classify)/$item->tgap,2) }},
            ],
          @endforeach
        ]);

        var max1 =  {{ $rawdata2[0]->inmax }};
        var max2 = 
        @if ($rawdata2[0]->maxstd > $rawdata2[0]->maxstp) 
          {{ $rawdata2[0]->maxstd }}
        @else 
          {{ $rawdata2[0]->maxstp }}
        @endif
        ;

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
      title : '{{ $stdprocess->product->name }} - อัตราการผลิตวันที่ {{ $current_date }} - กะ {{ $shiftData->name }}',
    @else 
      title : '{{ $stdprocess->product->name }} - อัตราการผลิตวันที่ {{ $current_date }}',
    @endif
          legend: { position: 'top', maxLines: 3 },
          vAxes: {
            0: {
              title: 'ปริมาณสินค้า (kg)',
              viewWindow: {
            max : max1 + 1500,
          }
              }, 
            1: {
              title: 'Productivity',
              format: '###.00',
              viewWindow: {
            max : max2 + 20,
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
          ['Time-Product', 'Output (kg)','Actual สะสม' ],
          @php
              $sum = 0; 
          @endphp
          @foreach ($rawdata as $item)
          @php
            $sum += $item->output_kg;
        @endphp
            ['{{ $item->tname }}',  
            {{ $item->output_kg }}, 
            {{ $sum }}, 
            ],
          @endforeach
        ]);

        var max1 = {{ $sum }} ;
        var max2 = 
        @if ($rawdata2[0]->maxstd > $rawdata2[0]->maxstp) 
          {{ $rawdata2[0]->maxstd }}
        @else 
          {{ $rawdata2[0]->maxstp }}
        @endif
        ;

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
      title : '{{ $stdprocess->product->name }} - อัตราการผลิตสะสมวันที่ {{ $current_date }} - กะ {{ $shiftData->name }}',
    @else 
      title : '{{ $stdprocess->product->name }} - อัตราการผลิตสะสมวันที่ {{ $current_date }}',
    @endif
          
          legend: { position: 'top', maxLines: 3 },
          vAxis: {
              title: 'ปริมาณสินค้า (kg)',
              viewWindow: {
            max : max1 + 1500,
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