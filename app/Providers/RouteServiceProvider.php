<?php

namespace NeonTsunami\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'NeonTsunami\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $router->bind('posts', function ($value, $route) {
            return \NeonTsunami\Post::whereSlug($value)->firstOrFail();
        });

        $router->bind('series', function ($value, $route) {
            return \NeonTsunami\Series::whereSlug($value)->firstOrFail();
        });

        $router->bind('tags', function ($value, $route) {
            return \NeonTsunami\Tag::whereSlug($value)->firstOrFail();
        });

        $router->bind('projects', function ($value, $route) {
            return \NeonTsunami\Project::whereSlug($value)->firstOrFail();
        });

        $router->model('users', \NeonTsunami\User::class);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
