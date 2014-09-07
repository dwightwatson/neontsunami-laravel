<?php

class PostsController extends BaseController {

    /**
     * Post instance.
     *
     * @var Post
     */
    protected $post;

    /**
     * Construct the controller.
     *
     * @param  Post  $post
     * @return void
     */
    public function __construct(Post $post)
    {
        parent::__construct();

        $this->post = $post;
    }

    /**
     * GET /posts
     * Get a listing of all posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = $this->post->with('tags', 'series')
            ->published()
            ->latest()
            ->paginate(10);

        $page = Input::get('page');
        $title = $page ? "All posts (Page {$page})" : 'All posts';

        return View::make('posts.index', compact('posts'))
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

        return View::make('posts.show', compact('post'))
            ->withTitle($post->title)
            ->withDescription(str_limit($post->content, 160));
    }

}
