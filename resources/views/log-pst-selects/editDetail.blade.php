@extends('layouts.appselect')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>แก้ไขรายการในงานคัด #{{ $logpstselectd->id }}</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/log-select-ms/'.$logpstselectm->id) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id">ID</label>
                                {{ $logpstselectm->id }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">วันที่</label>
                                {{ $logpstselectm->process_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">กะ</label>
                                {{ $logpstselectm->shift->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">สินค้า</label>
                                {{ $logpstselectm->pstproduct->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวนชม.ที่ใช้ในการผลิต</label>
                                {{ $logpstselectm->hourperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวนสินค้าที่ต้องผลิต</label>
                                {{ $logpstselectm->targetperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">SAP CODE</label>
                                {{ $logpstselectm->ref_note }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">note</label>
                                {{ $logpstselectm->note }}
                            </div>
                        </div>


                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/log-pst-selects/updateDetail/'.$logpstselectd->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('log-pst-selects.form-detail', ['formMode' => 'Edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
