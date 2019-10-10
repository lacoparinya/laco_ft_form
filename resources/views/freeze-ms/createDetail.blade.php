@extends('layouts.appfreeze2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header"><h3>สร้างรายการงานฟรีส #{{$freezem->id}}</h3></div>
                    <div class="card-body">
                        <a href="{{ url('/freeze-ms/'.$freezem->id) }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <div class="row">
                            <div class="col-md-4">
                            <h3>Date : {{$freezem->process_date}}</h3>
                            </div>
                            <div class="col-md-4">
                            <h3>Job : {{$freezem->iqfjob->name}}</h3>
                            </div>
                             <div class="col-md-4">
                            <h3>Target (kg/hr/person) : {{$freezem->targets}}</h3>
                            </div>
                            <div class="col-md-6">
                            <h3>วัตถุดิบเริ่ม (kg) : {{$freezem->start_RM}}</h3>
                            </div>
                            <div class="col-md-6">
                            <h3>คงเหลือ (kg) : {{$freezem->start_RM - $freezeall}} </h3>
                            </div>
                        </div>

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/freeze-ms/storeDetail/'.$freezem->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('freeze-ms.form-detail', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
