<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Api\Banks\Models\Transaction;
use Illuminate\Support\Str;
use App\Api\Banks\Models\Account;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'uuid' => Str::uuid(),
        'account_id' => Account::first()->id,
        'title' => $faker->sentence,
        'amount' => rand(-200, 200),
        'type' => rand(0, 5) === 0 ? 'add' : 'sub',
        'completed_at' => now(),
    ];
});
