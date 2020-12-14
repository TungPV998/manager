<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Department::class, function (Faker $faker) {
    return [
        'tenphongban'=>$faker->name,
        'parent_id'=>0,
    ];
});
