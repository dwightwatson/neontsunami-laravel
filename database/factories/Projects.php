<?php

$factory->define(NeonTsunami\Project::class, function ($faker) {
    return [
        'name'        => $faker->word,
        'slug'        => $faker->unique()->slug(1),
        'description' => $faker->sentence
    ];
});
