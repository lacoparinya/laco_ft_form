@extends('layouts.appfreeze2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>แก้ไขรายการในงานStamp #{{ $stampd->id }}</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/stamp-ms/'.$stampm->id) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <div class="row">
                            <div class="col-md-1">
                                <label for="id">ID:</label>
                                {{ $stampm->id }}
                            </div>
                            <div class="col-md-2">
                                <label for="id">Date / กะ:</label>
                                {{ $stampm->process_date }} / {{ $stampm->shift->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">เครื่อง:</label>
                                {{ $stampm->stampmachine->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ผลิตภัณฑ์:</label>
                                {{ $stampm->matpack->matname }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Packageing:</label>
                                {{ $stampm->matpack->packname }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Order No:</label>
                                {{ $stampm->order_no }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Pack Date:</label>
                                {{ $stampm->pack_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">เป้าพนักงาน / มาจริง:</label>
                                {{ $stampm->staff_target }} / {{ $stampm->staff_actual }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ผู้ดูแล:</label>
                                {{ $stampm->staff_operate }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Status:</label>
                                {{ $stampm->status }}
                            </div>
                            <div class="col-md-9">
                                <label for="id">Note:</label>
                                {{ $stampm->note }}
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
