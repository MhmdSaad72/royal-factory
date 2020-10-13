<?php

namespace App\Http\Controllers\API\Order;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Order;
use App\Material;
use App\Supplier;
use DB;
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
        $perPage = 10;

        if (!empty($keyword)) {
            $orders = Order::where('price', 'LIKE', "%$keyword%")
                ->orWhere('process_number', 'LIKE', "%$keyword%")
                ->orWhere('quantity', 'LIKE', "%$keyword%")
                ->orWhere('supplier_id', 'LIKE', "%$keyword%")
                ->orWhere('material_id', 'LIKE', "%$keyword%")
                ->orWhere('expire_date', 'LIKE', "%$keyword%")
                ->orWhereHas('material', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->orWhereHas('supplier', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->latest()->paginate($perPage);
        } else {
            $orders = Order::latest()->paginate($perPage);
        }
        if (!$orders) {
          return response()->json(['message'=>'Order Is Not found']);
        }

        // return view('admin.orders.index', compact('orders'));
        return response()->json($orders , 200);
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

        $validator = Validator::make($request->all(), [
          'process_number' => 'required|integer|unique:orders,process_number,NULL,id,deleted_at,NULL',
          'quantity'=>'required|integer|min:1',
          'price'=>'required|integer|min:1',
          'expire_date' => 'required|date|after:today',
          'material_id' => 'required',
          'supplier_id' => 'required',        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $order = Order::create($requestData);

        // return redirect('admin/orders')->with('flash_message', 'Order added!');
        return response()->json([
          'message' => 'Order Created Successfully'
          ] , 201);
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
        $order = Order::find($id);
        if (!$order) {
          return response()->json(['message'=>'Order Is Not found']);
        }

        // return view('admin.orders.show', compact('order'));
        return response()->json($order , 200);
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
        $order = Order::find($id);
        if (!$order) {
          return response()->json(['message'=>'Order Is Not found']);
        }
        $validator = Validator::make($request->all(), [
          'process_number' => 'required|integer|unique:orders,process_number,'.$order->id . ',id,deleted_at,NULL' ,
          'quantity'=>'required|integer|min:1',
          'price'=>'required|integer|min:1',
          'expire_date' => 'required|date|after:today',
          'material_id' => 'required',
          'supplier_id' => 'required',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $order->update($requestData);

        // return redirect('admin/orders')->with('flash_message', 'Order updated!');
        return response()->json([
          'message' => 'Order Updated Successfully'
          ] , 200);
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
        $order = Order::find($id);
        if (!$order) {
          return response()->json(['message'=>'Order Is Not found']);
        }
        $order = Order::destroy($id);

        // return redirect('admin/orders')->with('flash_message', 'Order deleted!');
        return response()->json([
          'message' => 'Order Deleted Successfully'
          ] , 200);
    }
}
