<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Contact;
use App\User;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'name' => $faker->name,
        'email' => $faker->email,
        'birthday' => "03/17/1993",
        'company' => $faker->company,
    ];
});
