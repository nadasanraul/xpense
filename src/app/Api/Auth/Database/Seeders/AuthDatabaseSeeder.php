<?php

namespace App\Api\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthDatabaseSeeder
 * @package App\Api\Auth\Database\Seeders
 */
class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(UsersTableSeeder::class);
        $this->call(OAuthClientsTableSeeder::class);
    }
}
