<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Api\Banks\Models\ExpenseCategory;
use Illuminate\Support\Str;
use App\Api\Accounts\Models\User;

$factory->define(ExpenseCategory::class, function (Faker $faker) {
    return [
        'uuid' => Str::uuid(),
        'user_id' => User::first()->id,
        'name' => $faker->word(),
    ];
});
