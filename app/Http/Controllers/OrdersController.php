<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Order;
use App\Method;
use App\Package;
use App\OrderDetail;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $orders = Order::latest()->paginate($perPage);
        } else {
            $orders = Order::latest()->paginate($perPage);
        }

        return view( 'orders.index', compact( 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view( 'orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Order::create($requestData);

        return redirect( 'orders')->with('flash_message', ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view( 'orders.show', compact( 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        return view( 'orders.edit', compact( 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();

        $order = Order::findOrFail($id);
        $order->update($requestData);

        return redirect( 'orders')->with('flash_message', ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Order::destroy($id);

        return redirect( 'orders')->with('flash_message', ' deleted!');
    }

    public function listDetail($order_id){

        $order = Order::findOrFail($order_id);

        return view('orders.list-detail', compact('order'));
    }

    public function createDetail($order_id){
        $order = Order::findOrFail($order_id);
        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::where('status', 'Active')->orderBy('name', 'asc')->pluck('name', 'id');
        return view('orders.create-detail', compact('order','methodlist', 'packagelist'));
    }

    public function storeDetail(Request $request, $order_id)
    {

        $requestData = $request->all();

        OrderDetail::create($requestData);

        return redirect('orders/listDetail/'.$order_id)->with('flash_message', ' added!');
    }

    public function editDetail($id)
    {
        $orderdetail = OrderDetail::findOrFail($id);
        $order = Order::findOrFail($orderdetail->order_id);
        $methodlist = Method::pluck('name', 'id');
        $packagelist = Package::where('status', 'Active')->orderBy('name', 'asc')->pluck('name', 'id');
        return view('orders.edit-detail', compact('order', 'methodlist', 'packagelist', 'orderdetail'));
    }

    public function updateDetail(Request $request, $id)
    {

        $requestData = $request->all();

        $orderdetail = OrderDetail::findOrFail($id);
        $orderdetail->update($requestData);

        return redirect('orders/listDetail/' . $orderdetail->order_id)->with('flash_message', ' updated!');
    }

    public function deleteDetail($id,$order_id){

        OrderDetail::destroy($id);

        return redirect('orders/listDetail/' . $order_id)->with('flash_message', ' deleted!');
    }
}
