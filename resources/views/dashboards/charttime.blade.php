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
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time-Product','Input (kg)', 'Output (kg)' ],
          @foreach ($rawdata as $item)
            ['{{ date('H:i',strtotime($item->process_time)) }} - {{ $item->name }}',  {{ $item->input_kg }},  {{ $item->output_kg }},  ],
          @endforeach
        ]);

        var options = {
          title : 'อัตราการผลิตวันที่ {{ $current_date }}',
          vAxis: {title: 'ปริมาณสินค้า (kg)'},
          hAxis: {title: 'เวลา-สินค้า'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      function drawVisualization2() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time-Product','Yeild %' ],
          @foreach ($rawdata as $item)
            ['{{ date('H:i',strtotime($item->process_time)) }} - {{ $item->name }}',  {{ round(($item->output_kg*100/$item->input_kg),2) }},  ],
          @endforeach
        ]);

        var options = {
          title : 'Yeild การผลิตวันที่ {{ $current_date }}',
          vAxis: {title: 'Yeild %'},
          hAxis: {title: 'เวลา-สินค้า'},
          seriesType: 'bars',
          series: {5: {type: 'line'}},
          colors:['orange','#004411'],
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }

      function drawVisualization3() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Time-Product','จำนวนคนคัด','ประสิทธิภาพ' ],
          @foreach ($rawdata as $item)
            @if( date('H:i',strtotime($item->process_time)) == '05:30' || date('H:i',strtotime($item->process_time)) == '09:00')
            ['{{ date('H:i',strtotime($item->process_time)) }} - {{ $item->name }}', {{ $item->num_classify }}, {{ round(($item->output_kg/$item->num_classify)/1.5,2) }},  ],
            @else
             @if( date('H:i',strtotime($item->process_time)) == '16:30')
             ['{{ date('H:i',strtotime($item->process_time)) }} - {{ $item->name }}', {{ $item->num_classify }}, {{ round(($item->output_kg/$item->num_classify)/0.5,2) }},  ],
            @else
            ['{{ date('H:i',strtotime($item->process_time)) }} - {{ $item->name }}', {{ $item->num_classify }}, {{ round(($item->output_kg/$item->num_classify),2) }},  ],
              @endif
            @endif
          @endforeach
        ]);

        var options = {
          title : 'ประสิทธิภาพ การผลิตวันที่ {{ $current_date }}',
          vAxis: {title: 'ปริมาณที่คัดได้ (kg) / คนคัด / ชม.'},
          hAxis: {title: 'เวลา-สินค้า'},
          seriesType: 'bars',
          series: {5: {type: 'line'}},
          colors:['green','#004411'],
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }
      
    </script>

@endsection