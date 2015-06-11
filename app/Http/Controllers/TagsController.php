<?php

namespace NeonTsunami\Http\Controllers;

use NeonTsunami\Tag;

class TagsController extends Controller
{
    /**
     * GET /tags
     * Display a listing of all tags.
     *
     * @return Response
     */
    public function index()
    {
        $tags = Tag::used()->get();

        foreach ($tags as $tag) {
            $taggly[] = [
                'tag'   => $tag->name,
                'url'   => route('tags.show', $tag->slug),
                'count' => $tag->count
            ];
        }

        return view('tags.index', compact('tags', 'taggly'))
            ->withTitle('All tags');
    }

    /**
     * GET /tags/tag
     * Display the posts of a given tag.
     *
     * @param  Tag  $tag
     * @return Response
     */
    public function show(Tag $tag)
    {
        $posts = $tag->posts()->published()->latest()->paginate();

        return view('tags.show', compact('tag', 'posts'))
            ->withTitle("Posts for {$tag->name}");
    }
}
