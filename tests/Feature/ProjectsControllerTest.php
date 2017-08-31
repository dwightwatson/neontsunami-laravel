<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $project = factory(Project::class)->create();

        $response = $this->get('/projects');

        $response->assertStatus(200)
            ->assertSee('Projects')
            ->assertSee($project->name);
    }

    public function testShow()
    {
        $project = factory(Project::class)->create();

        $response = $this->get("/projects/{$project->slug}");

        $response->assertStatus(200)
            ->assertSee($project->name)
            ->assertSee($project->description);
    }
}
