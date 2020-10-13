<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Employee;
use App\PositionType;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
            $employee = Employee::where('name', 'LIKE', "%$keyword%")
                ->orWhere('position_id', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->orWhere('salary', 'LIKE', "%$keyword%")
                ->orWhere('precentage', 'LIKE', "%$keyword%")
                ->orWhereHas('position_type', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->latest()->paginate($perPage);
        } else {
            $employee = Employee::latest()->paginate($perPage);
        }
        if (!$employee) {
          return response()->json(['message'=>'Employee Is Not found']);
        }

        // return view('admin.employee.index', compact('employee'));
        return response()->json($employee , 200);
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
        'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/',
        'salary' => 'required|integer|digits_between:0,6|gte:1',
        'precentage'=>'required|integer|between:0,100' ,
        'position_id' => 'required',
        'type'=>'required',
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }

        $requestData = $request->all();
        $employee = Employee::create($requestData);

        // return redirect('admin/employee')->with('flash_message', 'Employee added!');
        return response()->json(['message' => 'Employee Created Successfully'] , 201);
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
        $employee = Employee::find($id);
        if (!$employee) {
          return response()->json(['message'=>'Employee Is Not found']);
        }

        // return view('admin.employee.show', compact('employee'));
        return response()->json($employee , 200);
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
        'name' => 'required|max:255|regex:/^(?=.*?[A-Za-z])/',
        'salary' => 'required|integer|digits_between:0,6',
        'precentage'=>'required|integer|between:0,100',
        'position_id' => 'required',
        'type'=>'required',
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }

        $requestData = $request->all();
        $employee = Employee::find($id);
        if (!$employee) {
          return response()->json(['message'=>'Employee Is Not found']);
        }
        $employee->update($requestData);

        // return redirect('admin/employee')->with('flash_message', 'Employee updated!');
        return response()->json([
          'message'=>'Employee Updated Successfully' ,
          'employee' => $employee,
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
        $employee = Employee::find($id);
        if (!$employee) {
          return response()->json(['message'=>'Employee Is Not found']);
        }
        Employee::destroy($id);
        return response()->json([
             'message' => 'Employee Deleted Successfully',
              'employee' => $employee] ,200);
    }
}
