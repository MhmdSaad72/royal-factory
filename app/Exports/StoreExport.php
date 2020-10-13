<?php

namespace App\Exports;

use App\Store;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StoreExport implements FromView
{
    public function view(): View
    {
        return view('admin.stores.excel', [
            'stores' => Store::whereNull('cancel_reason')->get()
        ]);
    }
}
