<?php

namespace App\Api\Banks\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Api\Banks\Models\Account;
use App\Api\Banks\Models\Transaction;

/**
 * Class TransactionsTableSeeder
 * @package App\Api\Banks\Database\Seeders
 */
class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::truncate();
        foreach (Account::all() as $account) {
            factory(Transaction::class, 30)->create(['account_id' => $account->id]);
        }
    }
}
