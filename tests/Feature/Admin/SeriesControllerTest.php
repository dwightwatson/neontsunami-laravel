<?php

namespace Tests\Feature\Admin;

use App\User;
use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $response = $this->get('/admin/series');

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get('/admin/series/create');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $series = factory(Series::class)->make(['slug' => 'foo']);

        $response = $this->post('/admin/series', $series->getAttributes());

        $response->assertRedirect('/admin/series/foo');
    }

    public function testStoreFails()
    {
        $response = $this->post('/admin/series', []);

        $response->assertRedirect('/admin/series/create');
    }

    public function testShow()
    {
        $series = factory(Series::class)->create();

        $response = $this->get("/admin/series/{$series->slug}");

        $response->assertStatus(200)
            ->assertSee($series->name);
    }

    public function testEdit()
    {
        $series = factory(Series::class)->create();

        $response = $this->get("admin/series/{$series->slug}/edit");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $series = factory(Series::class)->create(['slug' => 'foo']);

        $response = $this->put("/admin/series/{$series->slug}", [
            'slug' => 'bar'
        ]);

        $response->assertRedirect('/admin/series/bar');
    }

    public function testUpdateFails()
    {
        $series = factory(Series::class)->create(['slug' => 'foo']);
        factory(Series::class)->create(['slug' => 'bar']);

        $response = $this->put("/admin/series/{$series->slug}", [
            'slug' => 'bar'
        ]);

        $response->assertRedirect('/admin/series/foo/edit');
    }

    public function testDestroy()
    {
        $series = factory(Series::class)->create();

        $response = $this->delete("/admin/series/{$series->slug}");

        $response->assertRedirect('/admin/series');

        $this->assertEquals(0, Series::count());
    }
}
