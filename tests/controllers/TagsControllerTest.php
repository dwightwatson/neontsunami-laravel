<?php

use NeonTsunami\Tag;
use NeonTsunami\Post;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $tag = factory(Tag::class)->create();
        $user = factory(User::class)->create();

        $posts = $user->posts()->saveMany(
            factory(Post::class, 3)->make()
        );

        $tag->posts()->sync($posts);

        $this->visit('tags')
            ->see($tag->name);
    }

    public function testShow()
    {
        $tag = factory(Tag::class)->create();
        $user = factory(User::class)->create();

        $posts = $user->posts()->saveMany(
            factory(Post::class, 3)->make()
        );

        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $this->visit("tags/{$tag->slug}")
            ->see($tag->name)
            ->see($posts->first()->title);
    }
}
