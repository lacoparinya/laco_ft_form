@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">FT Form Application</div>

                <div class="panel-body">
                    <div class="row">
                    <div class="col-md-6">
                    <div id="chart_div" style=" height: 500px;"></div>
                    </div>
                    <div class="col-md-6">
                    <div id="chart_div2" style=" height: 500px;"></div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

    

     <script type="text/javascript">
     @if (!($rawdata->isEmpty()))
      google.charts.load('current', {'packages':['corechart']});
      
      google.charts.setOnLoadCallback(drawVisualization);
      google.charts.setOnLoadCallback(drawVisualization2);
      

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Product', 'Input (kg)', 'Output (kg)', ],
          @foreach ($rawdata as $item)
            ['{{ $item->name }}',  {{ $item->suminput }},      {{ $item->sumoutput }},              ],
          @endforeach
        ]);

        var options = {
          title : 'อัตราการผลิตวันที่ {{ $current_date }}',
          vAxis: {title: 'ปริมาณสินค้า (kg)'},
          hAxis: {title: 'สินค้า'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

      function drawVisualization2() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Product', 'Yeild (%)', ],
          @foreach ($rawdata as $item)
            ['{{ $item->name }}',  {{ round($item->yeilds,2) }},         ],
          @endforeach
        ]);

        var options = {
          title : 'Yeild การผลิตวันที่ {{ $current_date }}',
          vAxis: {title: 'Yeild (%)'},
          hAxis: {title: 'สินค้า'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
      @endif
    </script>

@endsection