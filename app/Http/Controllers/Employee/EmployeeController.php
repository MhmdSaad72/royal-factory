<?php

namespace App\Http\Controllers\Employee;

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
            $em = new Employee();
            $employee = Employee::where('name', 'LIKE', "%$keyword%")
                ->orWhere('position_id', 'LIKE', "%$keyword%")
                ->orWhere('type' ,'LIKE',  $em->getEmployeeType(strtolower($keyword)))
                ->orWhere('salary', 'LIKE', "%$keyword%")
                // ->orWhere('precentage', 'LIKE', "%$keyword%")
                ->orWhereHas('position_type', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%");})
                ->latest()->paginate($perPage);
        } else {
            $employee = Employee::latest()->paginate($perPage);
        }

        return view('admin.employee.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
      $positionTypes = PositionType::all();
        return view('admin.employee.create' , compact('positionTypes'));
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
        'name' => 'required|max:30',
        'salary' => 'required|integer|digits_between:0,6|gte:1',
        'position_id' => 'required',
      ]);

        $requestData = $request->all();
        $employee = Employee::create($requestData);

        return redirect('admin/employee')->with('flash_message', __('translations.employee_added'));
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
        $employee = Employee::findOrFail($id);

        return view('admin.employee.show', compact('employee'));
        // return response()->json($employee , 200);
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
        $employee = Employee::findOrFail($id);
        $positionTypes = PositionType::all();

        return view('admin.employee.edit', compact('employee' , 'positionTypes'));
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
        'name' => 'required|max:30',
        'salary' => 'required|integer|digits_between:0,6',
        'position_id' => 'required',
      ]);

        $requestData = $request->all();
        $employee = Employee::findOrFail($id);
        $employee->update($requestData);

        return redirect('admin/employee')->with('flash_message', __('translations.employee_updated'));
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
        $employee = Employee::destroy($id);

        return redirect('admin/employee')->with('flash_message', __('translations.employee_deleted'));
    }
}
