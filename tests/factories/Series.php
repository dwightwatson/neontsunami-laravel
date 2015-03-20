<?php

$factory('NeonTsunami\Series', [
    'name'        => $faker->word,
    'slug'        => $faker->unique()->slug(1),
    'description' => $faker->sentence
]);
