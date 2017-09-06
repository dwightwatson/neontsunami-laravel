<?php

$factory->define(App\User::class, function ($faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->unique()->email,
        'password'   => $password ?: $password = bcrypt('secret'),
    ];
});
