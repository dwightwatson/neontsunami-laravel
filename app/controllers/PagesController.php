<?php

class PagesController extends BaseController {

	/**
	 * Post instance.
	 *
	 * @var Post
	 */
	protected $post;

    /**
     * Construct the controller.
     *
     * @param  Post  $post
     * @return void
     */
	public function __construct(Post $post)
	{
        parent::__construct();

		$this->post = $post;
	}

	/**
	 * GET /
	 * The home page.
	 *
	 * @return Response
	 */
	public function index()
	{
		$latestPost = $this->post->with('tags')->published()->latest()->take(1)->first();

		$popularPosts = $this->post->published()
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
		$posts = $this->getPosts(100);

		if ($posts->count()) $updated = $posts->first()->updated_at;

		return Response::view('pages.rss', compact('posts', 'updated'), 200, [
			'Content-Type' => 'application/rss+xml; charset=UTF-8'
		]);
	}

    /**
     * Get the latest published posts.
     *
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getPosts($limit = null)
    {
        return $this->post->published()->latest()->take($limit)->get();
    }

}
