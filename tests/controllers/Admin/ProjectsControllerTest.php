<?php

namespace Admin;

use NeonTsunami\Project;
use NeonTsunami\User;

use TestCase;
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
        $this->action('GET', 'Admin\ProjectsController@index');

        $this->assertResponseOk();
        $this->assertViewHas('projects');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\ProjectsController@create');

        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->be(factory(User::class)->create());

        $project = factory(Project::class)->make(['slug' => 'foo']);

        $input = array_only($project->getAttributes(), $project->getFillable());

        $this->action('POST', 'Admin\ProjectsController@store', $input);

        $this->assertRedirectedToRoute('admin.projects.show', 'foo');
    }

    public function testStoreFails()
    {
        $this->action('POST', 'Admin\ProjectsController@store');

        $this->assertRedirectedToRoute('admin.projects.create');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testShow()
    {
        $project = factory(Project::class)->create();

        $this->action('GET', 'Admin\ProjectsController@show', $project);

        $this->assertResponseOk();
        $this->assertViewHas('project');
    }

    public function testEdit()
    {
        $project = factory(Project::class)->create();

        $this->action('GET', 'Admin\ProjectsController@edit', $project);

        $this->assertResponseOk();
        $this->assertViewHas('project');
    }

    public function testUpdate()
    {
        $project = factory(Project::class)->create(['slug' => 'foo']);

        $input = array_only($project->getAttributes(), $project->getFillable());

        $input['slug'] = 'bar';

        $this->action('PUT', 'Admin\ProjectsController@update', $project, $input);

        $this->assertRedirectedToRoute('admin.projects.show', 'bar');
    }

    public function testUpdateFails()
    {
        $project = factory(Project::class)->create(['slug' => 'foo']);

        $this->action('PUT', 'Admin\ProjectsController@update', $project, [
            'name' => 'Bar',
            'description' => null
        ]);

        $this->assertRedirectedToRoute('admin.projects.edit', 'foo');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $project = factory(Project::class)->create();

        $this->action('DELETE', 'Admin\ProjectsController@destroy', $project);

        $this->assertRedirectedToRoute('admin.projects.index');
        $this->assertEquals(0, Project::count());
    }
}
