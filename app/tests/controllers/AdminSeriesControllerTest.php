<?php

use Laracasts\TestDummy\Factory;

class AdminSeriesControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\SeriesController@index');

        $this->assertResponseOk();
        $this->assertViewIs('admin.series.index');
        $this->assertViewHas('series');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\SeriesController@create');

        $this->assertResponseOk();
        $this->assertViewIs('admin.series.create');
    }

    public function testStore()
    {
        $series = Factory::build('Series', ['name' => 'Foo']);

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
        $series = Factory::create('Series');

        $this->action('GET', 'Admin\SeriesController@show', $series->slug);

        $this->assertResponseOk();
        $this->assertViewIs('admin.series.show');
        $this->assertViewHas('series');
    }

    public function testEdit()
    {
        $series = Factory::create('Series');

        $this->action('GET', 'Admin\SeriesController@edit', $series->slug);

        $this->assertResponseOk();
        $this->assertViewIs('admin.series.edit');
        $this->assertViewHas('series');
    }

    public function testUpdate()
    {
        $series = Factory::create('Series', ['slug' => 'foo']);

        $this->action('PUT', 'Admin\SeriesController@update', $series->slug, [
            'slug' => 'bar'
        ]);

        $this->assertRedirectedToRoute('admin.series.show', 'bar');
    }

    public function testUpdateFails()
    {
        $series = Factory::create('Series', ['slug' => 'foo']);

        $this->action('PUT', 'Admin\SeriesController@update', $series->slug, [
            'slug' => 'bar',
            'description' => null
        ]);

        $this->assertRedirectedToRoute('admin.series.edit', 'foo');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $series = Factory::create('Series');

        $this->action('DELETE', 'Admin\SeriesController@destroy', $series->slug);

        $this->assertRedirectedToRoute('admin.series.index');
        $this->assertEquals(0, Series::count());
    }

}
