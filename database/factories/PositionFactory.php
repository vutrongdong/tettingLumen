<?php

$factory->define(App\Repositories\Positions\Position::class, function (Faker\Generator $faker) {
    return [
		'name' => $faker->name
    ];
});
