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
                        @if ($type == 'product')
                            <table class='table'>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Avg Selected person</th>
                                    <th>Avg Kg/person/hr</th>
                                    <th>Sum input kg</th>
                                    <th>Sum output kg</th>
                                    <th>% Productivity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataselect as $item)
                                    <tr>
                                    <td>{{ $item->productname }}</td>
                                    <td style="text-align: center">{{ round($item->avgperson,0) }}</td>
                                    <td style="text-align: center">{{ round($item->avgkgpersonhr,3) }}</td>
                                    <td style="text-align: right">{{  number_format($item->suminkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->sumoutkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->productivity,3,".",",") }} %</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        @if ($type=='date')
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Avg Selected person</th>
                                    <th>Avg Kg/person/hr</th>
                                    <th>Sum input kg</th>
                                    <th>Sum output kg</th>
                                    <th>% Productivity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataselect as $item)
                                    <tr>
                                    <td>{{ $item->process_date }}</td>
                                    <td style="text-align: center">{{ round($item->avgperson,0) }}</td>
                                    <td style="text-align: center">{{ round($item->avgkgpersonhr,3) }}</td>
                                    <td style="text-align: right">{{  number_format($item->suminkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->sumoutkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->productivity,3,".",",") }} %</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            @if ($type=='shift')
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>Shift</th>
                                    <th>Avg Selected person</th>
                                    <th>Avg Kg/person/hr</th>
                                    <th>Sum input kg</th>
                                    <th>Sum output kg</th>
                                    <th>% Productivity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataselect as $item)
                                    <tr>
                                    <td>{{ $item->shiftname }}</td>
                                    <td style="text-align: center">{{ round($item->avgperson,0) }}</td>
                                    <td style="text-align: center">{{ round($item->avgkgpersonhr,3) }}</td>
                                    <td style="text-align: right">{{  number_format($item->suminkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->sumoutkg,2,".",",") }}</td>
                                    <td style="text-align: right">{{ number_format($item->productivity,3,".",",") }} %</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        @endif
                        
                        @endif
                        
                    </div>
                    <div class="col-md-12">
                         <a href="{{ url('/planner/dashboard') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection