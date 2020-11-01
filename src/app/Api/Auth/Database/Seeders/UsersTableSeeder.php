<?php

namespace App\Api\Auth\Database\Seeders;

use App\Api\Accounts\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UsersTableSeeder
 * @package App\Api\Auth\Database\Seeders
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        factory(User::class)->create([
            'username' => 'raul',
            'firstname' => 'Raul',
            'lastname' => 'Nadasan',
            'email' => 'nadasanraul@gmail.com',
        ]);
    }
}
