<?php namespace Admin;

use NeonTsunami\Project;
use NeonTsunami\User;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class ProjectsControllerTest extends DbTestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(Factory::create(User::class));
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\ProjectsController@index');

        $this->assertResponseOk();
        $this->assertViewIs('admin.projects.index');
        $this->assertViewHas('projects');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\ProjectsController@create');

        $this->assertResponseOk();
        $this->assertViewIs('admin.projects.create');
    }

    public function testStore()
    {
        $project = Factory::build(Project::class, ['slug' => 'foo']);

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
        $project = Factory::create(Project::class);

        $this->action('GET', 'Admin\ProjectsController@show', $project);

        $this->assertResponseOk();
        $this->assertViewIs('admin.projects.show');
        $this->assertViewHas('project');
    }

    public function testEdit()
    {
        $project = Factory::create(Project::class);

        $this->action('GET', 'Admin\ProjectsController@edit', $project);

        $this->assertResponseOk();
        $this->assertViewIs('admin.projects.edit');
        $this->assertViewHas('project');
    }

    public function testUpdate()
    {
        $project = Factory::create(Project::class, ['slug' => 'foo']);

        $input = array_only($project->getAttributes(), $project->getFillable());

        $input['slug'] = 'bar';

        $this->action('PUT', 'Admin\ProjectsController@update', $project, $input);

        $this->assertRedirectedToRoute('admin.projects.show', 'bar');
    }

    public function testUpdateFails()
    {
        $project = Factory::create(Project::class, ['slug' => 'foo']);

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
        $project = Factory::create(Project::class);

        $this->action('DELETE', 'Admin\ProjectsController@destroy', $project);

        $this->assertRedirectedToRoute('admin.projects.index');
        $this->assertEquals(0, Project::count());
    }

}
