<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use DateTime;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $user = factory(User::class)->create();

        $publishedPost = $user->posts()->save(
            factory(Post::class)->make(['published_at' => new DateTime])
        );

        $unpublishedPost = $user->posts()->save(
            factory(Post::class)->make(['published_at' => null])
        );

        $response = $this->get('/posts');

        $response->assertStatus(200)
            ->assertSee($publishedPost->title)
            ->assertDontSee($unpublishedPost->title);
    }

    public function testShow()
    {
        $user = factory(User::class)->create();

        $post = $user->posts()->save(
            factory(Post::class)->make()
        );

        $response = $this->get("/posts/{$post->slug}");

        $response->assertStatus(200)
            ->assertSee($post->title);

        $this->assertEquals(1, $post->fresh()->views);
    }

    public function testShowWithUnpublishedPost()
    {
        $user = factory(User::class)->create();

        $post = $user->posts()->save(
            factory(Post::class)->make(['published_at' => null])
        );

        $response = $this->get("/posts/{$post->slug}");

        $response->assertStatus(404);

        $this->assertEquals(0, $post->fresh()->views);
    }
}
