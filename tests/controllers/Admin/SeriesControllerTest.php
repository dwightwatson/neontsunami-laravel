<?php

namespace Admin;

use NeonTsunami\Series;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeriesControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
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
        $this->be(factory(User::class)->create());

        $series = factory(Series::class)->make(['slug' => 'foo']);

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
        $series = factory(Series::class)->create();

        $this->action('GET', 'Admin\SeriesController@show', $series);

        $this->assertResponseOk();
        $this->assertViewHas('series');
    }

    public function testEdit()
    {
        $series = factory(Series::class)->create();

        $this->action('GET', 'Admin\SeriesController@edit', $series);

        $this->assertResponseOk();
        $this->assertViewHas('series');
    }

    public function testUpdate()
    {
        $series = factory(Series::class)->create(['slug' => 'foo']);

        $input = array_only($series->getAttributes(), $series->getFillable());

        $input['slug'] = 'bar';

        $this->action('PUT', 'Admin\SeriesController@update', $series, $input);

        $this->assertRedirectedToRoute('admin.series.show', 'bar');
    }

    public function testUpdateFails()
    {
        $series = factory(Series::class)->create(['slug' => 'foo']);

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
        $series = factory(Series::class)->create();

        $this->action('DELETE', 'Admin\SeriesController@destroy', $series);

        $this->assertRedirectedToRoute('admin.series.index');
        $this->assertEquals(0, Series::count());
    }
}
