@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Planning #{{ $planning->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/plannings') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        @if (!empty($redirect) && !empty($date))
                        <form method="POST" action="{{ url('/plannings/' . $planning->id) }}?redirect={{ $redirect }}&date={{ $date }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @else
                            <form method="POST" action="{{ url('/plannings/' . $planning->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @endif
                        
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('plannings.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
