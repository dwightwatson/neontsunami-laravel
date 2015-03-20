<?php

$factory('NeonTsunami\Tag', [
    'name'        => $faker->name,
    'slug'        => $faker->unique()->slug(1),
]);
