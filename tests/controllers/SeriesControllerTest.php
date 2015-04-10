<?php

use NeonTsunami\Post;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class SeriesControllerTest extends DbTestCase {

    public function testIndex()
    {
        $publishedPost = Factory::create(Post::class);
        $unpublishedPost = Factory::create(Post::class, ['published_at' => null]);

        $series = $publishedPost->series;

        $response = $this->action('GET', 'SeriesController@index');

        $this->assertResponseOk();
        $this->assertViewHas('series');

        $this->assertContains($series->name, $response->getContent());
        $this->assertContains('1 post', $response->getContent());
    }

    public function testShow()
    {
        $publishedPost = Factory::create(Post::class);
        $unpublishedPost = Factory::create(Post::class, ['published_at' => null]);

        $series = $publishedPost->series;

        $response = $this->action('GET', 'SeriesController@show', $series);

        $this->assertResponseOk();
        $this->assertViewHas('series');

        $this->assertContains('1 post', $response->getContent());
    }

}
