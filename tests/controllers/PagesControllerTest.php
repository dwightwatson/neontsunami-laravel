<?php

use NeonTsunami\Post;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $user = factory(User::class)->create();

        $posts = $user->posts()->saveMany(factory(Post::class, 2)->make());

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
