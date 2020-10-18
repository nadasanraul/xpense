<?php

namespace App\Api\Banks\Database\Seeders;

use App\Api\Banks\Models\Bank;
use Illuminate\Database\Seeder;

/**
 * Class BanksTableSeeder
 * @package App\Api\Banks\Database\Seeders
 */
class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bank::truncate();
        factory(Bank::class, 20)->create();
    }
}
