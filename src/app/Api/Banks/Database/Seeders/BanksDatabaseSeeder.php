<?php

namespace App\Api\Banks\Database\Seeders;

use App\Api\Banks\Models\Bank;
use Illuminate\Database\Seeder;

/**
 * Class BanksDatabaseSeeder
 * @package App\Api\Banks\Database\Seeders
 */
class BanksDatabaseSeeder extends Seeder
{
    public function __construct()
    {
        Bank::unguard();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BanksTableSeeder::class);
    }

    public function __destruct()
    {
        Bank::reguard();
    }
}
