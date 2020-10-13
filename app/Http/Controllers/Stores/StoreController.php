<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Store;
use App\Product;
use App\Outcome;
use DB;
use App\Exports\StoreExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $stores = Store::where('process_number', 'LIKE', "%$keyword%")
            ->orWhere('deliver_name', 'LIKE', "%$keyword%")
            ->orWhere('created_at', 'LIKE', "%$keyword%")
            ->orWhereHas('products', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");})
            ->latest()->paginate($perPage);
    } else {
        $stores = Store::latest()->paginate($perPage);
        }
    return view('admin.stores.index', compact('stores'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
  public function create()
  {
    $prod = DB::table('outcome_product')->pluck('product_id');
    $products = Product::whereIn('id' , $prod)->get();
    return view('admin.stores.create' , compact('products', 'product'));
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
      'process_number' => 'required|integer|digits_between:0,6|unique:stocks,process_number,NULL,id,deleted_at,NULL',
      'deliver_name'=>'required|max:30',
    ]);

      $count = $request->count ?? '';
      $product = [];
      for ($i=1; $i <=$count; $i++) {
        $product[] = $request->{'product_id'.$i};
      }

      if (!empty($product) && count($product) == $count) {
        // $pro = new Product();
        $out = new Outcome();
        $store = Store::create([
          'process_number' => $request->process_number ,
          'deliver_name'   => $request->deliver_name,
        ]);
        for ($i=1; $i <=$count ; $i++) {
          ${'product' . $i}= $request->{'product_id'.$i};
          ${'quantity' . $i}= $request->{'quantity'.$i};
          ${'codeNumber' . $i}= $request->{'code_number'.$i};

          // $productQuantities = $pro->remainingQuantity(${'product' . $i});
          ${'productQuantities' . $i} = $out->remainQuantityOutcome(${'product' . $i},${'codeNumber' . $i});
          if (${'quantity' . $i} <= ${'productQuantities' . $i}) {

            $store->products()->attach( ${'product' . $i} , ['quantity' => ${'quantity' . $i} , 'code_number' => ${'codeNumber' . $i}]);
          }else {
            $store->products()->detach();
            $store->delete();
            return redirect()->back()->withInput()->with('flash_message', __('translations.quantity_more_available'));
          }
        }
      return redirect('admin/stores')->with('flash_message', __('translations.process_added'));


      }else {
        return redirect()->back()->withInput()->with('flash_message',__('translations.please_choose_product'));
      }

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
      $store = Store::findOrFail($id);

      return view('admin.stores.show', compact('store'));
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
      $store = Store::findOrFail($id);
      $products = Product::where('quantity', '>' , 0)->get();

      return view('admin.stores.edit', compact('store' , 'products' ));
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
    $store = Store::findOrFail($id);
    $this->validate($request, [
      'process_number' => 'required|integer|unique:stocks,process_number,'.$store->id . ',id,deleted_at,NULL' ,
      'quantity'=>'required|integer|min:1',
      'product_id' => 'required',
      'deliver_name'=>'required|max:30',
    ]);

    $requestData = $request->all();
    $store->update($requestData);

    return redirect('admin/stores')->with('flash_message', __('translations.order_updated'));
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
      $store = Store::destroy($id);

      return redirect('admin/stores')->with('flash_message', __('translations.store_deleted'));
  }


  //////////////////////// Cancel Functions ////////////////
  public function showCancel($id){
    $store = Store::findOrFail($id);
    $stores = Store::all();
    return view('admin.stores.cancel' , compact('store','stores'));
  }

  public function storeCancel(Request $request , $id){
    $store = Store::findOrFail($id);
    $this->validate($request, [
      'cancel_reason' => 'required',
    ]);
    $store->update([
      'cancel_reason' => $request->cancel_reason,
    ]);

    return redirect('admin/stores')->with('flash_message', __('translations.store_canceled'));

  }

/////////////////// show canceled orders //////////////////
  public function reportsCanceledStores(Request $request){

    $keyword = $request->get('search');
    $perPage = 10;

    if (!empty($keyword)) {
        $stores = Store::whereNotNull('cancel_reason')
          ->where(function($query) use ($keyword){
            $query->where('process_number', 'LIKE', "%$keyword%")
            ->orWhere('deliver_name', 'LIKE', "%$keyword%")
            ->orWhere('created_at', 'LIKE', "%$keyword%")
            ->orWhereHas('products', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");})
            ;})
            ->latest()->paginate($perPage);
    } else {
      $stores = Store::whereNotNull('cancel_reason')
                       ->latest()->paginate($perPage);
    }
    return view('admin.stores.all_canceled' , compact('stores'));
  }

  /////////////////// Reports Functions /////////////////
  public function showReports(Request $request){

       $timestamp = time();
       $thirty = 86400 * 30; // 60 * 60 * 24 = 86400 = 1 day in seconds
       $tm = $timestamp - ($thirty);
       $dt = $timestamp ;

       $perPage=10;

       $lastDate = date("Y-m-d", $tm);
       $date = date("Y-m-d", $dt);

       $choosenDate = $request->get('choosen_date') ??  $lastDate;
       $currentDate = $request->get('current_date') ?? $date ;

       $stores = Store::whereNull('cancel_reason')->whereBetween('created_at',[ $choosenDate . ' 00:00:00' , $currentDate . ' 23:59:59'])->latest()->paginate($perPage);
       return view('admin.stores.reports' , compact('stores' , 'lastDate' , 'date'));
  }
// export function
    public function export()
    {
            return Excel::download(new StoreExport, 'المخزن.xlsx');
    }

}
