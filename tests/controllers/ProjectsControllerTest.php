<?php

use NeonTsunami\Project;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $project = factory(Project::class)->create();

        $this->visit('projects')
            ->see('Projects')
            ->see($project->title);
    }

    public function testShow()
    {
        $project = factory(Project::class)->create();

        $this->visit("projects/{$project->slug}")
            ->see($project->title)
            ->see($project->description);
    }
}
