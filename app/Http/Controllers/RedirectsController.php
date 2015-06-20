<?php

namespace NeonTsunami\Http\Controllers;

use Illuminate\Http\Request;

class RedirectsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | General redirects
    |--------------------------------------------------------------------------
    */

    /**
     * GET /post/post-slug
     * Redirect legacy post routes to the new pluralised route.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function getPost($slug)
    {
        return redirect()->route('posts.show', $slug, 301);
    }

    /**
     * GET /tag/tag-slug
     * Redirect legacy tag routes to the new pluralised route.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function getTag($slug)
    {
        return redirect()->route('tags.show', $slug, 301);
    }

    /**
     * GET /archive
     * Redirect legacy archive routes to the new posts route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getArchive(Request $request)
    {
        $parameters = [];

        if ($request->has('page')) {
            $parameters['page'] = $request->get('page');
        }

        return redirect()->route('posts.index', $parameters, 301);
    }

    /*
    |--------------------------------------------------------------------------
    | Specific redirects
    |--------------------------------------------------------------------------
    */
    public function getTagsMacOsX()
    {
        return redirect()->to('tags/osx');
    }

    public function getTagsRubyOnRails()
    {
        return redirect()->to('tags/ruby-on-rails');
    }
}
