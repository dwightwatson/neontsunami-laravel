<?php

$factory('Post', [
    'user_id'      => 'factory:User',
    'series_id'    => 'factory:Series',
    'title'        => $faker->name,
    'slug'         => $faker->unique()->slug(1),
    'content'      => $faker->sentence,
    'published_at' => $faker->date
]);
