<?php

use NeonTsunami\Post;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class PagesControllerTest extends DbTestCase {

    public function testIndex()
    {
        Factory::times(2)->create(Post::class);

        $this->action('GET', 'PagesController@index');

        $this->assertResponseOk();
        $this->assertViewIs('pages.index');
        $this->assertViewHas('latestPost');
        $this->assertViewHas('popularPosts');
    }

    public function testAbout()
    {
        $this->action('GET', 'PagesController@about');

        $this->assertResponseOk();
        $this->assertViewIs('pages.about');
    }

    public function testRss()
    {
        $this->action('GET', 'PagesController@rss');

        $this->assertResponseOk();
        $this->assertViewIs('pages.rss');
        $this->assertViewHas('posts');
    }

}
