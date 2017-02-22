<?php

namespace App\Providers;

use Form;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ViewErrorBag;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        Form::macro('hasErrors', function ($names, $class = 'has-error') {
            foreach ((array) $names as $name) {
                if (session()->get('errors', new ViewErrorBag)->has($name)) {
                    return $class;
                }
            }
        });

        Form::macro('errors', function ($name, $format = '<span class="help-block">:message</span>') {
            return new HtmlString(session()->get('errors', new ViewErrorBag)->first($name, $format));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
