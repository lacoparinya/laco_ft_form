@extends('layouts.app_packpaper')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ใบแจ้งบรรจุ</div>
                    <div class="card-body">
                        <div class="row">   
                            <form method="GET" action="{{ url('pack_papers') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">                            
                                <select id="search" name="search" class="form-control col-auto select_search" data-role="select-dropdown" onchange="myFunction(this.value,{{ $search }})">
                                    <option value="" @if(empty($search)) selected @endif>..ค้นหาสินค้า..</option>
                                    @foreach ($to_search as $key)
                                        <option value="{{ $key->packaging_id }}" @if($search==$key->packaging_id) selected @endif>{{ $key->name }}</option>
                                    @endforeach
                                </select>
                                <span class="col">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                                <a class="btn btn-success col to_search" href="{{ url('/pack_papers/generateOrder/'.$search.'/1') }}" id="new_pack">
                                    <i class="fa fa-plus"></i> Create
                                </a>                                
                            </form>
                        </div>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>สินค้า</th><th>Order</th><th>Revise</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($paperpacks as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->order_no }}</td>
                                        <td>@if(empty($item->revise_version)) {{ '0' }} @else{{ $item->revise_version }}@endif</td>
                                        <td>
                                            <a href="{{ url('/pack_papers/view/' . $item->id) }}" title="View Job"><button class="btn btn-info btn-sm"><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/pack_papers/edit_genOrder/' . $item->id . '/' . $item->packpaperdlots->count()) }}" title="Edit Job"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/pack_papers/delete/' . $item->id) }}" title="Delete"><button class="btn btn-danger btn-sm" onclick="return confirm('คุณต้องการลบรายการ {{ $item->name }} Order ที่ {{ $item->order_no }} ใช่มั้ย ?')"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button></a>
                                            {{-- <form method="POST" action="{{ url('/pack_papers/delete/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Job" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $paperpacks->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>    
    <script>
        $(".select_search").select2();        
    </script>
    <script type="text/javascript"> 
        function myFunction(a,b) {        
            console.log(a+'-'+b);
            if(a != b){
                console.log('F');                
                $('#new_pack').attr('disabled','disabled');
                // document.getElementById('new_pack').disabled = false;
            }else{
                console.log('T');
                $('#new_pack').removeAttr('disabled'); 
                // document.getElementById('new_pack').disabled = true;
            }
        }
        $(document).ready(function () {
            var search_val = "<?php echo $search; ?>";;
            console.log(search_val);
            if(search_val === ""){
                console.log('chk_t');
                $('#new_pack').attr('disabled','disabled');
                // document.getElementById('new_pack').style.visibility = 'visible';
            }else{
                console.log('chk_f');                  
                $('#new_pack').removeAttr('disabled');             
                // document.getElementById('new_pack').style.visibility = 'hidden';
            }
        });
    </script>
@endsection
