<?php

namespace App\Http\Controllers\MaterialType;

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
            $materialtype = MaterialType::orderBy('id','desc')->latest()->paginate($perPage);
            // $materialType = MaterialType::orderBy('id','asc')->latest()->paginate($perPage);
        }

        return view('admin.material-type.index', compact('materialtype'));
        // return response()->json($materialtype , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $materials = Material::all();
        return view('admin.material-type.create', compact('materials'));
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
          'name' => 'required|max:30|unique:material_types,name,NULL,id,deleted_at,NULL',
        ]);

        $requestData = $request->all();
        $materialType = MaterialType::create($requestData);

        return redirect('admin/material-type')->with('flash_message', __('translations.material_type_added'));
        // return response()->json($materialType , 201);
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
        $materialtype = MaterialType::findOrFail($id);

        return view('admin.material-type.show', compact('materialtype'));
        // return response()->json($materialtype ,200);
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
        $materialtype = MaterialType::findOrFail($id);
        $materials = Material::all();

        return view('admin.material-type.edit', compact('materialtype','materials'));
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
        $materialtype = MaterialType::findOrFail($id);
        $this->validate($request, [
          'name'=>'required|max:30|unique:materials,name,'.$materialtype->id . ',id,deleted_at,NULL',
        ]);

        $requestData = $request->all();
        $materialtype->update($requestData);

        return redirect('admin/material-type')->with('flash_message', __('translations.material_type_updated'));
        // return response()->json($materialtype, 200);
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
      $materialType = MaterialType::destroy($id);

        return redirect('admin/material-type')->with('flash_message', __('translations.material_type_deleted'));
        // return response()->json(NULL , 204);
    }
}
