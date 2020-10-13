<?php

namespace App\Http\Controllers\API\Material;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Material;
use App\MaterialType;
use DB;
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
          $keywordType = $request->type;
            $materials = Material::where('name', 'LIKE', "%$keyword%")
                ->orWhere('quantity_type', 'LIKE', "%$keyword%")
                ->orWhere('expire_date', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhere('material_type_id', 'LIKE', "%$keyword%")
                ->orWhereHas('material_type', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->latest()->paginate($perPage);
        } else {
            $materials = Material::latest()->paginate($perPage);
        }
        if (!$materials) {
          return response()->json(['message'=>'Material Is Not found']);
        }


        // return view('admin.materials.index', compact('materials'));
        return response()->json($materials , 200);
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
        'name'=>'required|regex:/^(?=.*?[A-Za-z])/|max:255|unique:materials,name,NULL,id,deleted_at,NULL',
        'expire_date' => 'required|date|after:today',
        'type'=>'required',
        'material_type_id'=>'required',
        'quantity_type'=>'required',
      ]);

    if ($validator->fails()) {
           return response()->json($validator->errors() ,400);
       }

        $material =   Material::create([
          'name' =>$request->name ,
          'expire_date' =>$request->expire_date ,
          'type' =>$request->type ,
          'quantity_type' =>$request->quantity_type ,
          'material_type_id'=>$request->material_type_id,
        ]);


        // return redirect()->route('materials.index')->with('flash_message', 'Material added!');
        return response()->json(['message'=> 'Material Is Created Successfully'] ,201 );
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
        $material = Material::find($id);
        if (!$material) {
          return response()->json(['message'=>'Material Is Not found']);
        }

        // return view('admin.materials.show', compact('material'));
        return response()->json($material , 200);
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
        $material = Material::find($id);
        if (!$material) {
          return response()->json(['message'=>'Material Is Not found']);
        }
        $validator = Validator::make($request->all(), [
          'name'=>'required|regex:/^(?=.*?[A-Za-z])/|max:255|unique:materials,name,'.$material->id . ',id,deleted_at,NULL',
          'expire_date' => 'required|date|after:today',
          'type'=>'required',
          'material_type_id'=>'required',
          'quantity_type'=>'required',
        ]);

    if ($validator->fails()) {
           return response()->json($validator->errors() ,400);
       }

        $material->update([
          'name'=>$request->name,
    			'expire_date' => $request->expire_date,
          'type'=> $request->type,
          'quantity_type' =>$request->quantity_type,
          'material_type_id'=>$request->material_type_id,
        ]);


        // return redirect('admin/materials')->with('flash_message', 'Material updated!');
        return response()->json([
          'message'=> 'Material Updated Successfully'
        ], 200);
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
        $material = Material::find($id);
        if (!$material) {
          return response()->json(['message'=>'Material Is Not found']);
        }
        $material = Material::destroy($id);

        return response()->json(['message' => 'Material Deleted Successfully'] ,200);
    }

}
