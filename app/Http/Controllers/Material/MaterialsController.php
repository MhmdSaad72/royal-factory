<?php

namespace App\Http\Controllers\Material;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Material;
use App\MaterialType;
use App\Order;
use DB;
use App\Outcome;
use Illuminate\Http\Request;

class MaterialsController extends Controller
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
           $mt = new Material();
            $materials = Material::where('name', 'LIKE', "%$keyword%")
                ->orWhere('quantity_type' ,'LIKE',  $mt->getQuantityType(strtolower($keyword)))
                ->orWhere('type' ,'LIKE',  $mt->getType(strtolower($keyword)))
                ->orWhere('material_type_id', 'LIKE', "%$keyword%")
                ->orWhereHas('material_type', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->latest()->paginate($perPage);
        } else {
          $materials = Material::latest()->paginate($perPage);
        }
        return view('admin.materials.index' , compact('materials'));

        // return view('admin.materials.index', compact('materials'));
        // return response()->json($materials , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       // $suppliers = Supplier::all();
       $materialTypes = MaterialType::all();
        return view('admin.materials.create' , compact('materialTypes'));
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
        'name'=>'required|max:30|unique:materials,name,NULL,id,deleted_at,NULL',
        'max_order'=>'required|integer|digits_between:0,6|min:1',
        'type'=>'required',
        'material_type_id'=>'required',
        'quantity_type'=>'required',
      ]);

        $material =   Material::create([
          'name' =>$request->name ,
          'max_order' =>$request->max_order ,
          'type' =>$request->type ,
          'quantity_type' =>$request->quantity_type ,
          'material_type_id'=>$request->material_type_id,
        ]);


        return redirect()->route('materials.index')->with('flash_message', __('translations.material_added'));
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
      $material = Material::findOrFail($id);
      $orders = Order::where('material_id' , $id)->whereBetween('created_at',[ $choosenDate . ' 00:00:00', $currentDate . ' 23:59:59'])->latest()->paginate(10);


      return view('admin.materials.show', compact('material' , 'choosenDate' , 'currentDate','lastDate','date','orders'));
    }

    public function api($id)
    {
        $material = Material::findOrFail($id);
        $ord = $material->hasOrdersDetaisl();
        $orders = [];
        $quantity = [];
        foreach ($ord as $value) {
          if ($value->remainQuantityOrder($id ,$value->process_number ) > 0) {
            $orders[] = $value->process_number;
            $quantity[] = $value->remainQuantityOrder($id , $value->process_number);
          }
        }

        // $quantity = $material->remainingQuantity($id);

        return response()->json([
          'orders'   =>$orders,
          'quantity' =>$quantity
          ] , 200);
        // return response()->json($material , 200);
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
        $material = Material::findOrFail($id);
        $materialTypes =MaterialType::all();
        return view('admin.materials.edit', compact('material','materialTypes'));
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
        $material = Material::findOrFail($id);
        $this->validate($request, [
          'name'=>'required|max:30|unique:materials,name,'.$material->id . ',id,deleted_at,NULL',
          'max_order'=>'required|integer|digits_between:0,6|min:1',
          'type'=>'required',
          'material_type_id'=>'required',
          'quantity_type'=>'required',
        ]);

        $material->update([
          'name'=>$request->name,
    			'max_order' => $request->max_order,
          'type'=> $request->type,
          'quantity_type' =>$request->quantity_type,
          'material_type_id'=>$request->material_type_id,
        ]);


        return redirect('admin/materials')->with('flash_message', __('translations.material_updated'));
        // return response()->json($material, 200);
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
        $material = Material::destroy($id);

        return redirect('admin/materials')->with('flash_message', __('translations.material_deleted'));
        // return response()->json($material ,204);
    }

//////// Related Outcomes ////////
    public function showOutcomes(Request $request,$id){
      $timestamp = time();
      $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
      $tm = $timestamp - ($thirty);
      $dt = $timestamp ;

      $perPage = 10 ;

      $lastDate = date("Y-m-d", $tm);
      $date = date("Y-m-d", $dt);

      $choosenDate = $request->get('choosen_date')  ??  $lastDate;
      $currentDate = $request->get('current_date')  ?? $date ;
      $material = Material::findOrFail($id);
      $outcomesId = DB::table('material_outcome')->where('material_id',$id)->pluck('outcome_id');
      $outcomes = Outcome::whereIn('id',$outcomesId)->whereBetween('created_at',[ $choosenDate . ' 00:00:00' , $currentDate . ' 23:59:59'])->latest()->paginate($perPage);

      return view('admin.materials.outcomes', compact('material' , 'choosenDate' , 'currentDate','lastDate','date', 'outcomes' ));
    }

////// Max Order Materials ////
    public function maxOrder(){
      $perPage = 10;
      $materials = Material::latest()->paginate($perPage);
      // $mat = new Material();
      return view('admin.materials.max_order' , compact('materials'));
    }
// Materials Movement
  public function materialMovement(Request $request,$id){
    $timestamp = time();
    $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
    $tm = $timestamp - ($thirty);
    $dt = $timestamp ;

    $lastDate = date("Y-m-d", $tm);
    $date = date("Y-m-d", $dt);

    $choosenDate = $request->get('choosen_date') . " 00:00:00" ??  $lastDate;
    $currentDate = $request->get('current_date') . "23:59:59" ?? $date ;

    $material = Material::findOrFail($id);
    return view('admin.materials.movement', compact('material','choosenDate' , 'currentDate','lastDate','date','orders'));
  }

}
