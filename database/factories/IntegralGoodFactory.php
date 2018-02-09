<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\IntegralGood::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
	    'integral' => 100,
	    'introduction' => $faker->text(200)
    ];
});
