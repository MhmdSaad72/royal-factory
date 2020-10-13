<?php

namespace App\Exports;

use App\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderPeriodExport implements FromView
{
  public function view(): View
  {
      return view('admin.orders.excel', [
          'orders' => Order::all(),
      ]);
  }
}
