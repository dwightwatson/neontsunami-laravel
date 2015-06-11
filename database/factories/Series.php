<?php

$factory->define(NeonTsunami\Series::class, function ($faker) {
    return [
        'name'        => $faker->word,
        'slug'        => $faker->unique()->slug(1),
        'description' => $faker->sentence
    ];
});
