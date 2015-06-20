<?php

use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    public function testItLoadsHomePage()
    {
        $this->visit('/');
    }

    public function testItRedirectsToLoginPage()
    {
        $this->visit('admin')
            ->seePageIs('admin/login');
    }

    public function testItLogsInUserWithCorrectCredentials()
    {
        $credentials = [
            'email'    => 'test@example.com',
            'password' => 'password'
        ];

        $user = factory(User::class)->create($credentials);

        $this->visit('admin/login')
            ->submitForm('Login', $credentials)
            ->seePageIs('admin');
    }

    public function testItDoesNotLoginUserWithIncorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email'    => 'test@example.com',
            'password' => 'password'
        ]);

        $this->visit('admin/login')
            ->submitForm('Login', [
                'email'    => 'test@example.com',
                'password' => 'secret'
            ])
            ->see('Your login credentials were invalid.')
            ->seePageIs('admin/login');
    }
}
