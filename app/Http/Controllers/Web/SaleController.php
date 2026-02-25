<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();

        try {

            $product = Product::findOrFail($request->product_id);

            if ($product->stock_quantity < $request->quantity) {
                return back()->with('error', 'Insufficient Stock');
            }

            $subtotal = $request->quantity * $product->sell_price;
            $discount = $request->discount ?? 0;
            $afterDiscount = $subtotal - $discount;
            $vat = $afterDiscount * 0.05;
            $total = $afterDiscount + $vat;
            $paid = $request->paid_amount ?? 0;
            $due = $total - $paid;

            $sale = Sale::create([
                'sale_date' => now(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'vat' => $vat,
                'total_amount' => $total,
                'paid_amount' => $paid,
                'due_amount' => $due,
            ]);

            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->sell_price,
                'total_price' => $subtotal,
            ]);

            $product->decrement('stock_quantity', $request->quantity);

            $this->createJournal($sale, $product, $request->quantity, $afterDiscount, $vat, $paid);

            DB::commit();

            return redirect()->back()->with('success', 'Sale Completed Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    private function createJournal($sale, $product, $qty, $netSale, $vat, $paid)
    {
        $accounts = Account::pluck('id', 'name');

        // Accounts Receivable
        JournalEntry::create([
            'sale_id' => $sale->id,
            'account_id' => $accounts['Accounts Receivable'],
            'debit' => $sale->total_amount,
            'credit' => 0,
            'entry_date' => now()
        ]);

        // Sales Revenue
        JournalEntry::create([
            'sale_id' => $sale->id,
            'account_id' => $accounts['Sales Revenue'],
            'debit' => 0,
            'credit' => $netSale,
            'entry_date' => now()
        ]);

        // VAT Payable
        JournalEntry::create([
            'sale_id' => $sale->id,
            'account_id' => $accounts['VAT Payable'],
            'debit' => 0,
            'credit' => $vat,
            'entry_date' => now()
        ]);

        // Payment Entry
        if ($paid > 0) {
            JournalEntry::create([
                'sale_id' => $sale->id,
                'account_id' => $accounts['Cash'],
                'debit' => $paid,
                'credit' => 0,
                'entry_date' => now()
            ]);

            JournalEntry::create([
                'sale_id' => $sale->id,
                'account_id' => $accounts['Accounts Receivable'],
                'debit' => 0,
                'credit' => $paid,
                'entry_date' => now()
            ]);
        }

        // COGS
        $cogs = $qty * $product->purchase_price;

        JournalEntry::create([
            'sale_id' => $sale->id,
            'account_id' => $accounts['Cost of Goods Sold'],
            'debit' => $cogs,
            'credit' => 0,
            'entry_date' => now()
        ]);

        JournalEntry::create([
            'sale_id' => $sale->id,
            'account_id' => $accounts['Inventory'],
            'debit' => 0,
            'credit' => $cogs,
            'entry_date' => now()
        ]);
    }
}
