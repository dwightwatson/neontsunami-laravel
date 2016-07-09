<?php

namespace Admin;

use NeonTsunami\Project;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $this->visit('admin/projects');
    }

    public function testCreate()
    {
        $this->visit('admin/projects/create');
    }

    public function testStore()
    {
        $project = factory(Project::class)->make(['slug' => 'foo']);

        $this->visit('admin/projects/create')
            ->submitForm('Create project', $project->getAttributes())
            ->seePageIs('admin/projects/foo')
            ->see($project->title);
    }

    public function testStoreFails()
    {
        $this->visit('admin/projects/create')
            ->submitForm('Create project')
            ->seePageIs('admin/projects/create');
    }

    public function testShow()
    {
        $project = factory(Project::class)->create();

        $this->visit("admin/projects/{$project->slug}")
            ->see($project->name);
    }

    public function testEdit()
    {
        $project = factory(Project::class)->create();

        $this->visit("admin/projects/{$project->slug}/edit");
    }

    public function testUpdate()
    {
        $project = factory(Project::class)->create(['slug' => 'foo']);

        $this->visit('admin/projects/foo/edit')
            ->submitForm('Save project', ['slug' => 'bar'])
            ->seePageIs('admin/projects/bar');
    }

    public function testUpdateFails()
    {
        $project = factory(Project::class)->create(['slug' => 'foo']);

        $this->visit('admin/projects/foo/edit')
            ->submitForm('Save project', ['description' => null])
            ->seePageIs('admin/projects/foo/edit');
    }

    public function testDestroy()
    {
        $project = factory(Project::class)->create();

        $this->action('DELETE', 'Admin\ProjectsController@destroy', $project);

        $this->assertRedirectedToRoute('admin.projects.index');
        $this->assertEquals(0, Project::count());
    }
}
