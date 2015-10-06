<?php

namespace NeonTsunami\Http\Controllers\Admin;

use NeonTsunami\Post;
use NeonTsunami\User;
use NeonTsunami\Series;
use NeonTsunami\Project;

class PagesController extends Controller
{
    /**
     * GET /admin/users
     * Display a listing of users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $postsCount = Post::count();

        $seriesCount = Series::count();

        $projectsCount = Project::count();

        $usersCount = User::count();

        return view('admin.pages.index', compact('postsCount', 'seriesCount', 'projectsCount', 'usersCount'))
            ->withTitle('Admin');
    }

    /**
     * GET /admin/reports
     * Display statistic reports.
     *
     * @return \Illuminate\View\View
     */
    public function reports()
    {
        return view('admin.pages.reports')
            ->withTitle('Reports');
    }
}
