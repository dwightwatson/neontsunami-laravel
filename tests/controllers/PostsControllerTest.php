<?php

use NeonTsunami\Post;

use Carbon\Carbon;
use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class PostsControllerTest extends DbTestCase {

    public function testIndex()
    {
        $publishedPost = Factory::create(Post::class, ['published_at' => Carbon::now()]);
        $unpublishedPost = Factory::create(Post::class, ['published_at' => null]);

        $this->action('GET', 'PostsController@index');

        $this->assertResponseOk();
        $this->assertViewIs('posts.index');
        $this->assertViewHas('posts');
    }

    public function testShow()
    {
        $post = Factory::create(Post::class);

        $this->action('GET', 'PostsController@show', $post);

        $this->assertResponseOk();
        $this->assertViewIs('posts.show');
        $this->assertViewHas('post');

        $post = Post::find($post->id);
        $this->assertEquals(1, $post->views);
    }

}
