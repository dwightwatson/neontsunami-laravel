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
        $this->assertViewHas('posts', [$publishedPost]);
    }

}
