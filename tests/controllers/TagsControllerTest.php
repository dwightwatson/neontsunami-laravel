<?php

use NeonTsunami\Post;
use NeonTsunami\Tag;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class TagsControllerTest extends DbTestCase {

    public function testIndex()
    {
        $tag = Factory::create(Tag::class);
        $posts = Factory::times(3)->create(Post::class);
        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $response = $this->action('GET', 'TagsController@index');

        $this->assertResponseOk();
        $this->assertViewIs('tags.index');
        $this->assertViewHas('tags');

        $this->assertContains($tag->name, $response->getContent());
    }

    public function testShow()
    {
        $tag = Factory::create(Tag::class);
        $posts = Factory::times(3)->create(Post::class);
        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $response = $this->action('GET', 'TagsController@show', $tag);

        $this->assertResponseOk();
        $this->assertViewIs('tags.show');
        $this->assertViewHas('posts');
    }

}
