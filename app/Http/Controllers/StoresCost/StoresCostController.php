<?php

namespace App\Http\Controllers\StoresCost;

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

        return view('admin.stores-cost.index', compact('storescost'));
        // return response()->json($storescost , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
       $storesCostTypes = StoresCostType::all();
       $stores = Store::all();
        return view('admin.stores-cost.create' , compact('storesCostTypes', 'stores'));
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
          'price' => 'required|integer|min:1|digits_between:1,5',
          'store_id' => 'required',
          'stores_cost_type_id' =>'required',
          'reason' => 'max:500',
        ]);

        $requestData = $request->all();
        $storesCost = StoresCost::create($requestData);

        return redirect('admin/stores-cost')->with('flash_message', __('translations.stores_cost_added'));
        // return response()->json($storesCost , 201);
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
        $storescost = StoresCost::findOrFail($id);

        return view('admin.stores-cost.show', compact('storescost'));
        // return response()->json($storescost , 200);
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
        $storescost = StoresCost::findOrFail($id);
        $storesCostTypes = StoresCostType::all();
        $stores = Store::all();

        return view('admin.stores-cost.edit', compact('storescost','storesCostTypes','stores'));
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
        $this->validate($request, [
          'price' => 'required|integer|min:1|digits_between:1,5',
          'store_id' => 'required',
          'stores_cost_type_id' =>'required',
          'reason' => 'max:500',
        ]);

        $requestData = $request->all();

        $storescost = StoresCost::findOrFail($id);
        $storescost->update($requestData);

        return redirect('admin/stores-cost')->with('flash_message', __('translations.stores_cost_updated'));
        // return response()->json($storescost , 200);
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
        $storesCost = StoresCost::destroy($id);

        return redirect('admin/stores-cost')->with('flash_message', __('translations.stores_cost_deleted'));
        // return response()->json($storesCost , 204);
    }
}
