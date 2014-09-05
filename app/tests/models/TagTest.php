<?php

class TagTest extends PHPUnit_Framework_TestCase {

    use Watson\Testing\ModelHelpers;

    public $tag;

    public function setUp()
    {
        parent::setUp();

        $this->tag = new Tag;
    }

    public function testValidatesName()
    {
        $this->assertValidatesRequired($this->tag, 'name');
    }

    public function testValidatesSlug()
    {
        $this->assertValidatesRequired($this->tag, 'slug');
        $this->assertValidatesUnique($this->tag, 'slug', 'tags,slug');
    }

    public function testGetHashtagAttribute()
    {
        $this->tag->slug = 'foo';

        $this->assertEquals('#foo', $this->tag->hashtag);
    }

    public function testSetNameAttribute()
    {
        $this->tag->name = 'Foo Bar Baz';

        $this->assertEquals('foo-bar-baz', $this->tag->slug);
    }

    public function testBelongsToManyPosts()
    {
        return $this->assertBelongsToMany($this->tag, 'Posts');
    }

}
