<?php

namespace Tests\Feature;

use App\Tag;
use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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

        $response = $this->get('/tags');

        $response->assertStatus(200)
            ->assertSee($tag->name);
    }

    public function testShow()
    {
        $tag = factory(Tag::class)->create();
        $user = factory(User::class)->create();

        $posts = $user->posts()->saveMany(
            factory(Post::class, 3)->make()
        );

        $tag->posts()->sync([$posts[0]->id, $posts[1]->id, $posts[2]->id]);

        $response = $this->get("tags/{$tag->slug}");

        $response->assertStatus(200)
            ->assertSee($tag->name)
            ->assertSee($posts->first()->title);
    }
}
