@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">รายงานPSTรายวัน</div>
                    <div class="card-body">
                        <a href="{{ url('/ft-log-pres') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                
                        <form method="POST" action="{{ url('/reports/reportPstAction') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                            <div class="form-group col-md-12 {{ $errors->has('process_date') ? 'has-error' : ''}}">
                                <label for="process_date" class="control-label">{{ 'วันผลิต' }}</label>
                                <input class="form-control" name="process_date" type="date" id="process_date" value="{{ $ft_log->process_date or \Carbon\Carbon::now()->format('Y-m-d') }}" >
                                {!! $errors->first('process_date', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group  col-md-12">
                                <input type="hidden" name="action_type" id="action_type" value="daily">
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