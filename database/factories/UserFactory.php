<?php

$factory->define(App\Models\User::class, function () {
	$faker = \Faker\Factory::create('zh_CN');
	return [
		'username' => $faker->email,
		'mobile' => $faker->phoneNumber,
		'password' => bcrypt('admin'),
		'is_agent' => false,
		'parent_id' => rand(1,10),
	];
});
