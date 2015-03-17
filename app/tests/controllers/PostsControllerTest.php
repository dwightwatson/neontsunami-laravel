<?php

use Laracasts\TestDummy\Factory;

class PostsControllerTest extends TestCase {

    public function testIndex()
    {
        $publishedPost = Factory::create('Post', ['published_at' => Carbon::now()]);
        $unpublishedPost = Factory::create('Post', ['published_at' => null]);

        $this->action('GET', 'PostsController@index');

        $this->assertResponseOk();
        $this->assertViewIs('posts.index');
        $this->assertViewHas('posts');
    }

    public function testShow()
    {
        $post = Factory::create('Post');

        $this->action('GET', 'PostsController@show', $post->slug);

        $this->assertResponseOk();
        $this->assertViewIs('posts.show');
        $this->assertViewHas('post');

        $post = Post::find($post->id);
        $this->assertEquals(1, $post->views);
    }

}
