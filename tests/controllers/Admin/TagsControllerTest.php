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
        factory(Tag::class)->create(['name' => 'Foo']);

        $this->action('GET', 'Admin\TagsController@index');

        $this->assertResponseOk();
        $this->seeJson(['name' => 'Foo']);
    }

    public function testIndexSearches()
    {
        factory(Tag::class)->create(['name' => 'Foo']);
        factory(Tag::class)->create(['name' => 'Bar']);

        $this->action('GET', 'Admin\TagsController@index', ['q' => 'Foo']);

        $this->assertResponseOk();
        $this->seeJson(['name' => 'Foo']);
        $this->dontSeeJson(['name' => 'Bar']);
    }

    public function testStore()
    {
        $tag = factory(Tag::class)->make(['name' => 'Foo']);

        $input = array_only($tag->getAttributes(), $tag->getFillable());

        $this->action('POST', 'Admin\TagsController@store', $input);

        $this->assertResponseStatus(201);
        $this->seeJson(['name' => 'Foo']);
    }

    public function testStoreDoesNotDuplicateTags()
    {
        $tag = factory(Tag::class)->create(['name' => 'Foo', 'slug' => 'foo']);

        $input = array_only($tag->getAttributes(), $tag->getFillable());

        $this->action('POST', 'Admin\TagsController@store', $input);

        $this->assertResponseStatus(201);
        $this->seeJson(['name' => 'Foo']);
        $this->assertEquals(1, Tag::count());
    }

    public function testStoreFails()
    {
        $this->action('POST', 'Admin\TagsController@store');

        $this->assertResponseStatus(422);
    }
}
