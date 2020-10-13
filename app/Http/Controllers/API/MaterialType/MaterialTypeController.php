<?php

namespace App\Http\Controllers\API\MaterialType;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\MaterialType;
use App\Material;
use Illuminate\Http\Request;

class MaterialTypeController extends Controller
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
            $materialtype = MaterialType::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $materialtype = MaterialType::latest()->paginate($perPage);
        }
        if (!$materialtype) {
          return response()->json(['message'=>'MaterialType Is Not found']);
        }

        // return view('admin.material-type.index', compact('materialtype'));
        return response()->json($materialtype , 200);
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
          'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:material_types,name,NULL,id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $materialType = MaterialType::create($requestData);

        // return redirect('admin/material-type')->with('flash_message', 'MaterialType added!');
        return response()->json(['message'=>'MaterialType Created Successfully'] , 201);
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
        $materialtype = MaterialType::find($id);
        if (!$materialtype) {
          return response()->json(['message'=>'MaterialType Is Not found']);
        }

        // return view('admin.material-type.show', compact('materialtype'));
        return response()->json($materialtype ,200);
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
        $materialtype = MaterialType::find($id);
        if (!$materialtype) {
          return response()->json(['message'=>'MaterialType Is Not found']);
        }
        $validator = Validator::make($request->all(), [
          'name'=>'required|regex:/^(?=.*?[A-Za-z])/|max:255|unique:materials,name,'.$materialtype->id . ',id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }
        $requestData = $request->all();
        $materialtype->update($requestData);

        // return redirect('admin/material-type')->with('flash_message', 'MaterialType updated!');
        return response()->json([
          'message' => 'MaterialType Updated Successfully'
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
      $materialType = MaterialType::find($id);
      if (!$materialType) {
        return response()->json(['message'=>'MaterialType Is Not found']);
      }
      $materialType = MaterialType::destroy($id);

        return response()->json(['message'=>'MaterialType Deleted Successfully'] , 200);
    }
}
