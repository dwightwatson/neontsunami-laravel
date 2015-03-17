<?php

use Laracasts\TestDummy\Factory;

class SeriesControllerTest extends TestCase {

    public function testIndex()
    {
        $publishedPost = Factory::create('Post');
        $unpublishedPost = Factory::create('Post', ['published_at' => null]);

        $series = $publishedPost->series;

        $response = $this->action('GET', 'SeriesController@index');

        $this->assertResponseOk();
        $this->assertViewIs('series.index');
        $this->assertViewHas('series');

        $this->assertContains($series->name, $response->getContent());
        $this->assertContains('1 post', $response->getContent());
    }

    public function testShow()
    {
        $publishedPost = Factory::create('Post');
        $unpublishedPost = Factory::create('Post', ['published_at' => null]);

        $series = $publishedPost->series;

        $response = $this->action('GET', 'SeriesController@show', $series->slug);

        $this->assertResponseOk();
        $this->assertViewIs('series.show');
        $this->assertViewHas('series');

        $this->assertContains('1 post', $response->getContent());
    }

}
