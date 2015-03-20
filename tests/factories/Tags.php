<?php

$factory('NeonTsunami\Tag', [
    'name'        => $faker->word,
    'slug'        => $faker->unique()->slug(1),
]);
