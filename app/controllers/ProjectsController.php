<?php

class ProjectsController extends BaseController {

    /**
     * Project instance.
     *
     * @var Project
     */
    protected $project;

    /**
     * Construct the controller.
     *
     * @param  Project  $project
     * @return void
     */
    public function __construct(Project $project)
    {
        parent::__construct();

        $this->project = $project;
    }

    /**
     * GET /projects
     * Get a listing of all projects.
     *
     * @return Response
     */
    public function index()
    {
        $projects = $this->project->latest()->paginate(25);

        $page = Input::get('page');
        $title = $page ? "All projects (Page {$page})" : 'All projects';

        return View::make('projects.index', compact('projects'))
            ->withTitle($title);
    }

    /**
     * GET /projects/project-slug
     * Get a single project.
     *
     * @param  Project  $project
     * @return Response
     */
    public function show(Project $project)
    {
        return View::make('projects.show', compact('project'))
            ->withTitle($project->name)
            ->withDescription(str_limit($project->description, 160));
    }

}
