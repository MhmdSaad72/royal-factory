<?php

namespace App\Http\Controllers\API\StoresCostType;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\StoresCostType;
use App\StoresCost;
use Illuminate\Http\Request;

class StoresCostTypeController extends Controller
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
            $storescosttype = StoresCostType::where('name', 'LIKE', "%$keyword%")
                ->orWhere('stores_cost_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $storescosttype = StoresCostType::latest()->paginate($perPage);
        }

        if (!$storescosttype)
        {
          return response()->json(['message' => 'StoresCostType Not Found'] ,404);
        }

        // return view('admin.stores-cost-type.index', compact('storescosttype'));
        return response()->json($storescosttype , 200);
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
        'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:stores_cost_types,name,NULL,id,deleted_at,NULL'
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }

        $requestData = $request->all();
        $storesCostType = StoresCostType::create($requestData);

        // return redirect('admin/stores-cost-type')->with('flash_message', 'StoresCostType added!');
        return response()->json(['message'=>'StoresCostType Created Successfully'] , 201);
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
        $storescosttype = StoresCostType::find($id);
        if (!$storescosttype)
        {
          return response()->json(['message' => 'StoresCostType Not Found'] ,404);
        }

        // return view('admin.stores-cost-type.show', compact('storescosttype'));
        return response()->json($storescosttype , 200);
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
         $storescosttype = StoresCostType::find($id);
         if (!$storescosttype)
         {
           return response()->json(['message' => 'StoresCostType Not Found'] ,404);
         }
          $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:stores_cost_types,name,'. $storescosttype->id . ',id,deleted_at,NULL',
          ]);

          if ($validator->fails()) {
                 return response()->json($validator->errors() ,400);
             }

        $requestData = $request->all();
        $storescosttype->update($requestData);

        // return redirect('admin/stores-cost-type')->with('flash_message', 'StoresCostType updated!');
        return response()->json(['message'=>'StoresCostType Updated Successfully'] , 200);
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
        $storesCostType = StoresCostType::find($id);
        if (!$storesCostType)
        {
          return response()->json(['message' => 'StoresCostType Not Found'] ,404);
        }
        StoresCostType::destroy($id);

        // return redirect('admin/stores-cost-type')->with('flash_message', 'StoresCostType deleted!');
        return response()->json(['message'=>'StoresCostType Deleted Successfully'] , 200);
    }
}
