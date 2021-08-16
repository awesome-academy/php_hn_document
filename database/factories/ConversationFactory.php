<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Conversation;
use Faker\Generator as Faker;

$factory->define(Conversation::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigit(),
        'partner_id' => $faker->randomDigit(),
        'last_message' => $faker->randomDigit(),
    ];
});
