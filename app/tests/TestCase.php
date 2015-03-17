<?php

use Laracasts\TestDummy\Factory;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	use Watson\Testing\TestingTrait;

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

    public function setUp()
    {
        parent::setUp();

        Factory::$factoriesPath = 'app/tests/factories';

        $this->resetEvents();

        Artisan::call('migrate');
    }

    public function tearDown()
    {
        parent::tearDown();

        Artisan::call('migrate:reset');
    }

    /**
     * Flush and reboot Eloquent model events.
     *
     * @return void
     */
    public function resetEvents()
    {
        foreach ($this->getModels() as $model)
        {
            call_user_func([$model, 'flushEventListeners']);

            call_user_func([$model, 'boot']);
        }
    }

    /**
     * Get the model names from their filename.
     *
     * @return array
     */
    protected function getModels()
    {
        $files = File::files(base_path() . '/app/models');

        foreach ($files as $file)
        {
            $models[] = pathinfo($file, PATHINFO_FILENAME);
        }

        return $models;
    }

}
