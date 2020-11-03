@extends('layouts.appweight')

@section('content')
<div class="container">
    <div class='row'>
        <div class="col-md-12">
                <div class="card">
                <div class="card-header"><h3>Weight วันที่ {{ $date }}</h3></div>
                    <div class="row">
                    <div class="form-group col-md-3 {{ $errors->has('process_datetime') ? 'has-error' : ''}}">
        <label for="process_datetime" class="control-label">{{ 'วัน-เวลา' }}</label>
        <input class="form-control" name="process_datetime" type="date" id="process_datetime" 
                    value = "{{$date}}" >
        {!! $errors->first('process_datetime', '<p class="help-block">:message</p>') !!}
    </div></div>
                    <div class="card-body">
                        <h4>กล่องล่าสุด</h4>
                        <div class="col-md-12">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Process Date</th>
                                        <th>ลูกค้า</th>
                                        <th>สินค้า</th>
                                        <th>น้ำหนัก</th>
                                        <th>เลขข้างกล่อง 1</th>
                                        <th>เลขข้างกล่อง 1</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                        <td>{{ $last->datetime }}</td>
                                        <td>{{ $last->cus_name }}</td>
                                        <td>{{ $last->prod_name }}</td>
                                        <td>{{ $last->weight_st }} / {{ $last->weight_read }} / {{ $last->weight_check }}</td>
                                        <td>{{ $last->code1_st }} / {{ $last->code1_read }} / {{ $last->code1_check }}</td>
                                        <td>{{ $last->code2_st }} / {{ $last->code2_read }} / {{ $last->code2_check }}</td>
                                        <td>{{ $last->overall_status }}</td>
                                        </tr>    
                                </tbody>
                            </table>
                        </div>
                        <h4>สรุปวันที่ {{ $date }}</h4>
                        <div class="col-md-12">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>ลูกค้า</th>
                                        <th>สินค้า</th>
                                        <th>OK</th>
                                        <th>NG</th>
                                        <th>NC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $prod_name=>$item1)
                                    @foreach ($item1 as $cus_name=>$item2)
                                    <tr>
                                        <td>{{ $cus_name }}</td>
                                        <td>{{ $prod_name }}</td>
                                        <td>@if (isset($item2['OK']))
                                            {{ $item2['OK'] }}
                                        @else
                                            0
                                        @endif</td>
                                        
                                        <td>@if (isset($item2['NG']))
                                            {{ $item2['NG'] }}
                                        @else
                                            0
                                        @endif</td>
                                        <td>@if (isset($item2['NC']))
                                            {{ $item2['NC'] }}
                                        @else
                                            0
                                        @endif</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   setTimeout(function(){
       location.reload();
   },10000);
</script>
@endsection