<?php

namespace Tests\Feature\Admin;

use App\Tag;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $tag = factory(Tag::class)->create();

        $response = $this->get('/admin/tags');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $tag->name]);
    }

    public function testIndexSearches()
    {
        factory(Tag::class)->create(['name' => 'Foo']);

        $response = $this->json('GET', 'admin/tags', ['q' => 'Foo']);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Foo']);
    }

    public function testStore()
    {
        $tag = factory(Tag::class)->make(['name' => 'Foo']);

        $response = $this->json('POST', 'admin/tags', $tag->getAttributes());

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Foo']);
    }

    public function testStoreDoesNotDuplicateTags()
    {
        $tag = factory(Tag::class)->create(['name' => 'Foo', 'slug' => 'foo']);

        $response = $this->json('POST', 'admin/tags', $tag->getAttributes());

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Foo']);

        $this->assertEquals(1, Tag::count());
    }

    public function testStoreFails()
    {
        $response = $this->json('POST', 'admin/tags');

        $response->assertStatus(422);
    }
}
