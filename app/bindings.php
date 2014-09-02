<?php

Route::bind('posts', function($value, $route)
{
    return Post::whereSlug($value)->firstOrFail();
});

Route::bind('series', function($value, $route)
{
    return Series::whereSlug($value)->firstOrFail();
});

Route::bind('tags', function($value, $route)
{
    return Tag::whereSlug($value)->firstOrFail();
});

Route::bind('projects', function($value, $route)
{
    return Project::whereSlug($value)->firstOrFail();
});

Route::model('users', 'User');
