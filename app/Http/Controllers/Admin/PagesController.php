<?php namespace NeonTsunami\Http\Controllers\Admin;

class PagesController extends Controller {

    /**
     * GET /admin/users
     * Display a listing of users.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.pages.index')
            ->withTitle('Admin');
    }

    /**
     * GET /admin/reports
     * Display statistic reports.
     *
     * @return Response
     */
    public function reports()
    {
        return view('admin.pages.reports')
            ->withTitle('Reports');
    }

}
