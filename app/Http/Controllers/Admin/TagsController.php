<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\Tags\StoreTagRequest;

class TagsController extends Controller
{
    /**
     * GET /admin/tags
     * Display all of the tags.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $tags = Tag::query();

        if ($request->has('q')) {
            $tags->search($request->input('q'));
        }

        return response()->json($tags->get());
    }

    /**
     * POST /admin/tags
     * Store a new tag in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTagRequest $request)
    {
        $tag = Tag::firstOrCreate([
            'name' => $request->input('name'),
            'slug' => str_slug($request->input('name'))
        ]);

        return response()->json($tag, 201);
    }
}
