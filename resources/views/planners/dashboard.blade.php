@extends('layouts.graph')
@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-12">
             <div class="panel panel-default">
                <div class="panel-heading">งานคัด</div>
                <div class="panel-body">
                    <div class="row">
                    <div class="col-md-12">
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Year/Month</th>
                                    <th>Avg Selected person</th>
                                    <th>Avg Kg/person/hr</th>
                                    <th>Sum input kg</th>
                                    <th>Sum output kg</th>
                                    <th>% Productivity</th>
                                    <th>Drill down</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataselect as $item)
                                <tr>
                                    <td style="text-align: center">{{ $item->process_month }}</td>
                                    <td style="text-align: center">{{ round($item->avgperson,0) }}</td>
                                    <td style="text-align: center">{{ round($item->avgkgpersonhr,3) }}</td>
                                    <td style="text-align: right">{{  number_format($item->suminkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->sumoutkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->productivity,3,".",",") }} %</td>
                                    <td>แยกตาม <a href="{{ url('/planner/selectbyyearmonth/'.$item->process_month."/product") }}" title="{{ $item->process_month }}">Product</a> | 
                                    <a href="{{ url('/planner/selectbyyearmonth/'.$item->process_month."/date") }}" title="{{ $item->process_month }}">Date</a> | 
                                    <a href="{{ url('/planner/selectbyyearmonth/'.$item->process_month."/shift") }}" title="{{ $item->process_month }}">shift</a>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection