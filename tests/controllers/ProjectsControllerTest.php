<?php

use NeonTsunami\Project;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        factory(Project::class, 2)->create();

        $this->action('GET', 'ProjectsController@index');

        $this->assertResponseOk();
        $this->assertViewHas('projects');
    }

    public function testShow()
    {
        $project = factory(Project::class)->create();

        $this->action('GET', 'ProjectsController@show', $project);

        $this->assertResponseOk();
        $this->assertViewHas('project');
    }
}
