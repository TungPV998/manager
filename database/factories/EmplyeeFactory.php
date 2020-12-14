<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
$factory->define(Model\Employee::class, function (Faker $faker) {
    return [
        'ten'=>$faker->name,
        'diachi'=>$faker->address,
        'sodienthoai'=>$faker->phoneNumber(),
        'gioitinh'=>$faker->numberBetween(0,1),
        'macv'=>$faker->numberBetween(0,6),
        'img'=>'',
        'luongcoban'=>$faker->randomDigit(100),
        'ngaybatdau'=>$faker->date(),
        'ngayketthuc'=>$faker->date(),
    ];
});
