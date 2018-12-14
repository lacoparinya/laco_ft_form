@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>แก้ไขข้อมูล #{{ $ft_log->id }} <a href="{{ url('/ft_logs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/ft_logs/' . $ft_log->id . '/edit') }}" title="Edit ft_log"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a></h3></div>
                    <div class="card-body">

                        <form method="POST" action="{{ url('ft_logs' . '/' . $ft_log->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete ft_log" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $ft_log->id }}</td>
                                    
                                        <th>วันที่ผลิต</th><td> {{ $ft_log->process_date }} </td>
                                    </tr>
                                    <tr>
                                        <th>เวลาที่ผลิต</th><td> {{ date('H:i',strtotime($ft_log->process_time)) }} </td>
                                    
                                        <th>คัดผลิตภัณท์</th><td> {{ $ft_log->product->name }} </td>
                                    </tr>
                                    <tr>
                                        <th>กะ</th><td> {{ $ft_log->shift->name }} </td>
                                   
                                        <th> Input (kg) </th><td>{{ $ft_log->input_kg }}</td>
                                    </tr>
                                    <tr>
                                        <th> Output (kg) </th><td>{{ $ft_log->output_kg }}</td>
                                   
                                        <th> สะสม (kg) </th><td>{{ $ft_log->sum_kg }}</td>
                                    </tr>
                                    <tr>
                                        <th> Yeild (%) </th><td>{{ $ft_log->yeild_percent }}</td>
                                    
                                        <th> PK </th><td>{{ $ft_log->num_pk }}</td>
                                    </tr>
                                    <tr>
                                        <th> PF </th><td>{{ $ft_log->num_pf }}</td>
                                    
                                        <th> PST </th><td>{{ $ft_log->num_pst }}</td>
                                    </tr>
                                    <tr>
                                        <th> คัด </th><td>{{ $ft_log->num_classify }}</td>
                                    
                                        <th> Line A </th><td>{{ $ft_log->line_a }}</td>
                                    </tr>
                                    <tr>
                                        <th> Line B </th><td>{{ $ft_log->line_b }}</td>
                                    
                                        <th> Line คัด </th><td>{{ $ft_log->line_classify }} {{$ft_log->classifyunit->name}}</td>
                                    </tr>
                                    <tr>
                                        <th> หมายเหตุ </th><td>{{ $ft_log->note }}</td><th>  </th><td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
