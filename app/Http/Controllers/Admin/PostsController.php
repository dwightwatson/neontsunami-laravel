<?php namespace NeonTsunami\Http\Controllers\Admin;

use NeonTsunami\Post;
use NeonTsunami\Series;
use NeonTsunami\Commands\GenerateTagsCommand;
use NeonTsunami\Http\Requests\Posts\StorePostRequest;
use NeonTsunami\Http\Requests\Posts\UpdatePostRequest;

class PostsController extends Controller {

    /**
     * GET /admin/posts
     * Display all of the posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(25);

        return view('admin.posts.index', compact('posts'))
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
        $series = [null => 'Select...'] + Series::lists('name', 'id');

        return view('admin.posts.create', compact('series'))
            ->withTitle('Create post');
    }

    /**
     * POST /admin/posts
     * Store a new post in storage.
     *
     * @param  StorePostRequest  $request
     * @return Response
     */
    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create($request->all());

        if ($request->has('tags')) {
            $tags = $this->dispatchFrom(GenerateTagsCommand::class, $request);

            $post->tags()->sync($tags);
        }

        return redirect()->route('admin.posts.show', $post)
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
        return view('admin.posts.show', compact('post'))
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
        $series = [null => 'Select...'] + Series::lists('name', 'id');

        return view('admin.posts.edit', compact('post', 'series'))
            ->withTitle('Edit post');
    }

    /**
     * PUT /admin/posts/post-slug
     * Update a given post in storage.
     *
     * @param  Post  $post
     * @param  UpdatePostRequest  $request
     * @return Response
     */
    public function update(Post $post, UpdatePostRequest $request)
    {
        $post->update($request->all());

        if ($request->has('tags')) {
            $tags = $this->dispatchFrom(GenerateTagsCommand::class, $request);

            $post->tags()->sync($tags);
        }

        return redirect()->route('admin.posts.show', $post)
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

        return redirect()->route('admin.posts.index')
            ->withSuccess('The post was deleted.');
    }

}
