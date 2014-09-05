<?php namespace Admin;

use Post;
use Auth, Input, Redirect, View;

class PostsController extends AdminController {

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
     * GET /admin/posts
     * Display all of the posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = $this->post->with('user')
            ->latest()
            ->paginate(25);

        return View::make('admin.posts.index', compact('posts'))
            ->withTitle('All posts');
    }

    /**
     * GET /admin/posts/create
     * Display the form for creating a new post.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.posts.create')
            ->withTitle('Create post');
    }

    /**
     * POST /admin/posts
     * Store a new post in storage.
     *
     * @return Response
     */
    public function store()
    {
        $input = array_add(Input::all(), 'user_id', Auth::id());

        $post = $this->post->fill($input);

        if ( ! $post->save())
        {
            return Redirect::route('admin.posts.create')
                ->withInput()
                ->withErrors($post->getErrors());
        }

        return Redirect::route('admin.posts.show', $post->slug)
            ->withSuccess('The post was created.');
    }

    /**
     * GET /admin/posts/post-slug
     * Display a specified post.
     *
     * @param  Post  $post
     * @return Response
     */
    public function show(Post $post)
    {
        return View::make('admin.posts.show', compact('post'))
            ->withTitle('Show post');
    }

    /**
     * GET /admin/posts/post-slug/edit
     * Display the form for editing a post.
     *
     * @param  Post  $post
     * @return Response
     */
    public function edit(Post $post)
    {
        return View::make('admin.posts.edit', compact('post'))
            ->withTitle('Edit post');
    }

    /**
     * PUT /admin/posts/post-slug
     * Update a given post in storage.
     *
     * @param  Post  $post
     * @return Response
     */
    public function update(Post $post)
    {
        $input = Input::all();

        if ( ! $post->update($input))
        {
            return Redirect::route('admin.posts.edit', $post->getOriginal('slug'))
                ->withErrors($post->getErrors())
                ->withInput();
        }

        return Redirect::route('admin.posts.show', $post->slug)
            ->withSuccess('The post was updated.');
    }

    /**
     * DELETE /admin/posts/post-slug
     * Remove a post from storage.
     *
     * @param  Post  $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return Redirect::route('admin.posts.index')
            ->withSuccess('The post was deleted.');
    }

}
