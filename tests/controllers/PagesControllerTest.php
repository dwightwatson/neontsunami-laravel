<?php

use NeonTsunami\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        factory(Post::class, 2)->create();

        $this->action('GET', 'PagesController@index');

        $this->assertResponseOk();
        $this->assertViewHas('latestPosts');
        $this->assertViewHas('popularPosts');
    }

    public function testAbout()
    {
        $this->action('GET', 'PagesController@about');

        $this->assertResponseOk();
    }

    public function testRss()
    {
        $this->action('GET', 'PagesController@rss');

        $this->assertResponseOk();
        $this->assertViewHas('posts');
    }
}
