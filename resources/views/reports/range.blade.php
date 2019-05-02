@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">รายงานตั้งแต่วันที่ถึงวันที่</div>
                    <div class="card-body">
                        <a href="{{ url('/ft_logs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                
                        <form method="POST" action="{{ url('/reports/reportAction') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                            <div class="form-group col-md-6 {{ $errors->has('from_date') ? 'has-error' : ''}}">
                                <label for="from_date" class="control-label">{{ 'จากวัน' }}</label>
                                <input class="form-control" name="from_date" type="date" id="from_date" value="{{ $ft_log->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
                                {!! $errors->first('from_date', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group col-md-6 {{ $errors->has('to_date') ? 'has-error' : ''}}">
                                <label for="to_date" class="control-label">{{ 'ถึงวัน' }}</label>
                                <input class="form-control" name="to_date" type="date" id="to_date" value="{{ $ft_log->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
                                {!! $errors->first('to_date', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group  col-md-12">
                                <input type="hidden" name="action_type" id="action_type" value="range">
                                <input class="btn btn-primary" type="submit" value="Export">
                            </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection