<?php

class SeriesController extends BaseController {

    /**
     * GET /series
     * Get a listing of all series.
     *
     * @return Response
     */
    public function index()
    {
        $series = Series::whereHas('posts', function($query)
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
