<?php namespace Admin;

use View;

class PagesController extends AdminController {

    /**
     * GET /admin/users
     * Display a listing of users.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('admin.pages.index')
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
        return View::make('admin.pages.reports')
            ->withTitle('Reports');
    }

}
