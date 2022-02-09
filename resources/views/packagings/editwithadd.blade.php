@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             Create New Packaging
        </h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <a href="{{ url('/packagings') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/packagings/editwithaddAction/'.$id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('packagings.formmany', ['formMode' => 'create'])

                        </form>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <form type="get" id="frmaddnewpackagetype" action="{{ url('/package-types/addnewpackage') }}">
        {!! Form::select('add-new-package-type', $packagetypelist2,null, ['class' => 'form-control caldate getorderlist getprice','placeholder' => '===Select===']) !!}      
        <input class="btn btn-primary form-group" type="button" id="btn-add-new-package-type" value="Add New Type">
    </form>
  </div>

</div>
                        <!-- Trigger/Open The Modal -->


            </div>
        </div>
    </div>
      <script src="{{ asset('js/package.js') }}" defer></script>
@endsection
