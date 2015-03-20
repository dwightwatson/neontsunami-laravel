<?php

$factory('NeonTsunami\Project', [
    'name'        => $faker->name,
    'slug'        => $faker->unique()->slug(1),
    'description' => $faker->sentence
]);
