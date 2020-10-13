<?php

namespace App\Http\Controllers\IndirectCost;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\IndirectCost;
use App\IndirectCostType;
use Illuminate\Http\Request;

class IndirectCostController extends Controller
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
            $indirectcost = IndirectCost::where('price', 'LIKE', "%$keyword%")
                ->orWhere('reason', 'LIKE', "%$keyword%")
                ->orWhere('indirect_cost_type_id', 'LIKE', "%$keyword%")
                ->orWhereHas('indirect_cost_types', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->latest()->paginate($perPage);
        } else {
            $indirectcost = IndirectCost::latest()->paginate($perPage);
        }

        return view('admin.indirect-cost.index', compact('indirectcost'));
        // return response()->json($indirectcost , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $indirectCostTypes = IndirectCostType::all();
        return view('admin.indirect-cost.create' , compact('indirectCostTypes'));
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
          'price'=>'required|integer|min:1|digits_between:1,5',
          'indirect_cost_type_id'=>'required',
          'reason' => 'max:500',
        ]);

        $requestData = $request->all();
        $indirectcost = IndirectCost::create($requestData);

        return redirect('admin/indirect-cost')->with('flash_message', __('translations.indirect_cost_added'));
        // return response()->json($indirectcost , 201);
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
        $indirectcost = IndirectCost::findOrFail($id);
        $indirectCostTypes = IndirectCostType::all();

        return view('admin.indirect-cost.show', compact('indirectcost' , 'indirectCostTypes'));
        // return response()->json(['indirectcost'=>$indirectcost, 'indirectCostTypes'=>$indirectCostTypes] , 200);
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
        $indirectcost = IndirectCost::findOrFail($id);
        $indirectCostTypes = IndirectCostType::all();

        return view('admin.indirect-cost.edit', compact('indirectcost' , 'indirectCostTypes'));
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
          'price'=>'required|integer|min:1|digits_between:1,5',
          'indirect_cost_type_id'=>'required',
          'reason' => 'max:500',
        ]);

        $requestData = $request->all();
        $indirectcost = IndirectCost::findOrFail($id);
        $indirectcost->update($requestData);

        return redirect('admin/indirect-cost')->with('flash_message', __('translations.indirect_cost_updated'));
        // return response()->json($indirectcost , 200);
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
        $indirectcost = IndirectCost::destroy($id);

        return redirect('admin/indirect-cost')->with('flash_message', __('translations.indirect_cost_deleted'));
        // return response()->json($indirectcost , 204);
    }
}
