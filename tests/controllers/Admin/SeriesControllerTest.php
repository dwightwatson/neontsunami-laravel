<?php namespace Admin;

use NeonTsunami\Series;
use NeonTsunami\User;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class SeriesControllerTest extends DbTestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(Factory::create(User::class));
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\SeriesController@index');

        $this->assertResponseOk();
        $this->assertViewHas('series');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\SeriesController@create');

        $this->assertResponseOk();
    }

    public function testStore()
    {
        $series = Factory::build(Series::class, ['slug' => 'foo']);

        $input = array_only($series->getAttributes(), $series->getFillable());

        $this->action('POST', 'Admin\SeriesController@store', $input);

        $this->assertRedirectedToRoute('admin.series.show', 'foo');
    }

    public function testStoreFails()
    {
        $this->action('POST', 'Admin\SeriesController@store');

        $this->assertRedirectedToRoute('admin.series.create');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testShow()
    {
        $series = Factory::create(Series::class);

        $this->action('GET', 'Admin\SeriesController@show', $series);

        $this->assertResponseOk();
        $this->assertViewHas('series');
    }

    public function testEdit()
    {
        $series = Factory::create(Series::class);

        $this->action('GET', 'Admin\SeriesController@edit', $series);

        $this->assertResponseOk();
        $this->assertViewHas('series');
    }

    public function testUpdate()
    {
        $series = Factory::create(Series::class, ['slug' => 'foo']);

        $input = array_only($series->getAttributes(), $series->getFillable());

        $input['slug'] = 'bar';

        $this->action('PUT', 'Admin\SeriesController@update', $series, $input);

        $this->assertRedirectedToRoute('admin.series.show', 'bar');
    }

    public function testUpdateFails()
    {
        $series = Factory::create(Series::class, ['slug' => 'foo']);

        $this->action('PUT', 'Admin\SeriesController@update', $series, [
            'name' => 'Bar',
            'description' => null
        ]);

        $this->assertRedirectedToRoute('admin.series.edit', 'foo');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $series = Factory::create(Series::class);

        $this->action('DELETE', 'Admin\SeriesController@destroy', $series);

        $this->assertRedirectedToRoute('admin.series.index');
        $this->assertEquals(0, Series::count());
    }

}
