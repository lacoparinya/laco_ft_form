@extends('layouts.app')

@section('content')
@php
    $monthlist = array(
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec'
        );
@endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Planning {{ $planrptm->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/plan-rpt') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/plan-rpt/' . $planrptm->id . '/edit') }}" title="Edit Planning"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('plan-rpt' . '/' . $planrptm->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Planning" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $planrptm->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>วันที่ลงข้อมูล</th><td>{{ $planrptm->enter_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>เดือน ปี</th><td>{{ $monthlist[$planrptm->month] }} {{ $planrptm->year }}</td>
                                    </tr>
                                    <tr>
                                        <th>status</th><td>{{ $planrptm->status }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $planrptm->note }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Group</th>
                                        <th>Delivery Plan</th>
                                        <th>ยืนยัน</th>
                                        <th>บรรจุได้</th>
                                        <th>รอส่งมอบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($planrptm->planrptds as $item)
                                    <tr>
                                        <td>{{ $item->plangroup->name }}</td>
                                        <td>{{ $item->num_delivery_plan }}</td>
                                        <td>{{ $item->num_confirm }}</td>
                                        <td>{{ $item->num_packed }}</td>
                                        <td>{{ $item->num_wait }}</td>
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
