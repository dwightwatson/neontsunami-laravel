<?php

namespace App\Http\Controllers\Admin;

use App\Project;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;

class ProjectsController extends Controller
{
    /**
     * GET /admin/projects
     * Display all of the projects.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::latest()->paginate(25);

        return view('admin.projects.index', compact('projects'))
            ->withTitle('All projects');
    }

    /**
     * GET /admin/projects/create
     * Display the form for creating a new project.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.projects.create')
            ->withTitle('Create projects');
    }

    /**
     * POST /admin/projects
     * Store a new project in storage.
     *
     * @param  \App\Http\Requests\Projects\StoreProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->all());

        return redirect()->route('admin.projects.show', $project)
            ->withSuccess('The project was created.');
    }

    /**
     * GET /admin/projects/project-slug
     * Display a specified project.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\View\View
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'))
            ->withTitle('Show project');
    }

    /**
     * GET /admin/projects/project-slug/edit
     * Display the form for editing a project.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'))
            ->withTitle('Edit project');
    }

    /**
     * PUT /admin/projects/project-slug
     * Update a given project in storage.
     *
     * @param  \App\Project  $request
     * @param  \App\Http\Requests\Projects\UpdateProjectRequest  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $project->update($request->all());

        return redirect()->route('admin.projects.show', $project)
            ->withSuccess('The project was updated.');
    }

    /**
     * DELETE /admin/projects/project-slug
     * Remove a project from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->withSuccess('The project was deleted.');
    }
}
