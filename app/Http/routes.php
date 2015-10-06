<?php

/*
|--------------------------------------------------------------------------
| Redirects
|--------------------------------------------------------------------------
*/
Route::get('post/{postSlug}', 'RedirectsController@getPost');
Route::get('tag/{tagSlug}', 'RedirectsController@getTag');
Route::get('archive', 'RedirectsController@getArchive');

Route::get('tags/mac%20os%20x', 'RedirectsController@getTagsMacOsX');
Route::get('tags/ruby%20on%20rails', 'RedirectsController@getTagsRubyOnRails');

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', ['as' => 'admin.pages.index', 'uses' => 'PagesController@index']);

    Route::get('login', ['as' => 'admin.sessions.create', 'uses' => 'SessionsController@create']);
    Route::post('login', ['as' => 'admin.sessions.store', 'uses' => 'SessionsController@store']);
    Route::delete('logout', ['as' => 'admin.sessions.destroy', 'uses' => 'SessionsController@destroy']);

    Route::resource('tags', 'TagsController', ['only' => 'index']);
    Route::resource('posts', 'PostsController');
    Route::resource('series', 'SeriesController');
    Route::resource('projects', 'ProjectsController');
    Route::resource('users', 'UsersController');

    Route::get('reports', ['as' => 'admin.pages.reports', 'uses' => 'PagesController@reports']);
});

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', ['as' => 'pages.index', 'uses' => 'PagesController@index']);
Route::get('about', ['as' => 'pages.about', 'uses'=> 'PagesController@about']);
Route::get('rss', ['as' => 'pages.rss', 'uses' => 'PagesController@rss']);

Route::get('sitemap', ['as' => 'sitemaps.index', 'uses' => 'SitemapsController@index']);

Route::resource('posts', 'PostsController', ['only' => ['index', 'show']]);
Route::resource('series', 'SeriesController', ['only' => ['index', 'show']]);
Route::resource('tags', 'TagsController', ['only' => ['index', 'show']]);
Route::resource('projects', 'ProjectsController', ['only' => ['index', 'show']]);
