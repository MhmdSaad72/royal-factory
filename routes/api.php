<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'PassportController@login');
Route::post('register', 'PassportController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');

    Route::apiResource('admin/materials', 'API\\Material\\MaterialsController');
    Route::apiResource('admin/material-type', 'API\\MaterialType\\MaterialTypeController');
    Route::apiResource('admin/orders', 'API\\Order\\OrdersController');
    Route::apiResource('admin/suppliers', 'API\\Supplier\\SuppliersController');
    Route::apiResource('admin/indirect-cost-type', 'API\\IndirectCostType\\IndirectCostTypeController');
    Route::apiResource('admin/indirect-cost', 'API\\IndirectCost\\IndirectCostController');
    Route::apiResource('admin/stores-cost-type', 'API\\StoresCostType\\StoresCostTypeController');
    Route::apiResource('admin/stores-cost', 'API\\StoresCost\\StoresCostController');
    Route::apiResource('admin/employee', 'API\\Employee\\EmployeeController');
    Route::apiResource('admin/position-types', 'API\\Employee\\PositionTypesController');
    Route::apiResource('admin/stores', 'API\\Stores\\StoreController');
    Route::apiResource('admin/products', 'API\\Product\\ProductController');
    Route::prefix('admin')->group(function () {
        Route::get('outcomes', 'API\\Outcome\\OutcomeController@index')->name('outcomes.index');
        Route::post('outcomes', 'API\\Outcome\\OutcomeController@store')->name('outcomes.store');
        Route::get('outcomes/create', 'API\\Outcome\\OutcomeController@create')->name('outcomes.create');
        Route::get('outcomes/{outcome}', 'API\\Outcome\\OutcomeController@show')->name('outcomes.show');
        Route::patch('outcomes/{outcome}', 'API\\Outcome\\OutcomeController@update')->name('outcomes.update');
        Route::delete('outcomes/{outcome}', 'API\\Outcome\\OutcomeController@destroy')->name('outcomes.destroy');
        Route::get('outcomes/{outcome}/edit', 'API\\Outcome\\OutcomeController@edit')->name('outcomes.edit');
        Route::get('outcomes/{outcome}/product', 'API\\Outcome\\OutcomeController@createProduct')->name('outcome-products.create');
        Route::post('outcomes/outcome-products', 'API\\Outcome\\OutcomeController@storeProduct')->name('outcome-products.store');
        Route::get('outcomes/{outcome}/edit-product', 'API\\Outcome\\OutcomeController@editProduct')->name('outcome-products.edit');
        Route::patch('outcomes/outcome-products/{outcome}', 'API\\Outcome\\OutcomeController@updateProduct')->name('outcome-products.update');
        Route::get('outcomes/outcome-products/{outcome}', 'API\\Outcome\\OutcomeController@showProduct')->name('outcome-products.show');
      });

});
