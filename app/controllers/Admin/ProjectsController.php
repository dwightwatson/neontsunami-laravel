<?php namespace Admin;

use Project;

use Redirect;
use Request;
use View;

class ProjectsController extends AdminController {

    /**
     * GET /admin/projects
     * Display all of the projects.
     *
     * @return Response
     */
    public function index()
    {
        $projects = Project::latest()->get();

        return View::make('admin.projects.index', compact('projects'))
            ->withTitle('All projects');
    }

    /**
     * GET /admin/projects/create
     * Display the form for creating a new project.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.projects.create')
            ->withTitle('Create projects');
    }

    /**
     * POST /admin/projects
     * Store a new project in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Request::input();

        $project = new Project($input);

        if ( ! $project->save())
        {
            return Redirect::route('admin.projects.create')
                ->withInput()
                ->withErrors($project->getErrors());
        }

        return Redirect::route('admin.projects.show', $project->slug)
            ->withSuccess('The project was created.');
    }

    /**
     * GET /admin/projects/project-slug
     * Display a specified project.
     *
     * @param  Project  $project
     * @return Response
     */
    public function show(Project $project)
    {
        return View::make('admin.projects.show', compact('project'))
            ->withTitle('Show project');
    }

    /**
     * GET /admin/projects/project-slug/edit
     * Display the form for editing a project.
     *
     * @param  Project  $project
     * @return Response
     */
    public function edit(Project $project)
    {
        return View::make('admin.projects.edit', compact('project'))
            ->withTitle('Edit project');
    }

    /**
     * PUT /admin/projects/project-slug
     * Update a given project in storage.
     *
     * @param  Project  $project
     * @return Response
     */
    public function update(Project $project)
    {
        $input = Request::input();

        if ( ! $project->update($input))
        {
            return Redirect::route('admin.projects.edit', $project->getOriginal('slug'))
                ->withErrors($project->getErrors())
                ->withInput();
        }

        return Redirect::route('admin.projects.show', $project->slug)
            ->withSuccess('The project was updated.');
    }

    /**
     * DELETE /admin/projects/project-slug
     * Remove a project from storage.
     *
     * @param  Project  $project
     * @return Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return Redirect::route('admin.projects.index')
            ->withSuccess('The project was deleted.');
    }


}
