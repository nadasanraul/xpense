<?php

namespace App\Api\Banks\Database\Seeders;

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
         $this->call(BanksTableSeeder::class);
    }
}
