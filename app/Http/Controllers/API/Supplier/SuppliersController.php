<?php

namespace App\Http\Controllers\API\Supplier;

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
        if (!$suppliers)
        {
          return response()->json(['message' => 'Supplier Not Found'] ,404);
        }

        // return view('admin.suppliers.index', compact('suppliers'));
        return response()->json($suppliers , 200);
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
        'name' => 'required|max:255|unique:suppliers,name,NULL,id,deleted_at,NULL',
        'email' => 'required|email|unique:suppliers,email,NULL,id,deleted_at,NULL',
        'phone' => ['required','min:11','unique:suppliers,phone,NULL,id,deleted_at,NULL'],
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }

        //$requestData = $request->all();

        $supplier = Supplier::create([
            'name' =>$request->name ,
            'email' =>$request->email ,
            'phone' =>$request->phone ,
            'contact_type' =>$request->contact_type ,
          ]);

         // return redirect()->route('suppliers.index')->with('flash_message', 'Supplier added!');
         return response()->json(['message'=>'Supplier Created Successfully'] , 201);
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
        $supplier = Supplier::find($id);
        if (!$supplier)
        {
          return response()->json(['message' => 'Supplier Not Found'] ,404);
        }

        // return view('admin.suppliers.show', compact('supplier'));
        return response()->json($supplier , 200);
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

       $supplier = Supplier::find($id);
       if (!$supplier)
       {
         return response()->json(['message' => 'Supplier Not Found'] ,404);
       }
        $validator = Validator::make($request->all(), [
          'name' => 'required|max:255|unique:suppliers,name,'.$supplier->id . ',id,deleted_at,NULL',
          'email' => 'required|email|unique:suppliers,email,'.$supplier->id . ',id,deleted_at,NULL',
          'phone' => 'required|min:11|unique:suppliers,phone,'.$supplier->id . ',id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

      //  $requestData = $request->all();
        $supplier->update([
          'name'=>$request->name,
          'email'=>$request->email,
          'phone'=>$request->phone,
          'contact_type' =>$request->contact_type ,
        ]);

        // return redirect('admin/suppliers')->with('flash_message', 'Supplier updated!');
        return response()->json(['message'=>'Supplier Updated Successfully'] , 200);
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
      $supplier = Supplier::find($id);
      if (!$supplier)
      {
        return response()->json(['message' => 'Supplier Not Found'] ,404);
      }
      Supplier::destroy($id);

        // return redirect('admin/suppliers')->with('flash_message', 'Supplier deleted!');
        return response()->json(['message'=>'Supplier Deleted Successfully'] , 200);
    }
}
