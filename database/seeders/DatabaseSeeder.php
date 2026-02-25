<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

         $accounts = [
            'Cash',
            'Accounts Receivable',
            'Sales Revenue',
            'VAT Payable',
            'Inventory',
            'Cost of Goods Sold'
        ];

        foreach ($accounts as $account) {
            Account::firstOrCreate(['name' => $account]);
        }


        $this->call([
                Product::class,
                SaleSeeder::class,
        ]);
    }
}
