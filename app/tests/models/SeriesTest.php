<?php

class SeriesTest extends PHPUnit_Framework_TestCase {

    use Watson\Testing\ModelHelpers;

    public $series;

    public function setUp()
    {
        parent::setUp();

        $this->series = new Series;
    }

    public function testValidatesName()
    {
        $this->assertValidatesRequired($this->series, 'name');
    }

    public function testValidatesSlug()
    {
        $this->assertValidatesRequired($this->series, 'slug');
        $this->assertValidatesUnique($this->series, 'slug', 'series,slug');
    }

    public function testValidatesDescription()
    {
        $this->assertValidatesRequired($this->series, 'description');
    }

    public function testSetNameAttribtue()
    {
        $this->series->name = 'Foo Bar Baz';

        $this->assertEquals('foo-bar-baz', $this->series->slug);
    }

    public function testHasManyPosts()
    {
        $this->assertHasMany($this->series, 'Posts');
    }

}
