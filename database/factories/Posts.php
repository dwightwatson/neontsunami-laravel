<?php

$factory->define(App\Post::class, function ($faker) {
    return [
        'title'        => $faker->sentence,
        'slug'         => $faker->unique()->slug(1),
        'content'      => $faker->sentence,
        'published_at' => $faker->date
    ];
});
