<?php

class PagesController extends BaseController {

	/**
	 * Post instance.
	 *
	 * @var Post
	 */
	protected $post;

    /**
     * Project instance.
     *
     * @var Project
     */

    /**
     * Construct the controller.
     *
     * @param  Post  $post
     * @return void
     */
	public function __construct(Post $post, Project $project)
	{
        parent::__construct();

		$this->post = $post;
        $this->project = $project;
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
     * GET /sitemap
     * Return the sitemap.
     *
     * @return Response
     */
    public function sitemap()
    {
        Sitemap::addTag(route('pages.about'));

        $this->getPosts();

        $this->getProjects();

        return Sitemap::renderSitemap();
    }

    /**
     * Get the latest published posts.
     *
     * @param  int  $limit
     * @return void
     */
    protected function getPosts($limit = null)
    {
        $posts = $this->post->published()->latest()->take($limit)->get();

        foreach ($posts as $post)
        {
            Sitemap::addTag(
                route('posts.show', $post->slug),
                $post->updated_at,
                'daily',
                '0.9'
            );
        }
    }

    /**
     * Get the projects.
     *
     * @param  int  $Limit
     * @return void
     */
    protected function getProjects($limit = null)
    {
        $projects = $this->project->alphabetical()->take($limit)->get();

        foreach ($projects as $project)
        {
            Sitemap::addTag(
                route('projects.show', $project->slug),
                $project->updated_at,
                'weekly',
                '0.8'
            );
        }
    }

}
