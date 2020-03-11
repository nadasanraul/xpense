<?php

/** @var Factory $factory */

use Faker\Generator as Faker;
use App\Api\Auth\Models\User;
use Illuminate\Database\Eloquent\Factory;

$factory->define(User::class, function(Faker $faker) {
    return [
        'username' => $faker->name(),
        'firstname' => $faker->firstName(),
        'lastname' => $faker->lastName,
        'auth_driver' => 'google',
        'email' => $faker->email,
    ];
});
