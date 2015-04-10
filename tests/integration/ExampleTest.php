<?php

use NeonTsunami\User;

use Laracasts\TestDummy\Factory;
use Laracasts\Integrated\Services\Laravel\DatabaseTransactions;

class ExampleTest extends TestCase {

	use DatabaseTransactions;

	public function itLoadsHomePage()
	{
		$this->visit('/');
	}

	public function itRedirectsToLoginPage()
	{
		$this->visit('admin')
			->seePageIs('admin/login');
	}

	public function itLogsInUserWithCorrectCredentials()
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

	public function itDoesNotLoginUserWithIncorrectCredentials()
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
