<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $products = Product::all();
        $accounts = Account::pluck('id', 'name');

        for ($i = 1; $i <= 10; $i++) {

            DB::beginTransaction();

            $product = $products->random();
            $quantity = rand(1, 5);

            if ($product->stock_quantity < $quantity) {
                continue;
            }

            $subtotal = $quantity * $product->sell_price;
            $discount = rand(0, 50);
            $afterDiscount = $subtotal - $discount;
            $vat = $afterDiscount * 0.05;
            $total = $afterDiscount + $vat;
            $paid = rand(0, $total);
            $due = $total - $paid;

            $sale = Sale::create([
                'sale_date' => now()->subDays(rand(0, 10)),
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
                'quantity' => $quantity,
                'unit_price' => $product->sell_price,
                'total_price' => $subtotal,
            ]);

            $product->decrement('stock_quantity', $quantity);

            // -------- Journal Entries --------

            // Accounts Receivable
            JournalEntry::create([
                'sale_id' => $sale->id,
                'account_id' => $accounts['Accounts Receivable'],
                'debit' => $total,
                'credit' => 0,
                'entry_date' => $sale->sale_date,
            ]);

            // Sales Revenue
            JournalEntry::create([
                'sale_id' => $sale->id,
                'account_id' => $accounts['Sales Revenue'],
                'debit' => 0,
                'credit' => $afterDiscount,
                'entry_date' => $sale->sale_date,
            ]);

            // VAT Payable
            JournalEntry::create([
                'sale_id' => $sale->id,
                'account_id' => $accounts['VAT Payable'],
                'debit' => 0,
                'credit' => $vat,
                'entry_date' => $sale->sale_date,
            ]);

            if ($paid > 0) {
                JournalEntry::create([
                    'sale_id' => $sale->id,
                    'account_id' => $accounts['Cash'],
                    'debit' => $paid,
                    'credit' => 0,
                    'entry_date' => $sale->sale_date,
                ]);

                JournalEntry::create([
                    'sale_id' => $sale->id,
                    'account_id' => $accounts['Accounts Receivable'],
                    'debit' => 0,
                    'credit' => $paid,
                    'entry_date' => $sale->sale_date,
                ]);
            }

            $cogs = $quantity * $product->purchase_price;

            JournalEntry::create([
                'sale_id' => $sale->id,
                'account_id' => $accounts['Cost of Goods Sold'],
                'debit' => $cogs,
                'credit' => 0,
                'entry_date' => $sale->sale_date,
            ]);

            JournalEntry::create([
                'sale_id' => $sale->id,
                'account_id' => $accounts['Inventory'],
                'debit' => 0,
                'credit' => $cogs,
                'entry_date' => $sale->sale_date,
            ]);

            DB::commit();
        }
    }
}
