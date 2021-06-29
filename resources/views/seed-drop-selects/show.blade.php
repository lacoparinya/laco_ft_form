@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">ถั่วตกไลน์คัด # {{ $seeddropselect->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/seed-drop-selects') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/seed-drop-selects/' . $seeddropselect->id . '/edit') }}" title="Edit seeddropselect"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('seed-drop-selects' . '/' . $seeddropselect->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete seeddropselect" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $seeddropselect->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>กะ</th>
                                        <td>{{ $seeddropselect->shift->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Check Date</th>
                                        <td>{{ $seeddropselect->check_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>ประเภท</th>
                                        <td>{{ $seeddropselect->material }}</td>
                                    </tr>
                                    <tr>
                                        <th>RM Input (KG.)</th>
                                        <td>{{ number_format($seeddropselect->input_w,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>RM Output (KG.)</th>
                                        <td>{{ number_format($seeddropselect->output_w,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>Incline Machine/Man (KG.)</th>
                                        <td>{{ number_format($seeddropselect->incline_a,2,".",",") }} / {{ number_format($seeddropselect->incline_m,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>สายพานรับถั่วจาก Recheck Machine/Man (KG.)</th>
                                        <td>{{ number_format($seeddropselect->beltrecheck_a,2,".",",") }} / {{ number_format($seeddropselect->beltrecheck_m,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>สายพานลำเลียงถั่วเข้า Auto weight Machine/Man (KG.)</th>
                                        <td>{{ number_format($seeddropselect->beltautoweight_a,2,".",",") }} / {{ number_format($seeddropselect->beltautoweight_m,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>ใต้สายพานไลน์คัด "ของตกเกรด" Machine/Man (KG.)</th>
                                        <td>{{ number_format($seeddropselect->underbelt_a,2,".",",") }} / {{ number_format($seeddropselect->underbelt_m,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Machine/Man (KG.)</th>
                                        <td>{{ number_format($seeddropselect->total_a,2,".",",") }} / {{ number_format($seeddropselect->total_m,2,".",",") }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th><td>{{ $seeddropselect->note }}</td>
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
