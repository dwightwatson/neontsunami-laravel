<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsControllerTest extends TestCase
{
    use DatabaseTransactions;

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
