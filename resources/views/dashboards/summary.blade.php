@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>สรุปงานคัด {{ $rawdata[0]->process_date }}</h3></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">งาน</th>
                                        <th colspan="3">กำลังคน</th>
                                        <th colspan="3">Cap (unit/hr)</th>
                                        <th colspan="3">เป้าหมาย (unit/{{ $rawdata[0]->sum_hr }} hr)</th>
                                        <th rowspan="2">Diff</th>
                                        <th rowspan="2">Note</th>
                                    </tr>
                                    <tr>
                                        <th>Actual</th>
                                        <th>Target</th>
                                        <th>Finger</th>
                                        <th>Actual</th>
                                        <th>Targt PK</th>
                                        <th>Target PL</th>
                                        <th>Actual</th>
                                        <th>Targt PK</th>
                                        <th>Target PL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($rawdata as $item)    
                                    <tr>
                                    <td>{{ $item->name }}</td>
                                        <td>{{ $item->man_act }}</td>
                                        <td>{{ $item->man_target }}</td>
                                        <td>0</td>
                                        <td>{{ number_format($item->value_act,0,".",",") }}</td>
                                        <td>{{ number_format($item->value_cal,0,".",",") }}</td>
                                        <td>{{ number_format($item->value_target,0,".",",") }}</td>
                                        <td>{{ number_format($item->sum_act,0,".",",") }}</td>
                                        <td>{{ number_format($item->sum_cal,0,".",",") }}</td>
                                        <td>{{ number_format($item->sum_target,0,".",",") }}</td>
                                        <td>{{ number_format($item->gap,0,".",",") }}</td>
                                        <td>{{ $item->note }}</td>
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
@endsection
