@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">FT Form Application</div>

                <div class="panel-body">
                    <div class="row">
                    <div class="col-md-12">
                    <div id="chart_div" style=" height: 500px;"></div>
                    </div>
                    <div class="col-md-12">
                    <div id="chart_div2" style=" height: 500px;"></div>
                    </div>
                    <div class="col-md-12">
                    <div id="chart_div3" style=" height: 500px;"></div>
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
  google.charts.setOnLoadCallback(drawVisualization3);

  function drawVisualization() {
    var data = google.visualization.arrayToDataTable([
        ['Time-Product', 'Output (kg)','Productivity (Output/MH)' ],
      @foreach ($rawdata as $item)
        ['{{ $item->tname }} - {{ $item->name }}',  {{ $item->output_kg }}, {{ round(($item->output_kg/$item->num_classify)/$item->tgap,2) }}, ],
      @endforeach
    ]);

    var maxval = {{ $rawdata2[0]->inmax }};

    var options = {
      displayAnnotations: true,
       chartArea: {
        top: 45,
        right: 110,
        height: '50%' 
      },
      annotations: {
        alwaysOutside : false
      },
      title : 'อัตราการผลิตวันที่ {{ $current_date }}',
      legend: { 
        position: 'top', 
        maxLines: 3 
      },
      vAxes: {
        0: {
          title: 'ปริมาณสินค้า (kg)',
          viewWindow: {
            max : maxval + 2000,
          }
        }, 
        1: {
          title: 'Productivity',
          format: '###.00',
          
        }
      },
      hAxis: {
        title: 'เวลา-สินค้า'
      },
      seriesType: 'bars',
        series: {
          0: {
            targetAxisIndex: 0,
            annotations: {
          stem: {
            color: 'transparent',
            length: 16
          }
        },
          },
          1: {
            type: 'line',
            targetAxisIndex:1,
            annotations: {
          stem: {
            color: 'transparent',
            length: 16
          }
        },
          },
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
        }
      ]);

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
        var data = google.visualization.arrayToDataTable([
          ['Time-Product','Yeild %', { role: 'annotation' } ],
          @foreach ($rawdata as $item)
            ['{{ $item->tname }} - {{ $item->name }}',  {{ round(($item->output_kg*100/$item->input_kg),2) }}, {{ round(($item->output_kg*100/$item->input_kg),2) }} ],
          @endforeach
        ]);

        var options = {
          chartArea: {
       top: 45,
       right: 110,
       height: '50%' 
    },
          title : 'Yeild การผลิตวันที่ {{ $current_date }}',
           legend: { position: 'top', maxLines: 3 },
          vAxis: {title: 'Yeild %'},
          hAxis: {title: 'เวลา-สินค้า'},
          seriesType: 'bars',
          series: {5: {type: 'line'}},
          colors:['orange','#004411'],
        };

       // var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
       // chart.draw(data, options);


var container = document.getElementById('chart_div2');
        var chart = new google.visualization.ComboChart(container);

        google.visualization.events.addListener(chart, 'ready', function () {
        container.innerHTML = '<img src="' + chart.getImageURI() + '">';
        //console.log(chart_div.innerHTML);
      });

        chart.draw(data, options);


      }

      function drawVisualization3() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time-Product','จำนวนคนคัด',{ role: 'annotation' },'ประสิทธิภาพ (kg/hr)',{ role: 'annotation' } ],
          @foreach ($rawdata as $item)
            ['{{ $item->tname }} - {{ $item->name }}', {{ $item->num_classify }}, {{ $item->num_classify }}, {{ round(($item->output_kg/$item->num_classify)/$item->tgap,2) }}, {{ round(($item->output_kg/$item->num_classify)/$item->tgap,2) }},  ],
          @endforeach
        ]);

        var options = {
          chartArea: {
       top: 45,
       right: 110,
       height: '50%' 
    },
          title : 'ประสิทธิภาพ การผลิตวันที่ {{ $current_date }}',
           legend: { position: 'top', maxLines: 3 },
          vAxis: {title: 'ปริมาณที่คัดได้ (kg) / คนคัด / ชม.'},
          hAxis: {title: 'เวลา-สินค้า'},
          seriesType: 'bars',
          series: {5: {type: 'line'}},
          colors:['green','#004411'],
        };

        var container = document.getElementById('chart_div3');
        var chart = new google.visualization.ComboChart(container);

        google.visualization.events.addListener(chart, 'ready', function () {
        container.innerHTML = '<img src="' + chart.getImageURI() + '">';
        //console.log(chart_div.innerHTML);
      });

        chart.draw(data, options);
      }
      
    </script>

@endsection