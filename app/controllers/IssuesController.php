<?php

class IssuesController extends BaseController {

    /**
     * Issue instance.
     *
     * @var Issue
     */
    protected $issue;

    /**
     * Construct the controller.
     *
     * @param  Issue  $issue
     * @return void
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    /**
     * GET /issues
     * Display a list of cultivated issues.
     *
     * @return Response
     */
    public function index()
    {
        $issues = $this->issue->all();

        return View::make('issues.index', compact('issues'))
            ->withTitle('All issues');
    }

    /**
     * GET /issues/1
     * Show a given issue.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $issue = $this->issue->find($id);

        return View::make('issues.show', compact('id', 'issue'))
            ->withTitle('Showing issue');
    }

}
