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

        $unpublishedPost = factory(Post::class)->create(['published_at' => null]);
        $unpublishedPost->series()->associate($series);
        $unpublishedPost->save();

        $response = $this->action('GET', 'SeriesController@index');

        $this->assertResponseOk();
        $this->assertViewHas('series');

        $this->assertContains($series->name, $response->getContent());
        $this->assertContains('1 post', $response->getContent());
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

        $series = $publishedPost->series;

        $response = $this->action('GET', 'SeriesController@show', $series);

        $this->assertResponseOk();
        $this->assertViewHas('series');

        $this->assertContains('1 post', $response->getContent());
    }
}
