<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Api\Banks\Models\Account;
use App\Api\Banks\Models\Bank;
use App\Api\Accounts\Models\User;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'uuid' => Str::uuid(),
        'bank_id' => Bank::first()->id,
        'user_id' => User::first()->id,
        'name' => $faker->word(),
        'description' => $faker->sentence(),
        'balance' => rand(-1000, 1000),
        'number' => $faker->bankAccountNumber,
    ];
});
