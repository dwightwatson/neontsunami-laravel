<?php namespace NeonTsunami\Http\Controllers;

use NeonTsunami\Post;

use Illuminate\Http\Request;

class PostsController extends Controller {

    /**
     * GET /posts
     * Get a listing of all posts.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $posts = Post::with('tags', 'series')
            ->published()
            ->latest()
            ->paginate(10);

        $page = $request->get('page');
        $title = $page ? "All posts (Page {$page})" : 'All posts';

        return view('posts.index', compact('posts'))
            ->withTitle($title);
    }

    /**
     * GET /posts/post-slug
     * Get a single post.
     *
     * @param  Post  $post
     * @return Response
     */
    public function show(Post $post)
    {
        $post->load('series', 'tags', 'user');

        $post->increment('views');

        return view('posts.show', compact('post'))
            ->withTitle($post->title)
            ->withDescription(str_limit($post->content, 160));
    }

}
