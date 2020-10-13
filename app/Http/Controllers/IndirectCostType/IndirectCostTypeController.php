<?php

namespace App\Http\Controllers\IndirectCostType;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\IndirectCostType;
use App\IndirectCost;
use Illuminate\Http\Request;

class IndirectCostTypeController extends Controller
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
            $indirectcosttype = IndirectCostType::where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $indirectcosttype = IndirectCostType::latest()->paginate($perPage);
        }

        return view('admin.indirect-cost-type.index', compact('indirectcosttype'));
        // return response()->json($indirectcosttype, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.indirect-cost-type.create');
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
          'name'=>'required|max:30|unique:indirect_cost_types,name,NULL,id,deleted_at,NULL',
        ]);

        $requestData = $request->all();
        $indirectcosttype = IndirectCostType::create($requestData);

        return redirect('admin/indirect-cost-type')->with('flash_message', __('translations.indirect_cost_type_added'));
        // return response()->json($indirectcosttype , 201);
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
        $indirectcosttype = IndirectCostType::findOrFail($id);

        return view('admin.indirect-cost-type.show', compact('indirectcosttype'));
        // return response()->json($indirectcosttype ,200);
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
         $indirectcosttype = IndirectCostType::findOrFail($id);

        return view('admin.indirect-cost-type.edit', compact('indirectcosttype'));
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

       $indirectcosttype = IndirectCostType::findOrFail($id);
        $this->validate($request, [
          'name'=>'required|max:30|unique:indirect_cost_types,name,'.$indirectcosttype->id.',id,deleted_at,NULL',
        ]);

        $requestData = $request->all();
        $indirectcosttype->update($requestData);

        return redirect('admin/indirect-cost-type')->with('flash_message', __('translations.indirect_cost_type_updated'));
        // return response()->json($indirectcosttype , 200);
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
        $indirectcosttype = IndirectCostType::destroy($id);

        return redirect('admin/indirect-cost-type')->with('flash_message', __('translations.indirect_cost_type_deleted'));
        // return response()->json($indirectcosttype , 204);
    }
}
