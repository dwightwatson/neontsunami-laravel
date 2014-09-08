<?php

class SitemapsController extends BaseController {

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
    protected $project;

    /**
     * Series instance.
     *
     * @var Series
     */
    protected $series;

    /**
     * Construct the controller.
     *
     * @param  Post     $post
     * @param  Project  $project
     * @param  Series   $series
     * @return void
     */
    public function __construct(Post $post, Project $project, Series $series)
    {
        parent::__construct();

        $this->post = $post;
        $this->project = $project;
        $this->series = $series;
    }

    /**
     * GET /sitemap
     * Return the sitemap.
     *
     * @return Response
     */
    public function index()
    {
        Sitemap::addTag(route('pages.about'));

        $this->getPosts();
        $this->getProjects();
        $this->getSeries();

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

    /**
     * Get the series.
     *
     * @param  int  $limit
     * @return void
     */
    protected function getSeries($limit = null)
    {
        $series = $this->series->whereHas('posts', function($query)
            {
                $query->published();
            })
            ->take($limit)
            ->get();

        foreach ($series as $singleSeries)
        {
            Sitemap::addTag(
                route('series.show', $singleSeries->slug),
                $singleSeries->updated_at,
                'weekly',
                '0.8'
            );
        }
    }

}
