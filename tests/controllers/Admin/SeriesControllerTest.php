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
        $this->visit('admin/series');
    }

    public function testCreate()
    {
        $this->visit('admin/series/create');
    }

    public function testStore()
    {
        $series = factory(Series::class)->make(['slug' => 'foo']);

        $this->visit('admin/series/create')
            ->submitForm('Create series', $series->getAttributes())
            ->seePageis('admin/series/foo')
            ->see($series->name);
    }

    public function testStoreFails()
    {
        $this->visit('admin/series/create')
            ->submitForm('Create series')
            ->seePageis('admin/series/create');
    }

    public function testShow()
    {
        $series = factory(Series::class)->create();

        $this->visit("admin/series/{$series->slug}")
            ->see($series->name);
    }

    public function testEdit()
    {
        $series = factory(Series::class)->create();

        $this->visit("admin/series/{$series->slug}/edit");
    }

    public function testUpdate()
    {
        $series = factory(Series::class)->create(['slug' => 'foo']);

        $this->visit("admin/series/foo/edit")
            ->submitForm('Save series', ['slug' => 'bar'])
            ->seePageIs('admin/series/bar');
    }

    public function testUpdateFails()
    {
        $series = factory(Series::class)->create(['slug' => 'foo']);

        $this->visit("admin/series/foo/edit")
            ->submitForm('Save series', ['description' => null])
            ->seePageIs('admin/series/foo/edit');
    }

    public function testDestroy()
    {
        $series = factory(Series::class)->create();

        $this->action('DELETE', 'Admin\SeriesController@destroy', $series);

        $this->assertRedirectedToRoute('admin.series.index');
        $this->assertEquals(0, Series::count());
    }
}
