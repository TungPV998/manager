<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Position::class, function (Faker $faker) {
    return [
        "tenchucvu"=>$faker->name,
    ];
});
