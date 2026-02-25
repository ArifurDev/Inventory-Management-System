<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\JournalEntry;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $totalSales = null;
        $totalExpense = null;

        if ($request->from && $request->to) {

            $totalSales = Sale::whereBetween('sale_date',
                [$request->from, $request->to])
                ->sum('total_amount');

            $totalExpense = JournalEntry::whereHas('account', function ($q) {
                $q->where('name', 'Cost of Goods Sold');
            })
            ->whereBetween('entry_date', [$request->from, $request->to])
            ->sum('debit');
        }

        return view('report.index', compact('totalSales', 'totalExpense'));
    }
}
