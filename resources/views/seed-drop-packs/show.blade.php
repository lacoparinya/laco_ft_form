@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ถั่วตกไลน์แพ๊ค # {{ $seeddroppack->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/seed-drop-packs') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/seed-drop-packs/' . $seeddroppack->id . '/edit') }}" title="Edit seeddroppack"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('seed-drop-packs' . '/' . $seeddroppack->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete seeddroppack" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $seeddroppack->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>วิธี</th><td>{{ $seeddroppack->method->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>กะ</th><td>{{ $seeddroppack->shift->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check Date</th><td>{{ $seeddroppack->check_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>บริเวณลากกระบะ (KG.)</th><td>{{ number_format($seeddroppack->cabin,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>สายพานจุดปล่อยถั่ว (KG.)</th><td>{{ number_format($seeddroppack->belt_start,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>สายพาน Intralox / โครง Z (KG.)</th><td>{{ number_format($seeddroppack->belt_Intralox,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>หัวชั่ง (KG.)</th><td>{{ number_format($seeddroppack->weight_head,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>Shaker (KG.)</th><td>{{ number_format($seeddroppack->shaker,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>ในเครื่องบรรจุ (KG.)</th><td>{{ number_format($seeddroppack->pack_part,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>โต๊ะบรรจุ (KG.)</th><td>{{ number_format($seeddroppack->table,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $seeddroppack->note }}</td>
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
