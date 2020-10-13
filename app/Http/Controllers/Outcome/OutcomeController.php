<?php

namespace App\Http\Controllers\Outcome;

use App\Outcome;
use App\Material;
use App\Order;
use App\Product;
use DB;
use App\Exports\OutcomeExport;
use Maatwebsite\Excel\Facades\Excel;

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

         return view('admin.outcome.index', compact('outcomes'));
         // return response()->json($outcomes , 200);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
         $mat = Order::pluck('material_id');
         $materials = Material::whereIn('id' , $mat)->get();

         return view('admin.outcome.create',compact('materials'));
     }


    /**
     * Display the specified resource.
     *
     * @param  \App\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
         $outcome = Outcome::findOrFail($id);

         return view('admin.outcome.show', compact('outcome'));
         // return response()->json($outcome , 200);
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
     {
         $outcome = Outcome::findOrFail($id);
         $materials = Material::all();

         return view('admin.outcome.edit', compact('outcome','materials'));
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

         $count = $_POST['count'] ?? '';
         $outcome = Outcome::findOrFail($id);
              $validator = $this->validate($request, [
                'process_number' => 'required|integer|unique:outcomes,process_number,'.$outcome->id . ',id,deleted_at,NULL',
              ]);

              if ($validator) {
                $outcome->materials()->detach();
                $outcome->update([
                  'process_number' => $_POST['process_number'] ,
                ]);

                for ($i=1; $i <=$count ; $i++) {
                  ${'material' . $i} = $request->{'material_id'.$i};

                  ${'quantity' . $i} = $request->{'quantity'.$i};


                 //Update Material Id Related To Outcome in Pivot Table

                 $outcome->materials()->attach(${'material' . $i} , ['quantity' => ${'quantity' . $i}]);
               }
              }


         return redirect('admin/outcomes/')->with('flash_message', __('translations.outcome_updated'));
         // return response()->json($outcome , 200);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Outcome  $outcome
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
         $outcome = Outcome::destroy($id);

         return redirect('admin/outcomes/')->with('flash_message', __('translations.outcome_deleted'));
         // return response()->json($outcome , 204);
     }

     public function store(Request $request){


            $validator = $this->validate($request, [
              'process_number' => 'required|integer|unique:outcomes,process_number,NULL,id,deleted_at,NULL',
            ]);

            $count = $request->count ?? '';
            $materials = [];
            for ($i=1; $i <=$count; $i++) {
              $materials[] = $request->{'material_id'.$i};
            }


            if (!empty($materials) && count($materials) == $count) {

              // $mat = new Material();
              $ord = new Order();
              $outcome = Outcome::create([
                'process_number' => $_POST['process_number'] ,
              ]);
              for ($i=1; $i <=$count ; $i++) {
                ${'material' . $i} = $request->{'material_id'.$i};
                ${'order_number' . $i} = $request->{'order_number'.$i};
                ${'quantity' . $i} = $request->{'quantity'.$i};



                ${'materialQuantities' . $i} = $ord->remainQuantityOrder(${'material' . $i},${'order_number' . $i});
                if (${'quantity' . $i} <= ${'materialQuantities' . $i}) {

                  $outcome->materials()->attach(${'material' . $i} , ['quantity' => ${'quantity' . $i} , 'order_number' => ${'order_number' . $i}]);

                }else {
                  $outcome->materials()->detach();
                  $outcome->delete();
                  return redirect()->back()->withInput()->with('flash_message', __('translations.quantity_more_available'));
                }
             }
        return redirect('admin/outcomes')->with('flash_message', __('translations.outcome_added'));
        }else{
          return redirect()->back()->withInput()->with('flash_message',__('translations.please_choose_material'));
        }
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
       //Get Outcome Id
       $outcomeId = $request->outcome;
       $outcome = Outcome::findOrFail($outcomeId);
       // Get Number Of (Products , Quantity) in Form
       $count = $request->count ?? '';

       for ($i=1; $i <=$count ; $i++) {
         ${'product' . $i} = $request->{'product_id'.$i};
         ${'quantity' . $i} = $request->{'quantity'.$i};

        //Attach Material Id Related To Outcome in Pivot Table
        $outcome->products()->attach(${'product' . $i} , ['quantity' => ${'quantity' . $i}]);
     }
     return redirect()->route('outcomes.index')->with('flash_message', __('translations.outcome_product_added'));
     // return response()->json($outcome , 201);
   }
   // Edit Page For Products And Quantity Related To Process Number
   public function editProduct($id){
     $products = Product::all();
     $outcome = Outcome::findOrFail($id);
     return view('admin.outcome-products.edit', compact('products','outcome'));
   }
  /// Update Method For Products And Quantity Related To Process Number
  public function updateProduct(Request $request, $id)
  {
           $count = $request->count ?? 0 ;

          $outcome = Outcome::findOrFail($id);
          $outcome->products()->detach();
          if ($count == 0) {
              $outcome->products()->detach();

          }else {

            for ($i=1; $i <=$count ; $i++) {
              ${'product' . $i} = $request->{'product_id'.$i} ?? null;
              ${'quantity' . $i} = $request->{'quantity'.$i} ?? null;

             //Update Product Id Related To Outcome in Pivot Table

             $outcome->products()->attach(${'product' . $i} , ['quantity' => ${'quantity' . $i}]);
             // $outcome->products()->sync(${'product' . $i} , ['quantity' => ${'quantity' . $i}] );
              }

          }

       return redirect('admin/outcomes/')->with('flash_message', __('translations.outcome_product_updated'));
       // return response()->json($outcome , 200);
  }

  public function showProduct($id)
  {
      $outcome = Outcome::findOrFail($id);

      return view('admin.outcome-products.show', compact('outcome'));
      // return response()->json($outcome , 200);
  }

  //////////////////////// Cancel Functions ////////////////
  public function showCancel($id){
    $outcome = Outcome::findOrFail($id);
    return view('admin.outcome.cancel' , compact('outcome'));
  }

  public function outcomeCancel(Request $request , $id){
    $outcome = Outcome::findOrFail($id);
    $this->validate($request, [
      'cancel_reason' => 'required',
    ]);
    $outcome->update([
      'cancel_reason' => $request->cancel_reason,
    ]);

    return redirect('admin/outcomes')->with('flash_message', __('translations.outcome_canceled'));

  }

  /////////////////// Reports Functions /////////////////
  public function showReports(Request $request){

             $timestamp = time();
             $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
             $tm = $timestamp - ($thirty);
             $dt = $timestamp ;

             $lastDate = date("Y-m-d", $tm);
             $date = date("Y-m-d", $dt);

             $perPage = 10;

          $choosenDate = $request->get('choosen_date') ??  $lastDate;
          $currentDate = $request->get('current_date') ?? $date ;

          // $outcomes = Outcome::all();
         $outcomes = Outcome::whereNull('cancel_reason')->whereBetween('created_at',[ $choosenDate . ' 00:00:00' , $currentDate . ' 23:59:59'])->latest()->paginate($perPage);
    return view('admin.outcome.reports' , compact('outcomes' , 'lastDate' , 'date'));
  }

  public function reportsCanceledOutcomes(Request $request){

    $keyword = $request->get('search');
    $perPage = 10;

    if (!empty($keyword)) {
        $outcomes = Outcome::whereNotNull('cancel_reason')
                          ->where(function($query) use ($keyword){
                            $query->where('process_number', 'LIKE', "%$keyword%")
                            ->orWhereHas('materials', function ($query) use ($keyword) {
                            $query->where('name', 'LIKE', "%$keyword%")
                                   ->orWhere('quantity' , 'LIKE' , "%$keyword%");})
                            ->orWhereHas('products', function ($query) use ($keyword) {
                            $query->where('name', 'LIKE', "%$keyword%")
                                  ->orWhere('quantity' , 'LIKE' , "%$keyword%");})
                            ;})

            ->latest()->paginate($perPage);
    } else {
      $outcomes = Outcome::whereNotNull('cancel_reason')
                           ->latest()->paginate($perPage);
    }

    return view('admin.outcome.all_canceled' , compact('outcomes'));
  }
// export function
    public function export()
    {
            return Excel::download(new OutcomeExport, 'الانتاج.xlsx');
    }

}
