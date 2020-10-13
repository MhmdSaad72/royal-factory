<?php

namespace App\Http\Controllers\StoresCostType;

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
                ->latest()->paginate($perPage);
        } else {
            $storescosttype = StoresCostType::latest()->paginate($perPage);
        }

        return view('admin.stores-cost-type.index', compact('storescosttype'));
        // return response()->json($storescosttype , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
      $storesCosts = StoresCost::all();
        return view('admin.stores-cost-type.create', compact('storesCosts'));
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
        'name' => 'required|max:30|unique:stores_cost_types,name,NULL,id,deleted_at,NULL'
      ]);

        $requestData = $request->all();
        $storesCostType = StoresCostType::create($requestData);

        return redirect('admin/stores-cost-type')->with('flash_message', __('translations.stores_cost_type_added'));
        // return response()->json($storesCostType , 201);
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
        $storescosttype = StoresCostType::findOrFail($id);

        return view('admin.stores-cost-type.show', compact('storescosttype'));
        // return response()->json($storescosttype , 200);
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
        $storescosttype = StoresCostType::findOrFail($id);
        $storesCosts = StoresCost::all();

        return view('admin.stores-cost-type.edit', compact('storescosttype', 'storesCosts'));
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
         $storescosttype = StoresCostType::findOrFail($id);
          $this->validate($request, [
            'name' => 'required|max:30|unique:stores_cost_types,name,'. $storescosttype->id . ',id,deleted_at,NULL',
          ]);

        $requestData = $request->all();
        $storescosttype->update($requestData);

        return redirect('admin/stores-cost-type')->with('flash_message', __('translations.stores_cost_type_updated'));
        // return response()->json($storescosttype , 200);
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
        $storesCostType = StoresCostType::destroy($id);

        return redirect('admin/stores-cost-type')->with('flash_message', __('translations.stores_cost_type_deleted'));
        // return response()->json($storesCostType , 204);
    }
}
