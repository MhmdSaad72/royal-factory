<?php

namespace App\Http\Controllers\API\Product;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index(Request $request)
   {
       $keyword = $request->get('search');
       $perPage = 10;

       if (!empty($keyword)) {
           $products = Product::where('name', 'LIKE', "%$keyword%")
               ->latest()->paginate($perPage);
       } else {
           $products = Product::latest()->paginate($perPage);
       }
       if (!$products) {
         return response()->json(['message'=>'Product Is Not found']);
       }


       // return view('admin.product.index', compact('products'));
       return response()->json($products , 200);
   }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {

      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:products,name,NULL,id,deleted_at,NULL',
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }

       $requestData = $request->all();
       $product = Product::create($requestData);

       // return redirect('admin/products')->with('flash_message', 'Product added!');
       return response()->json(['message' => 'Product Created Successfully'] , 201);
   }

  /**
   * Display the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
   public function show($id)
   {
       $product = Product::find($id);
       if (!$product) {
         return response()->json(['message'=>'Product Is Not found']);
       }

       // return view('admin.product.show', compact('product'));
       return response()->json($product , 200);
   }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Product  $outcome
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {
       $product = Product::find($id);
       if (!$product) {
         return response()->json(['message'=>'Product Is Not found']);
       }
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:products,name,'.$product->id . ',id,deleted_at,NULL',
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }
       $requestData = $request->all();
       $product->update($requestData);

       // return redirect('admin/products/')->with('flash_message', 'Product updated!');
       return response()->json([
         'message' => 'Product Updated Successfully'
         ] , 200);
   }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
       $product = Product::find($id);
       if (!$product) {
         return response()->json(['message'=>'Product Is Not found']);
       }
       $product = Product::destroy($id);

       // return redirect('admin/products/')->with('flash_message', 'Product deleted!');

       return response()->json(['message'=>'Product Deleted Successfully'] , 200);
   }
}
