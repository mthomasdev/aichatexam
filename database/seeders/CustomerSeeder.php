<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Customer;
use App\Models\PurchaseTransaction;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer1 = Customer::factory()
            ->has(PurchaseTransaction::factory()->count(0), 'purchaseTransactions')
            ->create([
                'first_name'    => 'User 0',
                'last_name'     => 'Out of 2',
                'email'         => 'customer1@aichattest.com'
            ]);

        $customer2 = Customer::factory()
            ->has(PurchaseTransaction::factory()->count(2), 'purchaseTransactions')
            ->create([
                'first_name'    => 'User 1',
                'last_name'     => 'Out of 2',
                'email'         => 'customer2@aichattest.com'
            ]);

        $customer3 = Customer::factory()
            ->has(PurchaseTransaction::factory()->count(5), 'purchaseTransactions')
            ->create([
                'first_name'    => 'User 2',
                'last_name'     => 'Out of 2',
                'email'         => 'customer3@aichattest.com'
            ]);
    }
}
