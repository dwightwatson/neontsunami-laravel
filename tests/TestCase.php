<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Ideally we'd like to bypass the middleware when testing, however
        // this breaks Former because of it's hard dependency on sessions. With
        // middleware enabled however, forms check for a valid CSRF token.

        // This replaces the app's CSRF middleware with and override that exempts
        // all routes from CSRF protection.

        $this->app->instance('NeonTsunami\Http\Middleware\VerifyCsrfToken', $this->app->make('VerifyCsrfToken'));;
    }
}

class VerifyCsrfToken extends NeonTsunami\Http\Middleware\VerifyCsrfToken
{
    protected $except = ['*'];
}
