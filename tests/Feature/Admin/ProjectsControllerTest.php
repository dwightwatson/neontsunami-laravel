<?php

namespace Tests\Feature\Admin;

use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $response = $this->get('/admin/projects');

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get('/admin/projects/create');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $project = factory(Project::class)->make(['slug' => 'foo']);

        $response = $this->post('/admin/projects', $project->getAttributes());

        $response->assertRedirect('/admin/projects/foo');
    }

    public function testStoreFails()
    {
        $response = $this->post('/admin/projects', []);

        $response->assertRedirect('/admin/projects/create');
    }

    public function testShow()
    {
        $project = factory(Project::class)->create();

        $response = $this->get("admin/projects/{$project->slug}");

        $response->assertStatus(200)
            ->assertSee($project->name);
    }

    public function testEdit()
    {
        $project = factory(Project::class)->create();

        $response = $this->get("admin/projects/{$project->slug}/edit");

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $project = factory(Project::class)->create(['slug' => 'foo']);

        $response = $this->put("/admin/projects/{$project->slug}", [
            'slug' => 'bar'
        ]);

        $response->assertRedirect('/admin/projects/bar');
    }

    public function testUpdateFails()
    {
        $project = factory(Project::class)->create(['slug' => 'foo']);

        $response = $this->put("/admin/projects/{$project->slug}", [
            'url' => 'invalid'
        ]);

        $response->assertRedirect("/admin/projects/{$project->slug}/edit");
    }

    public function testDestroy()
    {
        $project = factory(Project::class)->create();

        $response = $this->delete("/admin/projects/{$project->slug}");

        $response->assertRedirect('/admin/projects');

        $this->assertEquals(0, Project::count());
    }
}
