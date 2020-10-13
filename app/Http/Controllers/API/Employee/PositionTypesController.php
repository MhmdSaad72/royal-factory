<?php

namespace App\Http\Controllers\API\Employee;

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
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $positiontypes = PositionType::latest()->paginate($perPage);
        }
        if (!$positiontypes) {
          return response()->json(['message'=>'PositionType Is Not found']);
        }

        // return view('admin.position-types.index', compact('positiontypes'));
        return response()->json($positiontypes , 200);
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
          'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:position_types,name,Null,id,deleted_at,Null',
          'description' =>'max:500',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $positionType =   PositionType::create($requestData);

        // return redirect('admin/position-types')->with('flash_message', 'PositionType added!');
        return response()->json([
          'message'=>'PositionType Created Successfully',
          ] , 201);
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
        $positiontype = PositionType::find($id);
        if (!$positiontype) {
          return response()->json(['message'=>'PositionType Is Not found']);
        }

        // return view('admin.position-types.show', compact('positiontype'));
        return response()->json($positiontype, 200);
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
        if (!$positionType) {
          return response()->json(['message'=>'PositionType Is Not found']);
        }
        $validator = Validator::make($request->all(), [
          'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:position_types,name,'.$positiontype->id . ',id,deleted_at,NULL',
          'description' =>'max:500',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }
        $requestData = $request->all();
        $positiontype->update($requestData);

        // return redirect('admin/position-types')->with('flash_message', 'PositionType updated!');
        return response()->json([
          'message'=>'PositionType Updated Successfully' ,
          'position_type' =>$positiontype,
        ] , 200);
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
        $positionType = PositionType::find($id);

        if (!$positionType) {
          return response()->json(['message'=>'PositionType Is Not found']);
        }
        PositionType::destroy($id);
        return response()->json([
             'message' => 'PositionType Deleted Successfully',
              'position_type' => $positionType] ,200);
    }
}
