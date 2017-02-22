<?php

$factory->define(App\Tag::class, function ($faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->unique()->slug(1),
    ];
});
