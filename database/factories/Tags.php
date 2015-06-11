<?php

$factory->define(NeonTsunami\Tag::class, function ($faker) {
    return [
        'name' => $faker->word,
        'slug' => $faker->unique()->slug(1),
    ];
});
