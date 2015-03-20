<?php

$factory('NeonTsunami\Post', [
    'user_id'      => 'factory:NeonTsunami\User',
    'series_id'    => 'factory:NeonTsunami\Series',
    'title'        => $faker->word,
    'slug'         => $faker->unique()->slug(1),
    'content'      => $faker->sentence,
    'published_at' => $faker->date
]);
