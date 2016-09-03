<?php

use NeonTsunami\Tag;
use NeonTsunami\Post;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RedirectsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetPost()
    {
        $user = factory(User::class)->create();

        $post = $user->posts()->save(factory(Post::class)->make());

        $this->visit("post/{$post->slug}")
            ->seePageIs("posts/{$post->slug}");
    }

    public function testGetTag()
    {
        $tag = factory(Tag::class)->create();

        $this->visit("tag/{$tag->slug}")
            ->seePageIs("tags/{$tag->slug}");
    }
}
