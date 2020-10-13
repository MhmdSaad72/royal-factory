<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;
use App\Supplier;
use App\Store;
use App\Product;
use App\Order;
use App\Outcome;
use App\Employee;

class DashboardController extends Controller
{
  public function index(){
    $mat = new Material();
    $materials = $mat->getAllMaterials();
    $primaryMaterials = $mat->getAllPrimaryMaterials();
    $secondaryMaterials = $mat->getAllSecondaryMaterials();

    $sup = new Supplier();
    $suppliers = $sup->getAllSuppliers();

    $sto = new Store();
    $stores = $sto->getAllStores();

    $pro = new Product();
    $products = $pro->getAllProducts();

    $ord = new Order();
    $orders = $ord->getAllOrders();

    $out = new Outcome();
    $outcomes = $out->getAllOutcomes();

    $emp = new Employee();
    $employees = $emp->getAllEmployees();

    return view('admin.dash', compact('materials','suppliers','stores','products','primaryMaterials' , 'secondaryMaterials' , 'orders' , 'outcomes' , 'employees'));
  }
}
