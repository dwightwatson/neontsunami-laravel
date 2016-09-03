<?php

use NeonTsunami\Post;
use NeonTsunami\User;
use NeonTsunami\Series;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $user = factory(User::class)->create();
        $series = factory(Series::class)->create();

        $publishedPost = factory(Post::class)->make();
        $publishedPost->series()->associate($series);
        $publishedPost->user()->associate($user);
        $publishedPost->save();

        $this->visit("series")
            ->see($series->name)
            ->see('1 post');
    }

    public function testShow()
    {
        $user = factory(User::class)->create();
        $series = factory(Series::class)->create();

        $publishedPost = factory(Post::class)->make();
        $publishedPost->series()->associate($series);
        $publishedPost->user()->associate($user);
        $publishedPost->save();

        $unpublishedPost = factory(Post::class)->make(['published_at' => null]);
        $unpublishedPost->series()->associate($series);
        $unpublishedPost->user()->associate($user);
        $unpublishedPost->save();

        $this->visit("series/{$series->slug}")
            ->see($series->name)
            ->see($publishedPost->title)
            ->dontSee($unpublishedPost->title);
    }
}
