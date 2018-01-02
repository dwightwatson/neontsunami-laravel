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
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', 'PagesController@index')->name('pages.index');
Route::get('about', 'PagesController@about')->name('pages.about');
ROute::get('rss', 'PagesController@rss')->name('pages.rss');

Route::get('sitemap', 'SitemapsController@index')->name('sitemaps.index');

Route::resource('posts', 'PostsController', ['only' => ['index', 'show']]);
Route::resource('series', 'SeriesController', ['only' => ['index', 'show']]);
Route::resource('tags', 'TagsController', ['only' => ['index', 'show']]);
Route::resource('projects', 'ProjectsController', ['only' => ['index', 'show']]);

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'PagesController@index')->name('pages.index');

    Route::get('login', 'SessionsController@create')->name('sessions.create');
    Route::post('login', 'SessionsController@store')->name('sessions.store');
    Route::delete('logout', 'SessionsController@destroy')->name('sessions.destroy');

    Route::resource('tags', 'TagsController', ['only' => ['index', 'store']]);
    Route::resource('posts', 'PostsController');
    Route::resource('series', 'SeriesController');
    Route::resource('projects', 'ProjectsController');
    Route::resource('users', 'UsersController');

    Route::get('reports', 'PagesController@reports')->name('pages.reports');
});
