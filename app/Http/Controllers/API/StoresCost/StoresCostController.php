<?php

namespace App\Http\Controllers\API\StoresCost;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\StoresCost;
use App\StoresCostType;
use App\Store;
use Illuminate\Http\Request;

class StoresCostController extends Controller
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
            $storescost = StoresCost::where('store_id', 'LIKE', "%$keyword%")
                ->orWhere('stores_cost_type_id', 'LIKE', "%$keyword%")
                ->orWhere('price', 'LIKE', "%$keyword%")
                ->orWhere('reason', 'LIKE', "%$keyword%")
                ->orWhereHas('storesCostTypes', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->orWhereHas('store', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->latest()->paginate($perPage);
        } else {
            $storescost = StoresCost::latest()->paginate($perPage);
        }
        if (!$storescost)
        {
          return response()->json(['message' => 'StoresCost Not Found'] ,404);
        }

        // return view('admin.stores-cost.index', compact('storescost'));
        return response()->json($storescost , 200);
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
          'price' => 'required|integer|min:1|digits_between:1,5',
          'store_id' => 'required',
          'stores_cost_type_id' =>'required',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $storesCost = StoresCost::create($requestData);

        // return redirect('admin/stores-cost')->with('flash_message', 'StoresCost added!');
        return response()->json(['message'=>'StoresCost Created Successfully'] , 201);
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
        $storescost = StoresCost::find($id);
        if (!$storescost)
        {
          return response()->json(['message' => 'StoresCost Not Found'] ,404);
        }

        // return view('admin.stores-cost.show', compact('storescost'));
        return response()->json($storescost , 200);
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
        $validator = Validator::make($request->all(), [
          'price' => 'required|integer|min:1|digits_between:1,5',
          'store_id' => 'required',
          'stores_cost_type_id' =>'required',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }
        $requestData = $request->all();

        $storescost = StoresCost::find($id);
        if (!$storescost)
        {
          return response()->json(['message' => 'StoresCost Not Found'] ,404);
        }
        $storescost->update($requestData);

        // return redirect('admin/stores-cost')->with('flash_message', 'StoresCost updated!');
        return response()->json(['message'=>'StoreCost Updated Successfully'] , 200);
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
        $storesCost = StoresCost::find($id);
        if (!$storescost)
        {
          return response()->json(['message' => 'StoresCost Not Found'] ,404);
        }
        StoresCost::destroy($id);

        // return redirect('admin/stores-cost')->with('flash_message', 'StoresCost deleted!');
        return response()->json(['message'=>'StoresCost Deleted Successfully'] , 200);
    }
}
