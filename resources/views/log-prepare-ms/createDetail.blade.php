@extends('layouts.appfreeze2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>สร้างรายการในงานเตรียมการ</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/log-prepare-ms/'.$logpreparem->id) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="id">ID</label>
                                {{ $logpreparem->id }}
                            </div>
                            <div class="col-md-4">
                                <label for="id">Date</label>
                                {{ $logpreparem->process_date }}
                            </div>
                            <div class="col-md-4">
                                <label for="id">ผลิตภัณฑ์</label>
                                {{ $logpreparem->preprod->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="id">สะสม Input/Output : </label>
                                @php
                                    $inputsum = 0;
                                    $outputsum = 0;
                                    foreach( $logpreparem->logprepared as $item){
                                        $inputsum += $item->input;
                                        $outputsum += $item->output;
                                    }
                                    echo $inputsum." / ".$outputsum;
                                @endphp
                            </div>
                            <div class="col-md-6">
                                <label for="id">จำนวน</label>
                                {{ $logpreparem->logprepared->count() }}
                            </div>
                        </div>

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/log-prepare-ms/storeDetail/'.$logpreparem->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('log-prepare-ms.form-detail', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
