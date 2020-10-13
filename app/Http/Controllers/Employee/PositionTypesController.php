<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\PositionType;
use Illuminate\Http\Request;

class PositionTypesController extends Controller
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
            $positiontypes = PositionType::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $positiontypes = PositionType::latest()->paginate($perPage);
        }

        return view('admin.position-types.index', compact('positiontypes'));
        // return response()->json($positiontypes , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.position-types.create');
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
          'name' => 'required|max:30|unique:position_types,name,Null,id,deleted_at,Null',
          'description' =>'max:500',
        ]);

        $requestData = $request->all();
        $positionType =   PositionType::create($requestData);

        return redirect('admin/position-types')->with('flash_message', __('translations.position_type_added'));
        // return response()->json($positionType , 201);
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
        $positiontype = PositionType::findOrFail($id);

        return view('admin.position-types.show', compact('positiontype'));
        // return response()->json($positiontype, 200);
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
        $positiontype = PositionType::findOrFail($id);

        return view('admin.position-types.edit', compact('positiontype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id )
    {
        $positiontype = PositionType::findOrFail($id);
        $this->validate($request, [
          'name' => 'required|max:30|unique:position_types,name,'.$positiontype->id . ',id,deleted_at,NULL',
          'description' =>'max:500',
        ]);

        $requestData = $request->all();
        $positiontype->update($requestData);

        return redirect('admin/position-types')->with('flash_message', __('translations.position_type_updated'));
        // return response()->json($positiontype , 200);
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
        $positionType = PositionType::destroy($id);

        return redirect('admin/position-types')->with('flash_message', __('translations.position_type_deleted'));
        // return response()->json($positionType , 204);
    }
}
