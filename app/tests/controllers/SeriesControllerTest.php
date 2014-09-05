<?php

use Laracasts\TestDummy\Factory;

class SeriesControllerTest extends TestCase {

    public function testIndex()
    {
        $posts = Factory::times(3)->create('Post');
        head($posts)->update(['published_at' => null]);

        $series = head($posts)->series;

        $response = $this->action('GET', 'SeriesController@index');

        $this->assertResponseOk();
        $this->assertViewIs('series.index');
        $this->assertViewHas('series');

        $this->assertContains($series->name, $response->getContent());
        $this->assertContains('2 posts', $response->getContent());
    }

    public function testShow()
    {
        $posts = Factory::times(3)->create('Post');
        head($posts)->update(['published_at' => null]);

        $series = head($posts)->series;

        $response = $this->action('GET', 'SeriesController@show', $series->slug);

        $this->assertResponseOk();
        $this->assertViewIs('series.show');
        $this->assertViewHas('series');

        $this->assertContains('2 posts', $response->getContent());
    }

}
