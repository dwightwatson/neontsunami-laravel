<?php

use Laracasts\TestDummy\Factory;

class PagesControllerTest extends TestCase {

    public function testIndex()
    {
        Factory::times(2)->create('Post');

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
