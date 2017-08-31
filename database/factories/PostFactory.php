<?php

$factory->define(App\Post::class, function ($faker) {
    return [
        'user_id'      => factory(App\User::class),
        'title'        => $faker->sentence,
        'slug'         => $faker->unique()->slug(1),
        'content'      => $faker->sentence,
        'published_at' => $faker->date
    ];
});
