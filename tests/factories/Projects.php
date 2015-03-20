<?php

$factory('NeonTsunami\Project', [
    'name'        => $faker->word,
    'slug'        => $faker->unique()->slug(1),
    'description' => $faker->sentence
]);
