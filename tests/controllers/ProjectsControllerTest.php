<?php

use NeonTsunami\Project;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class ProjectsControllerTest extends DbTestCase {

    public function testIndex()
    {
        $projects = Factory::times(2)->create(Project::class);

        $this->action('GET', 'ProjectsController@index');

        $this->assertResponseOk();
        $this->assertViewIs('projects.index');
        $this->assertViewHas('projects');
    }

    public function testShow()
    {
        $project = Factory::create(Project::class);

        $this->action('GET', 'ProjectsController@show', $project);

        $this->assertResponseOk();
        $this->assertViewIs('projects.show');
        $this->assertViewHas('project');
    }

}
