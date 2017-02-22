<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use App\Series;
use App\Project;

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
