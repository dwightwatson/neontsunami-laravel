<?php

namespace NeonTsunami;

use PHPUnit_Framework_TestCase;

class PostTest extends PHPUnit_Framework_TestCase
{

    public $post;

    public function setUp()
    {
        parent::setUp();

        $this->post = new Post;
    }

    public function testSetTitleAttribute()
    {
        $this->post->title = 'Foo Bar Baz';

        $this->assertEquals('foo-bar-baz', $this->post->slug);
    }
}
