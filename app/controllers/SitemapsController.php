<?php

class SitemapsController extends BaseController {

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
        $posts = Post::published()->latest()->take($limit)->get();

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
        $projects = Project::alphabetical()->take($limit)->get();

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
        $series = Series::whereHas('posts', function($query)
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
