<?php

use NeonTsunami\Post;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $publishedPost = factory(Post::class)->create(['published_at' => new DateTime]);
        $unpublishedPost = factory(Post::class)->create(['published_at' => null]);

        $this->visit('posts')
            ->see($publishedPost->title)
            ->dontSee($unpublishedPost->title);
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        $post = $user->posts()->save(
            factory(Post::class)->make()
        );

        $this->visit("posts/{$post->slug}")
            ->see($post->title);

        $this->assertEquals(1, $post->fresh()->views);
    }

    public function testShowWithUnpublishedPost()
    {
        $this->markTestIncomplete();

        $user = factory(User::class)->create();

        $post = $user->posts()->save(
            factory(Post::class)->make(['published_at' => null])
        );

        $this->visit("posts/{$post->slug}")
            ->seeStatusCode(404);

        $this->assertEquals(0, $post->fresh()->views);
    }
}
