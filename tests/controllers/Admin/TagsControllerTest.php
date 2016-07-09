<?php

namespace Admin;

use NeonTsunami\Tag;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagsControllerTest extends \TestCase
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

        $this->visit('admin/tags')
            ->seeJson(['name' => $tag->name]);
    }

    public function testIndexSearches()
    {
        factory(Tag::class)->create(['name' => 'Foo']);
        factory(Tag::class)->create(['name' => 'Bar']);

        $this->json('GET', 'admin/tags', ['q' => 'Foo'])
            ->seeJson(['name' => 'Foo'])
            ->dontSeeJson(['name' => 'Bar']);
    }

    public function testStore()
    {
        $tag = factory(Tag::class)->make(['name' => 'Foo']);

        $this->json('POST', 'admin/tags', $tag->getAttributes())
            ->seeJson(['name' => 'Foo'])
            ->seeStatusCode(201);
    }

    public function testStoreDoesNotDuplicateTags()
    {
        $tag = factory(Tag::class)->create(['name' => 'Foo', 'slug' => 'foo']);

        $this->json('POST', 'admin/tags', $tag->getAttributes())
            ->seeJson(['name' => 'Foo'])
            ->seeStatusCode(201);
        $this->assertEquals(1, Tag::count());
    }

    public function testStoreFails()
    {
        $this->json('POST', 'admin/tags')
            ->seeStatusCode(422);
    }
}
