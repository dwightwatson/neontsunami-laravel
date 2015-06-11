<?php

use NeonTsunami\Post;

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
        $post = factory(POST::class)->create();

        $this->action('GET', 'PostsController@show', $post);

        $this->assertResponseOk();
        $this->assertViewHas('post');

        $post = Post::find($post->id);
        $this->assertEquals(1, $post->views);
    }
}
