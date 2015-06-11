<?php

$factory->define(NeonTsunami\Post::class, function ($faker) {
    return [
        'title'        => $faker->word,
        'slug'         => $faker->unique()->slug(1),
        'content'      => $faker->sentence,
        'published_at' => $faker->date
    ];
});
