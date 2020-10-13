<?php

namespace App\Http\Controllers\API\IndirectCost;

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
                ->latest()->paginate($perPage);
        } else {
            $indirectcost = IndirectCost::latest()->paginate($perPage);
        }
        if (!$indirectcost) {
          return response()->json(['message'=>'IndirectCost Is Not found']);
        }

        // return view('admin.indirect-cost.index', compact('indirectcost'));
        return response()->json($indirectcost , 200);
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
          'price'=>'required|integer|min:1|digits_between:1,5',
          'indirect_cost_type_id'=>'required',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $indirectcost = IndirectCost::create($requestData);

        return response()->json([
          'message'=>'IndirectCost Created Successfully',
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
        $indirectcost = IndirectCost::findOrFail($id);
        if (!$indirectcost) {
          return response()->json(['message'=>'IndirectCost Is Not found']);
        }

        return response()->json($indirectcost , 200);
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
          'price'=>'required|integer|min:1|digits_between:1,5',
          'indirect_cost_type_id'=>'required',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $indirectcost = IndirectCost::find($id);
        if (!$indirectcost) {
          return response()->json(['message'=>'IndirectCost Is Not found']);
        }
        $indirectcost->update($requestData);

        // return redirect('admin/indirect-cost')->with('flash_message', 'IndirectCost updated!');
        return response()->json(['message'=>'IndirectCost Updated Successfully'] , 200);
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
        $indirectcost = IndirectCost::find($id);
        if (!$indirectcost) {
          return response()->json(['message'=>'IndirectCost Is Not found']);
        }
        $indirectcost = IndirectCost::destroy($id);

        // return redirect('admin/indirect-cost')->with('flash_message', 'IndirectCost deleted!');
        return response()->json([
          'message'=>'IndirectCost Deleted Successfully',
          'indirectCost' => $indirectcost,
          ] , 200);
    }
}
