<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();


// Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
  Route::resource('admin/materials', 'Material\\MaterialsController');
  Route::get('admin/materials/api/{id}' , 'Material\\MaterialsController@api');
  Route::get('admin/materials/max/order','Material\\MaterialsController@maxOrder')->name('materials.maxOrder');
  Route::get('admin/materials/movement/{id}' , 'Material\\MaterialsController@materialMovement' )->name('materials.movement');
  Route::get('admin/materials/outcomes/{id}' , 'Material\\MaterialsController@showOutcomes')->name('materials.outcomes');
  // Route::get('admin/materials' , 'Material\\MaterialsController@showReports')->name('materials.reports');
  Route::resource('admin/material-type', 'MaterialType\\MaterialTypeController');
  Route::resource('admin/orders', 'Order\\OrdersController');
  Route::get('admin/orders/cancel/{id}' , 'Order\\OrdersController@showCancel')->name('orders.cancel.show');
  Route::PATCH('admin/orders/cancel/{id}' , 'Order\\OrdersController@orderCancel')->name('orders.cancel.store');
  Route::get('admin/orders/reprts/canceled' , 'Order\\OrdersController@reportsCanceledOrders')->name('orders.canceled.reports');
  Route::get('admin/orders/expires/date' , 'Order\\OrdersController@expireDateOrders')->name('orders.next.expire');
  Route::get('admin/orders/reports/reports' , 'Order\\OrdersController@showReports')->name('orders.reports.show');
  Route::get('admin/orders/expired/expired' , 'Order\\OrdersController@expiredOrders')->name('orders.expired');
  Route::resource('admin/suppliers', 'Supplier\\SuppliersController');
  Route::resource('admin/indirect-cost-type', 'IndirectCostType\\IndirectCostTypeController');
  Route::resource('admin/indirect-cost', 'IndirectCost\\IndirectCostController');
  Route::resource('admin/stores-cost-type', 'StoresCostType\\StoresCostTypeController');
  Route::resource('admin/stores-cost', 'StoresCost\\StoresCostController');
  Route::resource('admin/employee', 'Employee\\EmployeeController');
  Route::resource('admin/position-types', 'Employee\\PositionTypesController');
  Route::resource('admin/stores', 'Stores\\StoreController');
  Route::get('admin/stores/cancel/{id}' , 'Stores\\StoreController@showCancel')->name('stores.cancel.show');
  Route::PATCH('admin/stores/cancel/{id}' , 'Stores\\StoreController@storeCancel')->name('stores.cancel.store');
  Route::get('admin/stores/reprts/canceled' , 'Stores\\StoreController@reportsCanceledStores')->name('stores.canceled.reports');
  Route::get('admin/stores/reports/reports' , 'Stores\\StoreController@showReports')->name('stores.reports.show');
  Route::resource('admin/products', 'Product\\ProductController');
  Route::get('admin/products/outcomes/{id}' , 'Product\\ProductController@showOutcomes')->name('products.outcomes');
  Route::get('admin/products/stores/{id}' , 'Product\\ProductController@showStores')->name('products.stores');
  Route::get('admin/products/movement/{id}' , 'Product\\ProductController@productMovement' )->name('products.movement');
  Route::get('admin/products/api/{id}' , 'Product\\ProductController@api');
  Route::prefix('admin')->group(function () {
      Route::get('outcomes', 'Outcome\\OutcomeController@index')->name('outcomes.index');
      Route::post('outcomes', 'Outcome\\OutcomeController@store')->name('outcomes.store');
      Route::get('outcomes/create', 'Outcome\\OutcomeController@create')->name('outcomes.create');
      Route::get('outcomes/{outcome}', 'Outcome\\OutcomeController@show')->name('outcomes.show');
      Route::patch('outcomes/{outcome}', 'Outcome\\OutcomeController@update')->name('outcomes.update');
      Route::delete('outcomes/{outcome}', 'Outcome\\OutcomeController@destroy')->name('outcomes.destroy');
      Route::get('outcomes/{outcome}/edit', 'Outcome\\OutcomeController@edit')->name('outcomes.edit');
      Route::get('outcomes/cancel/{id}' , 'Outcome\\OutcomeController@showCancel')->name('outcomes.cancel.show');
      Route::PATCH('outcomes/cancel/{id}' , 'Outcome\\OutcomeController@outcomeCancel')->name('outcomes.cancel.store');
      Route::get('outcomes/reports/reports' , 'Outcome\\OutcomeController@showReports')->name('outcomes.reports.show');
      Route::post('outcomes/reports/reports' , 'Outcome\\OutcomeController@searchReports')->name('outcomes.reports.serch');
      Route::get('outcomes/{outcome}/product', 'Outcome\\OutcomeController@createProduct')->name('outcome-products.create');
      Route::post('outcomes/outcome-products', 'Outcome\\OutcomeController@storeProduct')->name('outcome-products.store');
      Route::get('outcomes/{outcome}/edit-product', 'Outcome\\OutcomeController@editProduct')->name('outcome-products.edit');
      Route::patch('outcomes/outcome-products/{outcome}', 'Outcome\\OutcomeController@updateProduct')->name('outcome-products.update');
      Route::get('outcomes/outcome-products/{outcome}', 'Outcome\\OutcomeController@showProduct')->name('outcome-products.show');
      Route::get('outcomes/reprts/canceled' , 'Outcome\\OutcomeController@reportsCanceledOutcomes')->name('outcomes.canceled.reports');

    });



    Route::get('/', 'DashboardController@index')->name('dash.index');
    // excel routes
    Route::get('order/export', 'Order\\OrdersController@export')->name('order.export');
    Route::get('outcome/export', 'Outcome\\OutcomeController@export')->name('outcome.export');
    Route::get('store/export', 'Stores\\StoreController@export')->name('store.export');



  Route::get('admin/outcomes/pdf/{id}', 'Outcome\\OutcomeController@pdfOutcome');
  Route::get('admin/outcomes/outcome-products/pdf/{id}', 'Outcome\\OutcomeController@pdfOutcomeProduct');

  ////////////// Dashboard Routes /////
  Route::get('/dash', 'DashboardController@index')->name('dash.index');
});
