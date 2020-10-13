<?php

namespace App\Http\Controllers\Order;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Exports\OrderPeriodExport;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Order;
use App\Material;
use App\Supplier;
use Carbon\Carbon;
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
            $orders = Order::where('quantity', 'LIKE', "%$keyword%")
                ->orWhere('process_number', 'LIKE', "%$keyword%")
                // ->orWhere('price', 'LIKE', "%$keyword%")
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

        return view('admin.orders.index', compact('orders'));
        // return response()->json($orders , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $materials = Material::all();
        $suppliers = Supplier::all();
        return view('admin.orders.create' , compact('materials' , 'suppliers'));
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

          $this->validate($request, [
            'process_number' => 'required|integer|digits_between:0,6|unique:orders,process_number,NULL,id,deleted_at,NULL',
            'quantity'=>'required|integer|digits_between:0,6|min:1',
            // 'price'=>'required|integer|digits_between:0,6|min:1',
            'expire_date' => 'required|date|after:today',
            'material_id' => 'required',
            'supplier_id' => 'required',
          ]);

        $requestData = $request->all();
        $order = Order::create($requestData);

        return redirect('admin/orders')->with('flash_message', __('translations.order_added'));
        // return response()->json($order , 201);
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

        return view('admin.orders.show', compact('order'));
        // return response()->json($order , 200);
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
        $materials = Material::all();
        $suppliers = Supplier::all();

        return view('admin.orders.edit', compact('order', 'materials' , 'suppliers'));
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
        $order = Order::findOrFail($id);
        $this->validate($request, [
          'process_number' => 'required|integer|unique:orders,process_number,'.$order->id . ',id,deleted_at,NULL' ,
          'quantity'=>'required|integer|min:1',
          // 'price'=>'required|integer|min:1',
          'expire_date' => 'required|date|after:today',
          'material_id' => 'required',
          'supplier_id' => 'required',
        ]);

        $requestData = $request->all();
        $order->update($requestData);

        return redirect('admin/orders')->with('flash_message', __('translations.order_updated'));
        // return response()->json($order , 200);
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
        $order = Order::destroy($id);

        return redirect('admin/orders')->with('flash_message', __('translations.order_deleted'));
        // return response()->json($order , 204);
    }


  //////////////////////// Cancel Functions ////////////////
  public function showCancel($id){
    $order = Order::findOrFail($id);
    $orders = Order::all();
    return view('admin.orders.cancel' , compact('order','orders'));
  }

  public function orderCancel(Request $request , $id){
    $order = Order::findOrFail($id);
    $this->validate($request, [
      'cancel_reason' => 'required',
    ]);
    $order->update([
      'cancel_reason' => $request->cancel_reason,
    ]);

    return redirect('admin/orders')->with('flash_message', __('translations.order_canceled'));

  }

/////////////////// show canceled orders //////////////////
  public function reportsCanceledOrders(Request $request){
    $keyword = $request->get('search');
    $perPage = 10;

    if (!empty($keyword)) {
        $orders = Order::whereNotNull('cancel_reason')
          ->where(function($query) use ($keyword){
              $query->where('quantity', 'LIKE', "%$keyword%")
              ->orWhere('process_number', 'LIKE', "%$keyword%")
              // ->orWhere('price', 'LIKE', "%$keyword%")
              ->orWhere('supplier_id', 'LIKE', "%$keyword%")
              ->orWhere('material_id', 'LIKE', "%$keyword%")
              ->orWhere('expire_date', 'LIKE', "%$keyword%")
              ->orWhereHas('material', function ($query) use ($keyword) {
              $query->where('name', 'LIKE', "%$keyword%");})
              ->orWhereHas('supplier', function ($query) use ($keyword) {
              $query->where('name', 'LIKE', "%$keyword%");})
            ;})
            ->latest()->paginate($perPage);
    } else {
      $orders = Order::whereNotNull('cancel_reason')
                       ->latest()->paginate($perPage);
    }

    return view('admin.orders.all_canceled' , compact('orders'));
  }


  //// Within the expire date /////
  public function expireDateOrders(Request $request){
    $timestamp = time();
    $thirty = 86400 * 30 *3; // 60 * 60 * 24 = 86400 = 1 day in seconds
    $tm = $timestamp + ($thirty);
    $dt = $timestamp ;

    $nextDate = date("Y-m-d", $tm);
    $date = date("Y-m-d", $dt);

    $keyword = $request->get('search');
    $perPage = 10;

    if (!empty($keyword)) {
        $orders = Order::whereNull('cancel_reason')
            ->where(function($query) use ($keyword){
              $query->where('quantity', 'LIKE', "%$keyword%")
              ->orWhere('process_number', 'LIKE', "%$keyword%")
              ->orWhere('supplier_id', 'LIKE', "%$keyword%")
              ->orWhere('material_id', 'LIKE', "%$keyword%")
              ->orWhere('expire_date', 'LIKE', "%$keyword%")
              ->orWhereHas('material', function ($query) use ($keyword) {
              $query->where('name', 'LIKE', "%$keyword%");})
              ->orWhereHas('supplier', function ($query) use ($keyword) {
              $query->where('name', 'LIKE', "%$keyword%");})
            ;})
            ->latest()->paginate($perPage);
    } else {

      $orders = Order::whereNull('cancel_reason')->whereBetween('expire_date',[ $date . ' 00:00:00' , $nextDate . ' 23:59:59'])->paginate($perPage);
    }

       return view ('admin.orders.expire_date' , compact('orders'));
  }

  /////////////////// Reports Functions /////////////////
  public function showReports(Request $request){

       $timestamp = time();
       $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
       $tm = $timestamp - ($thirty);
       $dt = $timestamp ;

       $lastDate = date("Y-m-d", $tm);
       $date = date("Y-m-d", $dt);

       $perPage=10;

       $choosenDate = $request->get('choosen_date') ??  $lastDate;
       $currentDate = $request->get('current_date') ?? $date ;

       $orders = Order::whereNull('cancel_reason')->whereBetween('created_at',[ $choosenDate . ' 00:00:00' , $currentDate . ' 23:59:59'])->latest()->paginate($perPage);
       return view('admin.orders.reports' , compact('orders' , 'lastDate' , 'date'));
  }

  // all expired orders
    public function expiredOrders(Request $request){

      $keyword = $request->get('search');
      $perPage = 10;

      if (!empty($keyword)) {
          $orders = Order::whereNull('cancel_reason')->where('expire_date' , '<',Carbon::now())
              ->where(function($query) use ($keyword){
                $query->where('quantity', 'LIKE', "%$keyword%")
                ->orWhere('process_number', 'LIKE', "%$keyword%")
                // ->orWhere('price', 'LIKE', "%$keyword%")
                ->orWhere('supplier_id', 'LIKE', "%$keyword%")
                ->orWhere('material_id', 'LIKE', "%$keyword%")
                ->orWhere('expire_date', 'LIKE', "%$keyword%")
                ->orWhereHas('material', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->orWhereHas('supplier', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ;})
              ->latest()->paginate($perPage);
      } else {
        $date = date("Y-m-d H:i:s");
        $orders = Order::whereNull('cancel_reason')->where('expire_date' , '<' ,$date )->paginate($perPage);
      }
      return view('admin.orders.expired' , compact('orders'));
    }

// export functions
    public function export()
    {
            return Excel::download(new OrderExport, 'الطلبيات.xlsx');
    }

}
