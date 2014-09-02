<?php

class RedirectsController extends BaseController {

    /**
     * GET /post/post-slug
     * Redirect legacy post routes to the new pluralised route.
     *
     * @param  string $slug
     * @return Response
     */
    public function getPost($slug)
    {
        return Redirect::route('posts.show', $slug, 301);
    }

    /**
     * GET /tag/tag-slug
     * Redirect legacy tag routes to the new pluralised route.
     *
     * @param  string  $slug
     * @return Response
     */
    public function getTag($slug)
    {
        return Redirect::route('tags.show', $slug, 301);
    }

}
