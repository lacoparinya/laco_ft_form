@extends('layouts.app')

@section('content')
<div class="container">
    <div class='row'>
        <div class="col-md-12">
                <div class="card">
                <div class="card-header"><h3>Main วันที่ {{ $date }}</h3></div>
                    <div class="card-body">
                        <h4>งานฟรีส</h4>
                        <div class="col-md-12">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Process Date</th>
                                        <th>งาน</th>
                                        <th>Input วัตถุดิบ</th>
                                        <th>เป้าkgต่อชม.</th>
                                        <th>เป้าจำนวน ชม.</th>
                                        <th>IQF 1 + 2</th>
                                        <th>IQF 3</th>
                                        <th>Total</th>
                                        <th>คงเหลือ</th>
                                        <th>จำนวนชม.</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rawfreezedata as $item)
                                        <tr>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ number_format($item->start_RM,2,".",",") }}</td>
                                        <td>{{ number_format($item->targets,2,".",",") }}</td>
                                        <td>{{ $item->target_hr }}</td>
                                        <td>{{ number_format($item->IQF1_2,2,".",",") }}</td>
                                        <td>{{ number_format($item->IQF_3,2,".",",") }}</td>
                                        <td>{{ number_format($item->SUM_Total,2,".",",") }}</td>
                                        <td>{{ number_format($item->Remain,2,".",",") }}</td>
                                        <td>{{ round($item->actual_hour,2) }}</td>
                                        <td>{{ $item->status }}</td>
                                        </tr>    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h4>งานเตรียมการ</h4>
                        <div class="col-md-12">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Process Date</th>
                                        <th>สินค้า</th>
                                        <th>เป้าสินค้า</th>
                                        <th>เป้าชม.</th>
                                        <th>อัตราต่อชม</th>
                                        <th>Input/Output</th>
                                        <th>คนเตรียมการ/IQF</th>
                                        <th>จำนวนคงเหลือ</th>
                                        <th>เวลาที่เหลือ</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rawpreparedata as $item)
                                    <tr>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->target_result }}</td>
                                        <td>{{ $item->target_workhours }}</td>
                                        <td>{{ $item->targetperhr }}</td>
                                        <td>{{ $item->input }} / {{ $item->output }}</td>
                                        <td>{{ $item->numpre }} / {{ $item->numiqf }}</td>
                                        <td>{{ $item->remain }}</td>
                                        <td>{{ $item->remainhr }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h4>งานคัด</h4>
                        <div class="col-md-12">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Process Date</th>
                                        <th>สินค้า</th>
                                        <th>เป้าสินค้า</th>
                                        <th>เป้าชม.</th>
                                        <th>อัตราต่อชม</th>
                                        <th>Input/Output/Yeild%</th>
                                        <th>คนคัด</th>
                                        <th>จำนวนคงเหลือ</th>
                                        <th>เวลาที่เหลือ</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rawselectdata as $item)
                                    <tr>
                                        <td>{{ $item->process_date }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->targetperday }}</td>
                                        <td>{{ $item->hourperday }}</td>
                                        <td>{{ number_format($item->std_rate,2,".",",") }}</td>
                                        <td>{{ $item->sum_kg_input }} / {{ $item->sum_kg_output }} / {{ number_format($item->avg_yeild*100,2,".",",")}}</td>
                                        <td>{{ $item->avg_selected }} </td>
                                        <td>{{ $item->difftraget }}</td>
                                        <td>{{ $item->diffhour }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h4>งานแพ็ค</h4>
                        <div class="col-md-12">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Process Date / กะ</th>
                                        <th>Order / วิธีการ <br/>/ สินค้า</th>
                                        <th>เป้าสินค้า</th>
                                        <th>เป้าชม.</th>
                                        <th>อัตราต่อชม</th>
                                        <th>Input/Output/Pack</th>
                                        <th>Yeild</th>
                                        <th>คนคัด</th>
                                        <th>จำนวนคงเหลือ</th>
                                        <th>เวลาที่เหลือ</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rawpackdata as $item)
                                    <tr>
                                        <td>{{ $item->process_date }} / {{ $item->shift_name }}</td>
                                        <td>{{ $item->order_no }} / {{ $item->methode_name }} <br/>/ {{ $item->package_name }}</td>
                                        <td>{{ $item->targetperday }}</td>
                                        <td>{{ $item->hourperday }}</td>
                                        <td>{{ number_format($item->avg_productivity,2,".",",") }}</td>
                                        <td>{{ $item->sum_input_kg }} / {{ $item->sum_output_kg }} / {{ $item->sum_output_pack }}</td>
                                        <td>{{ number_format($item->yeild,2,".",",")}}</td>
                                        <td>{{ number_format($item->avg_numpack,0,".",",") }}</td>
                                        <td>{{ $item->difftarget }}</td>
                                        <td>{{ $item->diffhour }}</td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection