@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">LogPackM {{ $logpackm->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/log-pack-ms') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/log-pack-ms/' . $logpackm->id . '/edit') }}" title="Edit LogPackM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        @if ($logpackm->status == 'Active' )
                          <a href="{{ url('/log-pack-ms/createDetail/' . $logpackm->id ) }}" title="Add Details"><button class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add</button></a>
                        @endif
                        <br/>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="id">ID</label>
                                {{ $logpackm->id }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Date</label>
                                {{ $logpackm->process_date }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">วิธี</label>
                                {{ $logpackm->method->name }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">สินค้า</label>
                                {{ $logpackm->package->name }} / {{ $logpackm->package->kgsperpack }}
                            </div>
                             <div class="col-md-3">
                                <label for="id">Order</label>
                                {{ $logpackm->order->order_no }} /
                                {{ $logpackm->order->loading_date }} /
                                {{ $logpackm->order->total_pack }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ยอดรวมของสินค้านี้</label>
                                {{ $logpackm->overalltargets }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">ยอดที่ต้องผลิดได้ต่อวัน</label>
                                {{ $logpackm->targetperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวน ชม. ที่ทั้งหมดใช้ผลิตสินค้านี้</label>
                                {{ $logpackm->houroverall }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวน ชม. ต่อวันที่ผลิตสินค้านี้</label>
                                {{ $logpackm->hourperday }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">จำนวน Package รวมที่แพ็คแล้ว</label>
                                {{ $sumoutputpack }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">รวมจำนวน Input (kg)</label>
                                {{ $suminputkg }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">รวมจำนวน Output (kg)</label>
                                {{ $sumoutputkg }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">รายการ</label>
                                {{ $logpackm->logpackd->count() }}
                            </div>
                            <div class="col-md-3">
                                <label for="id">Status</label>
                                {{ $logpackm->status }}
                            </div>
                            <div class="col-md-6">
                                <label for="id">Note</label>
                                {{ $logpackm->Note }}
                            </div>
                        </div>
                     

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Time</th>
                                        <th rowspan="2">ชม.</th>
                                        <th colspan="2">ผล</th>
                                        <th colspan="2">สะสม</th>
                                        <th rowspan="2">Yeild / Productivity</th>
                                        <th rowspan="2">Note</th>
                                        <th rowspan="2"></th>
                                    </tr>
                                     <tr>
                                        <th>Input/Output</th>
                                        <th>Output Package</th>
                                        <th>Input/Output</th>
                                        <th>Output Package</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logpackm->logpackd()->orderBy('process_datetime')->get() as $item)
                                    <tr>
                                        <td>{{ date('H:i',strtotime($item->process_datetime)) }}</td>
                                        <td>{{ $item->workhours }}</td>
                                        <td>{{ $item->input_kg }} / {{ $item->output_kg }}</td>
                                        <td>{{ $item->output_pack }}</td>
                                        <td>{{ $item->input_kg_sum }} / {{ $item->output_kg_sum }}</td>
                                        <td>{{ $item->output_pack_sum }}</td>
                                        <td>{{ round($item->yeild_percent,2) }} / {{ round($item->productivity,2) }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td><a href="{{ url('/log-pack-ms/editDetail/' . $item->id) }}" title="Edit FreezeM"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/log-pack-ms/deleteDetail/' . $item->id . '/'. $item->log_pack_m_id) }}" title="Delete FreezeM"><button class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
                                       </td>
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
