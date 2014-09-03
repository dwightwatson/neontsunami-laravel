<?php

class SeriesController extends BaseController {

    /**
     * Series instance.
     *
     * @var Series
     */
    protected $series;

    /**
     * Construct the controlller.
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
     * GET /series
     * Get a listing of all series.
     *
     * @return Response
     */
    public function index()
    {
        $series = $this->series->whereHas('posts', function($query)
            {
                $query->published();
            })
            ->paginate(25);

        $page = Input::get('page');
        $title = $page ? "All series (Page {$page})" : 'All series';

        return View::make('series.index', compact('series'))
            ->withTitle($title);
    }

    /**
     * GET /series/series-slug
     * Get a single series.
     *
     * @param  Series  $series
     * @return Response
     */
    public function show(Series $series)
    {
        $posts = $series->posts()->published()->paginate();

        return View::make('series.show', compact('series', 'posts'))
            ->withTitle($series->name)
            ->withDescription(str_limit($series->description, 160));
    }

}
