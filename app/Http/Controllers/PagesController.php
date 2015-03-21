<?php namespace NeonTsunami\Http\Controllers;

use NeonTsunami\Post;

class PagesController extends Controller {

	/**
	 * GET /
	 * The home page.
	 *
	 * @return Response
	 */
	public function index()
	{
		$latestPosts = Post::with('tags')->published()->latest()->take(5)->get();

		$popularPosts = Post::published()
			->with('tags')
			->whereNotIn('id', $latestPosts->modelKeys())
			->orderBy('views', 'desc')
			->take(5)
			->get();

		return view('pages.index', compact('latestPosts', 'popularPosts'))
			->withTitle('A blog on Laravel & Rails');
	}

	/**
	 * GET /about
	 * The about page.
	 *
	 * @return Response
	 */
	public function about()
	{
		return view('pages.about')
			->withTitle('About');
	}

	/**
	 * GET /rss
	 * Return the RSS feed of posts.
	 *
	 * @return Response
	 */
	public function rss()
	{
		$posts = Post::published()->latest()->take(100)->get();

		if ($posts->count()) $updated = $posts->first()->updated_at;

		return response()->view('pages.rss', compact('posts', 'updated'), 200, [
			'Content-Type' => 'application/rss+xml; charset=UTF-8'
		]);
	}

}
