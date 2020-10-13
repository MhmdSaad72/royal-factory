<?php

namespace App\Http\Controllers\API\Outcome;

use App\Outcome;
use App\Material;
use App\Order;
use App\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OutcomeController extends Controller
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
             $outcomes = Outcome::where('process_number', 'LIKE', "%$keyword%")
                 ->latest()->paginate($perPage);
         } else {
             $outcomes = Outcome::latest()->paginate($perPage);
         }

         // return view('admin.outcome.index', compact('outcomes'));
         if (!$outcomes) {
           return response()->json(['message'=>'Outcome Is Not found']);
         }
         return response()->json($outcomes , 200);
     }
    /**
     * Display the specified resource.
     *
     * @param  \App\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
         $outcome = Outcome::find($id);
         if (!$outcome) {
           return response()->json(['message'=>'Outcome Is Not found']);
         }
         return response()->json($outcome , 200);
     }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
     {

            $outcome = Outcome::find($id);
             if (!$outcome)
             {
               // Customize Error Message For undefined Id
               return response()->json(['message' => 'Outcome Id  Not Found'] ,404);
             }

              $validator = Validator::make($request->all(), [
                'process_number' => 'required|integer|unique:outcomes,process_number,'.$outcome->id . ',id,deleted_at,NULL',
              ]);

              if ($validator->fails()) {
                     return response()->json($validator->errors() ,400);
                 }
                  $outcome->update([
                    'process_number' => $request->process_number ,
                  ]);
                  $outcome->materials()->detach();
                  $material_id = $request->material_id;
                  $count = count($material_id);
                  $quantity = $request->quantity;
                  for ($i=0; $i <$count ; $i++) {
                    $outcome->materials()->attach($material_id[$i] , ['quantity' => $quantity[$i]]);
                  }
                 return response()->json(['message' => 'Outcome Updated Successfully'] , 200);

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
         $outcome = Outcome::find($id);
         if (!$outcome) {
           return response()->json(['message'=>'Outcome Is Not found']);
         }
         $outcome = Outcome::destroy($id);

         // return redirect('admin/outcomes/')->with('flash_message', 'Outcome deleted!');
         return response()->json(['message'=>'Outcome Deleted Successfully'] , 200);
     }

     public function store(Request $request){

            $validator = Validator::make($request->all(), [
              'process_number' => 'required|integer|unique:outcomes,process_number,NULL,id,deleted_at,NULL',
            ]);

            if ($validator->fails()) {
                   return response()->json($validator->errors() ,400);
               }

            $outcome = Outcome::create([
              'process_number' => $request->process_number ,
            ]);


            $material_id = $request->material_id;
            $count = count($material_id);
            $quantity = $request->quantity;

              for ($i=0; $i <$count ; $i++) {
                $outcome->materials()->attach($material_id[$i] , ['quantity' => $quantity[$i]]);
                }
             return response()->json(['message'=>'Outcome Created Successfully'] , 201);

     }

     // Create Page For Products And Quantity Related To Process Number

     public function createProduct($id)
     {
         $outcome = Outcome::findOrFail($id);
         $products = Product::all();
         return view('admin.outcome-products.create', compact('outcome','products'));
     }

     // Create Method For Products And Quantity Related To Process Number

     public function storeProduct(Request $request){

         $outcomeId = $request->outcome_id;
         $product_id = $request->product_id;
         $count = count($product_id);
         $quantity = $request->quantity;
         $outcome = Outcome::find($outcomeId);

           for ($i=0; $i <$count ; $i++) {
             $outcome->products()->attach($product_id[$i] , ['quantity' => $quantity[$i]]);
             }
          return response()->json(['message'=>'Products Created Successfully For Outcome'] , 201);
   }
   // Edit Page For Products And Quantity Related To Process Number
   public function editProduct($id){
     $products = Product::all();
     $outcome = Outcome::findOrFail($id);
     return view('admin.outcome-products.edit', compact('products','outcome'));
   }
  /// Update Method For Products And Quantity Related To Process Number
  public function updateProduct(Request $request , $id)
  {

          $product_id = $request->product_id;
          $count = count($product_id);
          $quantity = $request->quantity;
          $outcome = Outcome::find($id);
          $outcome->products()->detach();
          for ($i=0; $i <$count ; $i++) {
            $outcome->products()->attach($product_id[$i] , ['quantity' => $quantity[$i]]);
          }
         return response()->json(['message' => 'Product Updated Successfully'] , 200);

  }

  public function showProduct($id)
  {
      $outcome = Outcome::find($id);
      if (!$outcome) {
        return response()->json(['message'=>'Outcome Id Is Not found']);
      }
      $products =  $outcome->products;
       return response()->json($products , 200);
  }
}
