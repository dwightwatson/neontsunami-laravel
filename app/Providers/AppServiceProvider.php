<?php

namespace NeonTsunami\Providers;

use Form;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ViewErrorBag;
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
