<?php

use NeonTsunami\Post;
use NeonTsunami\Tag;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $tag = factory(Tag::class)->create();
        $posts = factory(Post::class, 3)->create();
        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $response = $this->action('GET', 'TagsController@index');

        $this->assertResponseOk();
        $this->assertViewHas('tags');

        $this->assertContains($tag->name, $response->getContent());
    }

    public function testShow()
    {
        $tag = factory(Tag::class)->create();
        $posts = factory(Post::class, 3)->create();
        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $response = $this->action('GET', 'TagsController@show', $tag);

        $this->assertResponseOk();
        $this->assertViewHas('posts');
    }
}
