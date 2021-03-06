@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-heading">FT Form Application - Freeze - {{ $current_date }}</div>
            <br />
 <a href="{{ url('/ft-log-freezes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
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
                            <th>Date</th>
                            <th>Time</th>
                            <th>Product</th>
                            <th>Freeze ได้</th>
                            <th>Freeze สะสม</th>
                            <th>RM คงเหลือ</th>
                          </tr>
                        </thead>
                        <tbody>
                           @foreach ($rawdata as $item)
                          <tr>
                            <td>{{ $item->process_date }}</td>
                          <td>{{ date('H:i',strtotime($item->process_time)) }}</td>
                          <td>{{ $item->iqf_job_name }}</td>
                          <td>{{ number_format($item->output_sum,2,".",",") }}</td>
                          <td>{{ number_format($item->output_all_sum,2,".",",") }}</td>
                          <td>{{ number_format($item->current_RM,2,".",",") }}</td>
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
          ['Time', 'Freeze ได้','Freeze สะสม','RM คงเหลือ' ],
          @foreach ($rawdata as $item)
            ['{{ date("H:i",strtotime($item->process_time)) }}',  
            {{ $item->output_sum }}, 
            {{ $item->output_all_sum }}, 
            {{ $item->current_RM }}, 
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
    },     title : 'Freeze ถั่วแระ {{ $rawdata[0]->iqf_job_name }} - อัตราการผลิตสะสมวันที่ {{ $current_date }}',

          
          legend: { position: 'top', maxLines: 3 },


          vAxes: {
            0: {
              title: 'ปริมาณ kg',
                viewWindow: {
               // max : max1 -1500,
              },
            },
              1: {
                title: 'ปริมาณ kg',
                viewWindow: {
              //  max : max1 + 100,
              },
            },
          },
          hAxis: {title: 'เวลา'},
          seriesType: 'bars',
          series: {
            0: {
            type: 'bar',
        targetAxisIndex: 0
      },

            1: {
            type: 'line',
            targetAxisIndex:1,
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