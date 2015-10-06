<?php

namespace NeonTsunami\Http\Controllers;

use NeonTsunami\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * GET /series
     * Get a listing of all series.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $series = Series::whereHas('posts', function ($query) {
                $query->published();
            })->paginate(25);

        $page = $request->get('page');
        $title = $page ? "All series (Page {$page})" : 'All series';

        return view('series.index', compact('series'))
            ->withTitle($title);
    }

    /**
     * GET /series/series-slug
     * Get a single series.
     *
     * @param  \NeonTsunami\Series  $series
     * @return \Illuminate\View\View
     */
    public function show(Series $series)
    {
        $posts = $series->posts()->published()->paginate();

        return view('series.show', compact('series', 'posts'))
            ->withTitle($series->name)
            ->withDescription(str_limit($series->description, 160));
    }
}
