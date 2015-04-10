<?php

use NeonTsunami\User;

use Laracasts\TestDummy\Factory;
use Laracasts\Integrated\Services\Laravel\DatabaseTransactions;

class ExampleTest extends TestCase {

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

		$user = Factory::create(User::class, $credentials);

		$this->visit('admin/login')
			->submitForm('Login', $credentials)
			->seePageIs('admin');
	}

	public function testItDoesNotLoginUserWithIncorrectCredentials()
	{
		$user = Factory::create(User::class, [
		    'email'    => 'test@example.com',
		    'password' => 'password'
		]);

		$this->visit('admin/login')
			->submitForm('Login', [
				'email'    => 'test@example.com',
				'password' => 'secret'
			])
			->andSee('Your login credentials were invalid.')
			->seePageIs('admin/login');
	}

}
