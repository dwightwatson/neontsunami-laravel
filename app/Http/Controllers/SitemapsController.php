<?php

namespace App\Http\Controllers;

use Sitemap;
use App\Post;
use App\Project;
use App\Series;

class SitemapsController extends Controller
{
    /**
     * GET /sitemap
     * Return the sitemap.
     *
     * @return \Illuminate\Http\Response
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

        foreach ($posts as $post) {
            Sitemap::addTag(
                route('posts.show', $post),
                $post,
                'daily',
                '0.9'
            );
        }
    }

    /**
     * Get the projects.
     *
     * @param  int  $limit
     * @return void
     */
    protected function getProjects($limit = null)
    {
        $projects = Project::alphabetical()->take($limit)->get();

        foreach ($projects as $project) {
            Sitemap::addTag(
                route('projects.show', $project),
                $project,
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
        $series = Series::whereHas('posts', function ($query) {
            $query->published();
        })
            ->take($limit)
            ->get();

        foreach ($series as $singleSeries) {
            Sitemap::addTag(
                route('series.show', $singleSeries),
                $singleSeries,
                'weekly',
                '0.8'
            );
        }
    }
}
