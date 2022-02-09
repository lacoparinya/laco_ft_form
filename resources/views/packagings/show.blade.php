@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Packaging #{{$packaging->id}}
        </h2>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 <a href="{{ url('/packagings') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/packagings/editwithadd/' . $packaging->id ) }}" title="Edit Packaging"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('packagings' . '/' . $packaging->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Packaging" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $packaging->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>สินค้า</th><td>{{ $packaging->product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Version</th><td>{{ $packaging->version }}</td>
                                    </tr>
                                    <tr>
                                        <th>รายละเอียด</th><td>{{ $packaging->desc }}</td>
                                    </tr>
                                    <tr>
                                        <th>เริ่มวันที่</th><td>{{ $packaging->start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>สินสุดวันที่</th><td>{{ $packaging->end_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>น้ำหนัก/ถุง (g.)</th><td>{{ number_format($packaging->inner_weight_g,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>จำนวนถุง/กล่อง</th><td>{{ $packaging->number_per_pack }}</td>
                                    </tr>
                                    <tr>
                                        <th>น้ำหนัก/กล่อง (kg.)</th><td>{{  number_format($packaging->outer_weight_kg,3,".",",") }}</td>
                                    </tr>
                                     <tr>
                                        <th>Package</th><td>
                                            @foreach ($packaging->package()->get() as $subitem)
                                               {{ $subitem->packagetype->name }} \ 
                                                    <a href="{{ url('packagings/showfile/'. $subitem->id) }}" target="_blank" >{{ $subitem->name }}</a> \ {{ $subitem->size }}     
                                                     @if (isset($packageexp[$subitem->id]))
                                                      \ วิธีการ Stamp : '{{ $packageexp[$subitem->id] }}'
                                                    @endif                                          
                                               <br/>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>เครื่อง Stamp</th><td>
                                            @foreach ($packaging->stamp()->get() as $subitem)
                                               {{ $subitem->name }}                                            
                                               <br/>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>เครื่อง Pack</th><td>
                                            @foreach ($packaging->packmachine()->get() as $subitem)
                                               {{ $subitem->name }}                                           
                                               <br/>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
    </div>
@endsection
