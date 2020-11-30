<?php

namespace App\Api\Banks\Database\Seeders;

use App\Api\Accounts\Models\User;
use App\Api\Banks\Models\Bank;
use Illuminate\Database\Seeder;
use App\Api\Banks\Models\Account;
use Illuminate\Support\Facades\Schema;

/**
 * Class AccountsTableSeeder
 * @package App\Api\Banks\Database\Seeders
 */
class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Account::truncate();
        Schema::enableForeignKeyConstraints();

        /** @var User $user */
        foreach (User::all() as $user) {
            /** @var Bank $bank */
            foreach (Bank::all() as $bank) {
                factory(Account::class)->create([
                    'user_id' => $user->id,
                    'bank_id' => $bank->id
                ]);
            }
        }
    }
}
