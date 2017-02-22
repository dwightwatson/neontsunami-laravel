<?php

namespace Tests\Feature;

use App\Tag;
use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RedirectsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetPost()
    {
        $user = factory(User::class)->create();

        $post = $user->posts()->save(factory(Post::class)->make());

        $response = $this->get("/post/{$post->slug}");

        $response->assertRedirect("/posts/{$post->slug}");
    }

    public function testGetTag()
    {
        $tag = factory(Tag::class)->create();

        $response = $this->get("/tag/{$tag->slug}");

        $response->assertRedirect("/tags/{$tag->slug}");
    }
}
