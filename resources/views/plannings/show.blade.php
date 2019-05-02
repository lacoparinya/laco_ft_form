@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Planning {{ $planning->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/plannings') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/plannings/' . $planning->id . '/edit') }}" title="Edit Planning"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('plannings' . '/' . $planning->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Planning" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $planning->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>ส่วนงาน</th><td>{{ $planning->job->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>แผนวันที่</th><td>{{ $planning->plan_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>เป้าจำนวนคน</th><td>{{ $planning->target_man }}</td>
                                    </tr>
                                    <tr>
                                        <th>เป้าจำนวน(kg)</th><td>{{ $planning->target_value }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $planning->note }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
