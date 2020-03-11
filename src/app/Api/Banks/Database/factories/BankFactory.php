<?php

/** @var \Illuminae\Database\Eloquent\Factory $factory */

use App\Api\Banks\Models\Bank;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Bank::class, function(Faker $faker) {
    return [
        'uuid' => Str::uuid(),
        'name' => $faker->word(),
        'description' => $faker->sentence(),
        'country' => $faker->countryCode,
    ];
});
