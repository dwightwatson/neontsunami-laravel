<?php

namespace NeonTsunami\Http\Controllers\Admin;

use NeonTsunami\Project;
use NeonTsunami\Http\Requests\Projects\StoreProjectRequest;
use NeonTsunami\Http\Requests\Projects\UpdateProjectRequest;

class ProjectsController extends Controller
{
    /**
     * GET /admin/projects
     * Display all of the projects.
     *
     * @return Response
     */
    public function index()
    {
        $projects = Project::latest()->get();

        return view('admin.projects.index', compact('projects'))
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
        return view('admin.projects.create')
            ->withTitle('Create projects');
    }

    /**
     * POST /admin/projects
     * Store a new project in storage.
     *
     * @param  StoreProjectRequest  $request
     * @return Response
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
     * @param  Project  $project
     * @return Response
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
     * @param  Project  $project
     * @return Response
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
     * @param  Request  $request
     * @param  UpdateProjectRequest  $project
     * @return Response
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
     * @param  Project  $project
     * @return Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->withSuccess('The project was deleted.');
    }
}
