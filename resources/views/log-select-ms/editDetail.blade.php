@extends('layouts.appselect')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">สร้างรายการในงานคัด #{{ $logselectd->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/log-select-ms/'.$logselectm->id) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id">ID</label>
                                {{ $logselectm->id }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">วันที่</label>
                                {{ $logselectm->process_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">กะ</label>
                                {{ $logselectm->shift->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">สินค้า</label>
                                {{ $logselectm->product->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวนชม.ที่ใช้ในการผลิต</label>
                                {{ $logselectm->hourperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวนสินค้าที่ต้องผลิต</label>
                                {{ $logselectm->targetperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">SAP CODE</label>
                                {{ $logselectm->ref_note }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">note</label>
                                {{ $logselectm->note }}
                            </div>
                        </div>


                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/log-select-ms/updateDetail/'.$logselectd->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('log-select-ms.form-detail', ['formMode' => 'Edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
