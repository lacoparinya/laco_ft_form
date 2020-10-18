@extends('layouts.appfreeze2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>แก้ไขรายการในงานเตรียมการ #{{ $stampd->id }}</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/stamp-ms/'.$stampm->id) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="id">ID</label>
                                {{ $stampm->id }}
                            </div>
                            <div class="col-md-4">
                                <label for="id">Date</label>
                                {{ $stampm->process_date }}
                            </div>
                            <div class="col-md-4">
                                <label for="id">ผลิตภัณฑ์</label>
                                {{ $stampm->matpack->matname }}
                            </div>
                            <div class="col-md-4">
                                <label for="id">Packageing</label>
                                {{ $stampm->matpack->packname }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="id">สะสม Output : </label>
                                @php
                                    $outputsum = 0;
                                    foreach( $stampm->stampd as $item){
                                        $outputsum += $item->output;
                                    }
                                    echo  $outputsum;
                                @endphp
                            </div>
                            <div class="col-md-6">
                                <label for="id">จำนวน</label>
                                {{ $stampm->stampd->count() }}
                            </div>
                        </div>

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/stamp-ms/updateDetail/' . $stampd->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('stamp-ms.form-detail', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
