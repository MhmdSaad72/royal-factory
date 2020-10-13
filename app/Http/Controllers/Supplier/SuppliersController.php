<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Supplier;
use App\Material;
use App\Order;
use DB;
use Illuminate\Http\Request;

class SuppliersController extends Controller
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
            $suppliers = Supplier::where('name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%")
                ->orWhere('contact_type', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $suppliers = Supplier::latest()->paginate($perPage);
        }

        return view('admin.suppliers.index' , compact('suppliers'));

        // return response()->json($suppliers , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.suppliers.create');
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
       			'name' => 'required|max:30|unique:suppliers,name,NULL,id,deleted_at,NULL',
            // 'email' => 'email|unique:suppliers,email,NULL,id,deleted_at,NULL',
            'phone' => 'required|min:11|unique:suppliers,phone,NULL,id,deleted_at,NULL',
          	]);


        //$requestData = $request->all();

         Supplier::create([
            'name' =>$request->name ,
            'email' =>$request->email ,
            'phone' =>$request->phone ,
            'contact_type' =>$request->contact_type ,
          ]);

         return redirect()->route('suppliers.index')->with('flash_message', __('translations.supplier_added'));
         // return response()->json($supplier , 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request,$id)
    {
      $timestamp = time();
      $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
      $tm = $timestamp - ($thirty);
      $dt = $timestamp ;

      $lastDate = date("Y-m-d", $tm);
      $date = date("Y-m-d", $dt);

      $choosenDate = $request->get('choosen_date') ??  $lastDate;
      $currentDate = $request->get('current_date')  ?? $date ;
      $supplier = Supplier::findOrFail($id);
      $orders = Order::where('material_id' , $id)->whereBetween('created_at',[ $choosenDate . ' 00:00:00', $currentDate . ' 23:59:59'])->latest()->paginate(10);



      return view('admin.suppliers.show', compact('supplier' , 'choosenDate' , 'currentDate','lastDate','date' , 'orders'));
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
        $supplier = Supplier::findOrFail($id);

        return view('admin.suppliers.edit', compact('supplier'));
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

       $supplier = Supplier::findOrFail($id);
        $this->validate($request, [
          'name' => 'required|max:30|unique:suppliers,name,'.$supplier->id . ',id,deleted_at,NULL',
          // 'email' => 'email|unique:suppliers,email,'.$supplier->id . ',id,deleted_at,NULL',
          'phone' => 'required|min:11|unique:suppliers,phone,'.$supplier->id . ',id,deleted_at,NULL',
            	]);


      //  $requestData = $request->all();
        $supplier->update([
          'name'=>$request->name,
          'email'=>$request->email,
          'phone'=>$request->phone,
          'contact_type' =>$request->contact_type ,
        ]);

        return redirect('admin/suppliers')->with('flash_message', __('translations.supplier_updated'));
        // return response()->json($supplier , 200);
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
      $supplier = Supplier::destroy($id);

        return redirect('admin/suppliers')->with('flash_message', __('translations.supplier_deleted'));
        // return response()->json($supplier , 204);
    }
}
