<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Kriteria;
use Faker\Generator as Faker;

$factory->define(Kriteria::class, function (Faker $faker) {
    return [
        'kriteria' => $faker->name,
    ];
});
