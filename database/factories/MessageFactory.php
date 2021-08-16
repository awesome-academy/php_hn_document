<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Message;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomDigit(),
        'receiver_id' => $faker->randomDigit(),
        'conversation_id' => $faker->randomDigit(),
        'content' => Str::random(10),
        'is_read' => config('user.un_read'),
    ];
});
