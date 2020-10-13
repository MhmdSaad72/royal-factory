<?php

namespace App\Http\Controllers\API\Stores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Store;

class StoreController extends Controller
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
          $store = Store::where('name', 'LIKE', "%$keyword%")
              ->latest()->paginate($perPage);
      } else {
          $store = Store::latest()->paginate($perPage);
      }
      if (!$store) {
        return response()->json(['message'=>'Store Is Not found']);
      }

      // return view('admin.stores.index', compact('store'));
      return response()->json($store , 200);
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
        'name'=>'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:stores,name,NULL,id,deleted_at,NULL',
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }

      $requestData = $request->all();
      $store = Store::create($requestData);

      // return redirect('admin/stores')->with('flash_message', 'Store added!');
      return response()->json(['message'=>'Store Created Successfully'] , 201);
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
      $store = Store::find($id);
      if (!$store) {
        return response()->json(['message'=>'Store Is Not found']);
      }

      // return view('admin.stores.show', compact('store'));
      return response()->json($store , 200);
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
      $store = Store::find($id);
      if (!$store)
      {
        // Customize Error Message For undefined Id
        return response()->json(['message' => 'store not found'] ,404);
      }
      $validator = Validator::make($request->all(), [
        'name'=>'required|max:255|regex:/^(?=.*?[A-Za-z])/|unique:stores,name,'.$store->id.',id,deleted_at,NULL',
      ]);

      if ($validator->fails()) {
             return response()->json($validator->errors() ,400);
         }

      $requestData = $request->all();
      $store->update($requestData);

      // return redirect('admin/stores')->with('flash_message', 'Store updated!');
      return response()->json(['message'=>'Store Updated Successfully'] , 200);
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
      $store = Store::find($id);
      if (!$store)
      {
        return response()->json(['message' => 'store not Found'] ,404);
      }
        Store::destroy($id);
        return response()->json([
             'message' => 'store Deleted',
              'store' => $store] ,200);
      // return redirect('admin/stores')->with('flash_message', 'Store deleted!');
      // return response()->json($store , 204);
  }

}
