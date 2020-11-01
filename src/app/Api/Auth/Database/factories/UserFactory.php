<?php

/** @var Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Api\Accounts\Models\User;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function(Faker $faker) {
    return [
        'username' => $faker->name(),
        'uuid' => Str::uuid(),
        'firstname' => $faker->firstName(),
        'lastname' => $faker->lastName,
        'auth_driver' => 'google',
        'email' => $faker->email,
    ];
});
