<?php

namespace NeonTsunami\Http\Controllers\Admin;

use NeonTsunami\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * GET /admin/tags
     * Display all of the tags.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::query();

        if ($request->has('q')) {
            $tags->search($request->input('q'));
        }

        return response()->json($tags->get());
    }
}
