<?php namespace Admin;

use Series;
use Redirect, Request, View;

class SeriesController extends AdminController {

    /**
     * Series instance.
     *
     * @var Series
     */
    protected $series;

    /**
     * Construct the controller.
     *
     * @param  Series  $series
     * @return void
     */
    public function __construct(Series $series)
    {
        parent::__construct();

        $this->series = $series;
    }

    /**
     * GET /admin/series
     * Display all of the series.
     *
     * @return Response
     */
    public function index()
    {
        $series = $this->series->with('posts')
            ->latest()
            ->paginate(25);

        return View::make('admin.series.index', compact('series'))
            ->withTitle('All series');
    }

    /**
     * GET /admin/series/create
     * Display the form for creating a new series.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.series.create')
            ->withTitle('Create series');
    }

    /**
     * POST /admin/series
     * Store a new series in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = Request::input();

        $series = $this->series->fill($input);

        if ( ! $series->save())
        {
            return Redirect::route('admin.series.create')
                ->withInput()
                ->withErrors($series->getErrors());
        }

        return Redirect::route('admin.series.show', $series->slug)
            ->withSuccess('The series was created.');
    }

    /**
     * GET /admin/series/series-slug
     * Display a specified series.
     *
     * @param  Series  $series
     * @return Response
     */
    public function show(Series $series)
    {
        return View::make('admin.series.show', compact('series'))
            ->withTitle('Show series');
    }

    /**
     * GET /admin/series/series-slug/edit
     * Display the form for editing a series.
     *
     * @param  Series  $series
     * @return Response
     */
    public function edit(Series $series)
    {
        return View::make('admin.series.edit', compact('series'))
            ->withTitle('Edit series');
    }

    /**
     * PUT /admin/series/series-slug
     * Update a given series in storage.
     *
     * @param  Series  $series
     * @return Response
     */
    public function update(Series $series)
    {
        $input = Request::input();

        if ( ! $series->update($input))
        {
            return Redirect::route('admin.series.edit', $series->getOriginal('slug'))
                ->withErrors($series->getErrors())
                ->withInput();
        }

        return Redirect::route('admin.series.show', $series->slug)
            ->withSuccess('The series was updated.');
    }

    /**
     * DELETE /admin/series/series-slug
     * Remove a series from storage.
     *
     * @param  Series  $series
     * @return Response
     */
    public function destroy(Series $series)
    {
        $series->delete();

        return Redirect::route('admin.series.index')
            ->withSuccess('The series was deleted.');
    }


}
