<?php

use NeonTsunami\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $posts = factory(Post::class, 2)->create();

        $this->visit('/')
            ->see($posts->first()->title)
            ->see($posts->last()->title);
    }

    public function testAbout()
    {
        $this->visit('about');
    }

    public function testWork()
    {
        $this->visit('work');
    }

    public function testRss()
    {
        $this->visit('rss');
    }
}
