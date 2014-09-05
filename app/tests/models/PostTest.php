<?php

class PostTest extends PHPUnit_Framework_TestCase {

    use Watson\Testing\ModelHelpers;

    public $post;

    public function setUp()
    {
        parent::setUp();

        $this->post = new Post;
    }

    public function testValidatesUser()
    {
        $this->assertValidatesRequired($this->post, 'user_id');
        $this->assertValidatesExists($this->post, 'user_id', 'users,id');
    }

    public function testValidatesSeries()
    {
        $this->assertValidatesExists($this->post, 'series_id', 'series,id');
    }

    public function testValidatesTitle()
    {
        $this->assertValidatesRequired($this->post, 'title');
    }

    public function testValidatesSlug()
    {
        $this->assertValidatesRequired($this->post, 'slug');
        $this->assertValidatesUnique($this->post, 'slug', 'posts,slug');
    }

    public function testValidatesContent()
    {
        $this->assertValidatesRequired($this->post, 'content');
    }

    public function testSetTitleAttribute()
    {
        $this->post->title = 'Foo Bar Baz';

        $this->assertEquals('foo-bar-baz', $this->post->slug);
    }

    public function testBelongsToSeries()
    {
        $this->assertBelongsTo($this->post, 'Series');
    }

    public function testBelongsToManyTags()
    {
        $this->assertBelongsToMany($this->post, 'Tags');
    }

    public function testBelongsToUser()
    {
        $this->assertBelongsTo($this->post, 'User');
    }

}
