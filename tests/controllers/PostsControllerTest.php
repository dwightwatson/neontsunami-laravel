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

        $this->action('GET', 'PostsController@index');

        $this->assertResponseOk();
        $this->assertViewHas('posts');
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        $post = $user->posts()->save(
            factory(Post::class)->make()
        );

        $this->action('GET', 'PostsController@show', $post);

        $this->assertResponseOk();
        $this->assertViewHas('post');

        $this->assertEquals(1, $post->fresh()->views);
    }
}
