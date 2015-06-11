<?php

$factory->define(NeonTsunami\User::class, function ($faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->unique()->email,
        'password'   => 'secret'
    ];
});
