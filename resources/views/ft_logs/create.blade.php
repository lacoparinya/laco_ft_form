@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>เพิ่มข้อมูล งานคัด  <a href="{{ url('/ft_logs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                    </h3></div>
                    <div class="card-body">
                       
                        <form method="POST" action="{{ url('/ft_logs') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('ft_logs.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
