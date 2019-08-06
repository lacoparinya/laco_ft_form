@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><div class="row">
                        <div class="col-md-6">
<h3>  <a href="{{ url('/orders/createDetail/'.$order->id) }}" class="btn btn-success btn-sm" title="Add New Order">
                            <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> Add New
                        </a> Order : {{ $order->order_no }}</h3>
</div>
<div class="col-md-6">
<h3>Loading Date : {{ $order->loading_date }}</h3>
</div>
<div class="col-md-12">
Note : {{ $order->note }}
</div>
</div>
</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Method</th>
                                        <th>Package</th>
                                        <th>Total Packs</th>
                                        <th>Total Kgs</th>
                                        <th>Note</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderdetail as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->method->name }}</td>
                                        <td>{{ $item->package->name }}</td>
                                        <td>{{ $item->total_pack }}</td>
                                        <td>{{ $item->total_kg }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>
                                            <a href="{{ url('/orders/editDetail/' . $item->id ) }}" title="Edit Order"><button class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Edit</button></a>
                                            <a href="{{ url('/orders/deleteDetail/' . $item->id .'/'. $item->order_id ) }}" title="Delete Order"><button class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i> Delete</button></a>
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
