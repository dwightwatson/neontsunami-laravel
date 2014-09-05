<?php

use Laracasts\TestDummy\Factory;

class TagsControllerTest extends TestCase {

    public function testIndex()
    {
        $tag = Factory::create('Tag');
        $posts = Factory::times(3)->create('Post');
        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $response = $this->action('GET', 'TagsController@index');

        $this->assertResponseOk();
        $this->assertViewIs('tags.index');
        $this->assertViewHas('tags');

        $this->assertContains($tag->name, $response->getContent());
    }

    public function testShow()
    {
        $tag = Factory::create('Tag');
        $posts = Factory::times(3)->create('Post');
        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $response = $this->action('GET', 'TagsController@show', $tag->slug);

        $this->assertResponseOk();
        $this->assertViewIs('tags.show');
        $this->assertViewHas('posts');
    }

}
