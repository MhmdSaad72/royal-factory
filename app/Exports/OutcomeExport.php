<?php

namespace App\Exports;

use App\Outcome;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OutcomeExport implements FromView
{
    public function view(): View
    {
        return view('admin.outcome.excel', [
            'outcomes' => Outcome::whereNull('cancel_reason')->get()
        ]);
    }
}
