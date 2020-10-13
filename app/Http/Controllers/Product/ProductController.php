<?php

namespace App\Http\Controllers\Product;

use App\Product;
use DB;
use App\Outcome;
use App\Store;
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
       return view('admin.product.index' , compact('products'));
   }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
       return view('admin.product.create');
   }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request)
   {
      $this->validate($request, [
        'name' => 'required|max:30|unique:products,name,NULL,id,deleted_at,NULL',
      ]);

       $requestData = $request->all();
       $product = Product::create($requestData);

       return redirect('admin/products')->with('flash_message', __('translations.product_added'));
   }

  /**
   * Display the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
   public function showOutcomes(Request $request,$id)
   {
     $timestamp = time();
     $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
     $tm = $timestamp - ($thirty);
     $dt = $timestamp ;
     $perPage = 10;

     $lastDate = date("Y-m-d", $tm);
     $date = date("Y-m-d", $dt);

     $choosenDate = $request->get('choosen_date') ??  $lastDate;
     $currentDate = $request->get('current_date')  ?? $date ;
     $product = Product::findOrFail($id);
     $outcomesId = DB::table('outcome_product')->where('product_id',$id)->pluck('outcome_id');
     $outcomes = Outcome::whereIn('id',$outcomesId)->whereBetween('created_at',[ $choosenDate . ' 00:00:00' , $currentDate . ' 23:59:59'])->latest()->paginate($perPage);

     return view('admin.product.outcomes', compact('product' , 'choosenDate' , 'currentDate','lastDate','date','outcomes'));

   }

   public function showStores(Request $request,$id)
   {
       $timestamp = time();
       $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
       $tm = $timestamp - ($thirty);
       $dt = $timestamp ;

       $perPage= 10;

       $lastDate = date("Y-m-d", $tm);
       $date = date("Y-m-d", $dt);

       $choosenDate = $request->get('choosen_date') ??  $lastDate;
       $currentDate = $request->get('current_date')  ?? $date ;
       $product = Product::findOrFail($id);
       $storesId = DB::table('store_product')->where('product_id',$id)->pluck('store_id');
       $stores = Store::whereIn('id',$storesId)->whereBetween('created_at',[ $choosenDate . ' 00:00:00' , $currentDate . ' 23:59:59'])->latest()->paginate($perPage);

       return view('admin.product.stores', compact('product' , 'choosenDate' , 'currentDate','lastDate','date' , 'stores'));
   }
   public function api($id)
   {
       $product = Product::findOrFail($id);
       $out = $product->hasOutcome();
       $outcomes = [];
       $quantity = [];
       foreach ($out as $value) {
         if ($value->remainQuantityOutcome($id,$value->process_number ) > 0) {
           $outcomes[] = $value->process_number;
           $quantity[] = $value->remainQuantityOutcome($id,$value->process_number );
         }
       }

       // $quantity = $product->remainingQuantity($id);

       return response()->json([
         'outcomes'  => $outcomes,
         'quantity' =>$quantity
         ] , 200);
   }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
       $product = Product::findOrFail($id);

       return view('admin.product.edit', compact('product'));
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
       $product = Product::findOrFail($id);
      $this->validate($request, [
        'name' => 'required|max:30|unique:products,name,'.$product->id . ',id,deleted_at,NULL',
      ]);

       $requestData = $request->all();
       $product->update($requestData);

       return redirect('admin/products/')->with('flash_message', __('translations.product_updated'));
       // return response()->json($product , 200);
   }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
   public function destroy($id)
   {
       $product = Product::destroy($id);

       return redirect('admin/products/')->with('flash_message', __('translations.product_deleted'));
       // return response()->json($product , 204);
   }

// product movements
   public function productMovement(Request $request,$id){
     $timestamp = time();
     $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
     $tm = $timestamp - ($thirty);
     $dt = $timestamp ;

     $lastDate = date("Y-m-d", $tm);
     $date = date("Y-m-d", $dt);

     $choosenDate = $request->get('choosen_date') . " 00:00:00" ??  $lastDate;
     $currentDate = $request->get('current_date') . "23:59:59" ?? $date ;
     $product = Product::findOrFail($id);
     return view('admin.product.movement', compact('product','choosenDate' , 'currentDate','lastDate','date'));
   }

}
