<?php
namespace Admin;

use Project;

use TestCase;
use Laracasts\TestDummy\Factory;

class ProjectsControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(Factory::create('User'));
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
        $project = Factory::build('Project', ['name' => 'Foo']);

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
        $project = Factory::create('Project');

        $this->action('GET', 'Admin\ProjectsController@show', $project->slug);

        $this->assertResponseOk();
        $this->assertViewIs('admin.projects.show');
        $this->assertViewHas('project');
    }

    public function testEdit()
    {
        $project = Factory::create('Project');

        $this->action('GET', 'Admin\ProjectsController@edit', $project->slug);

        $this->assertResponseOk();
        $this->assertViewIs('admin.projects.edit');
        $this->assertViewHas('project');
    }

    public function testUpdate()
    {
        $project = Factory::create('Project', ['slug' => 'foo']);

        $this->action('PUT', 'Admin\ProjectsController@update', $project->slug, [
            'slug' => 'bar'
        ]);

        $this->assertRedirectedToRoute('admin.projects.show', 'bar');
    }

    public function testUpdateFails()
    {
        $project = Factory::create('Project', ['slug' => 'foo']);

        $this->action('PUT', 'Admin\ProjectsController@update', $project->slug, [
            'slug' => 'bar',
            'description' => null
        ]);

        $this->assertRedirectedToRoute('admin.projects.edit', 'foo');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $project = Factory::create('Project');

        $this->action('DELETE', 'Admin\ProjectsController@destroy', $project->slug);

        $this->assertRedirectedToRoute('admin.projects.index');
        $this->assertEquals(0, Project::count());
    }

}
