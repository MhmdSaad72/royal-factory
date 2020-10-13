<?php

namespace App\Http\Controllers\API\IndirectCostType;

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
        if (!$indirectcosttype) {
          return response()->json(['message'=>'IndirectCostType Is Not found']);
        }

        // return view('admin.indirect-cost-type.index', compact('indirectcosttype'));
        return response()->json($indirectcosttype, 200);
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
          'name'=>'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:indirect_cost_types,name,NULL,id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $indirectcosttype = IndirectCostType::create($requestData);

        // return redirect('admin/indirect-cost-type')->with('flash_message', 'IndirectCostType added!');
        return response()->json(['message'=>'IndirectCostType Created Successfully'] , 201);
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
        $indirectcosttype = IndirectCostType::find($id);
        if (!$indirectcosttype) {
          return response()->json(['message'=>'IndirectCostType Is Not found']);
        }

        // return view('admin.indirect-cost-type.show', compact('indirectcosttype'));
        return response()->json($indirectcosttype ,200);
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

       $indirectcosttype = IndirectCostType::find($id);
       if (!$indirectcosttype) {
         return response()->json(['message'=>'IndirectCostType Is Not found']);
       }
        $validator = Validator::make($request->all(), [
          'name'=>'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:indirect_cost_types,name,'.$indirectcosttype->id.',id,deleted_at,NULL',
        ]);

        if ($validator->fails()) {
               return response()->json($validator->errors() ,400);
           }

        $requestData = $request->all();
        $indirectcosttype->update($requestData);

        // return redirect('admin/indirect-cost-type')->with('flash_message', 'IndirectCostType updated!');
        return response()->json(['message'=>'IndirectCostType Updated Successfully'] , 200);
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
        $indirectcosttype = IndirectCostType::find($id);
        if (!$indirectcosttype) {
          return response()->json(['message'=>'IndirectCostType Is Not found']);
        }
        $indirectcosttype = IndirectCostType::destroy($id);

        // return redirect('admin/indirect-cost-type')->with('flash_message', 'IndirectCostType deleted!');
        return response()->json([
          'message' => 'IndirectCostType Deleted Successfully',
          ] , 200);
    }
}
