<?php

namespace App\Api\Banks\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Api\Accounts\Models\User;
use Illuminate\Support\Facades\Schema;
use App\Api\Banks\Models\ExpenseCategory;

/**
 * Class ExpenseCategoryTableSeeder
 * @package App\Api\Banks\Database\Seeders
 */
class ExpenseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        ExpenseCategory::truncate();
        Schema::enableForeignKeyConstraints();

        /** @var User $user */
        foreach (User::all() as $user) {
            factory(ExpenseCategory::class, 5)->create(['user_id' => $user->id]);
        }
    }
}
