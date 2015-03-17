<?php

$factory('User', [
    'first_name' => $faker->firstName,
    'last_name'  => $faker->lastName,
    'email'      => $faker->unique()->email,
    'password'   => 'secret'
]);
