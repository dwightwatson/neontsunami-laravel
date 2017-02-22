<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use App\Series;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SeriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        $user = factory(User::class)->create();
        $series = factory(Series::class)->create();

        $publishedPost = factory(Post::class)->make();
        $publishedPost->series()->associate($series);
        $publishedPost->user()->associate($user);
        $publishedPost->save();

        $response = $this->get('/series');

        $response->assertStatus(200)
            ->assertSee($series->name)
            ->assertSee('1 post');
    }

    public function testShow()
    {
        $user = factory(User::class)->create();
        $series = factory(Series::class)->create();

        $publishedPost = factory(Post::class)->make();
        $publishedPost->series()->associate($series);
        $publishedPost->user()->associate($user);
        $publishedPost->save();

        $unpublishedPost = factory(Post::class)->make(['published_at' => null]);
        $unpublishedPost->series()->associate($series);
        $unpublishedPost->user()->associate($user);
        $unpublishedPost->save();

        $response = $this->get("/series/{$series->slug}");

        $response->assertStatus(200)
            ->assertSee($series->name)
            ->assertSee($publishedPost->title)
            ->assertDontSee($unpublishedPost->title);
    }
}
