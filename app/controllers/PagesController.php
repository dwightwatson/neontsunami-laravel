<?php

class PagesController extends BaseController {

    /**
     * GET /
     * The home page.
     *
     * @return Response
     */
    public function index()
    {
        $latestPost = Post::with('tags')->published()->latest()->take(1)->first();

        $popularPosts = Post::published()
            ->with('tags')
            ->where('id', '!=', $latestPost->id)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return View::make('pages.index', compact('latestPost', 'popularPosts'))
            ->withTitle('A blog on Laravel & Rails');
    }

    /**
     * GET /about
     * The about page.
     *
     * @return Response
     */
    public function about()
    {
        return View::make('pages.about')
            ->withTitle('About');
    }

    /**
     * GET /rss
     * Return the RSS feed of posts.
     *
     * @return Response
     */
    public function rss()
    {
        $posts = Post::published()->latest()->take(100)->get();

        if ($posts->count()) $updated = $posts->first()->updated_at;

        return Response::view('pages.rss', compact('posts', 'updated'), 200, [
            'Content-Type' => 'application/rss+xml; charset=UTF-8'
        ]);
    }

}
