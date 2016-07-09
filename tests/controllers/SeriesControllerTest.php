<?php

use NeonTsunami\Post;
use NeonTsunami\Series;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $series = factory(Series::class)->create();

        $publishedPost = factory(Post::class)->create();
        $publishedPost->series()->associate($series);
        $publishedPost->save();

        $this->visit("series")
            ->see($series->name)
            ->see('1 post');
    }

    public function testShow()
    {
        $series = factory(Series::class)->create();

        $publishedPost = factory(Post::class)->create();
        $publishedPost->series()->associate($series);
        $publishedPost->save();

        $unpublishedPost = factory(Post::class)->create(['published_at' => null]);
        $unpublishedPost->series()->associate($series);
        $unpublishedPost->save();

        $this->visit("series/{$series->slug}")
            ->see($series->name)
            ->see($publishedPost->title)
            ->dontSee($unpublishedPost->title);
    }
}
