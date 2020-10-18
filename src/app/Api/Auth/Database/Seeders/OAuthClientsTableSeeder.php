<?php

namespace App\Api\Auth\Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Api\Auth\Models\OAuthClient;
use Illuminate\Support\Facades\Schema;

/**
 * Class OAuthClientsTableSeeder
 * @package App\Api\Auth\Database\Seeders
 */
class OAuthClientsTableSeeder extends Seeder
{
    /**
     * OAuthClientsTableSeeder constructor.
     */
    public function __construct()
    {
        OAuthClient::unguard();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate();
        OAuthClient::create(
            [
                'id' => Str::uuid(),
                'secret' => Str::random(32),
                'name' => 'Oauth Client',
                'domain' => 'http://xpense.athd.eu',
                'redirect' => 'http://xpense.athd.eu',
                'cookie_domain' => 'http://xpense.athd.eu',
                'revoked' => 0,
            ]
        );
    }

    /**
     * OAuthClientsTableSeeder destructor
     */
    public function __destruct()
    {
        OAuthClient::reguard();
    }

    /**
     * Truncates the table
     *
     * @return void
     */
    private function truncate()
    {
        Schema::disableForeignKeyConstraints();
        OAuthClient::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
