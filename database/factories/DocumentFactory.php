<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Document;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Document::class, function (Faker $faker) {
    $extArr = ['pdf', 'jpg', 'png'];
    $ext = array_rand($extArr);
    return [
        'name' => $faker->name,
        'description' => Str::random(40),
        'url' => Str::random(10) . '.' . $extArr[$ext],
        'category_id' => $faker->randomDigit(),
        'user_id' => $faker->randomDigit(),
    ];
});
