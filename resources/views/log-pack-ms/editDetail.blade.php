@extends('layouts.apppack')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">สร้างรายการในงานPack #{{ $logpackd->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/log-pack-ms/'.$logpackm->id) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id">ID</label>
                                {{ $logpackm->id }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Date</label>
                                {{ $logpackm->process_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">วิธี</label>
                                {{ $logpackm->method->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">สินค้า</label>
                                {{ $logpackm->package->name }} / {{ $logpackm->package->kgsperpack }}
                            </div>
                             <div class="col-md-3">
                                <label for="id">Order</label>
                                {{ $logpackm->order->order_no }} /
                                {{ $logpackm->order->loading_date }} /
                                {{ $logpackm->order->total_pack }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ยอดรวมของสินค้านี้</label>
                                {{ $logpackm->overalltargets }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ยอดที่ต้องผลิดได้ต่อวัน</label>
                                {{ $logpackm->targetperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวน ชม. ที่ทั้งหมดใช้ผลิตสินค้านี้</label>
                                {{ $logpackm->houroverall }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวน ชม. ต่อวันที่ผลิตสินค้านี้</label>
                                {{ $logpackm->hourperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวน Package รวมที่แพ็คแล้ว</label>
                                {{ $sumoutputpack }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">รวมจำนวน Input (kg)</label>
                                {{ $suminputkg }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">รวมจำนวน Output (kg)</label>
                                {{ $sumoutputkg }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">รายการ</label>
                                {{ $logpackm->logpackd->count() }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Status</label>
                                {{ $logpackm->status }}
                            </div>
                            <div class="col-md-6">
                                <label for="id">Note</label>
                                {{ $logpackm->Note }}
                            </div>
                        </div>

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/log-pack-ms/updateDetail/'.$logpackd->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('log-pack-ms.form-detail', ['formMode' => 'Edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
