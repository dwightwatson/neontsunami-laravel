<?php

namespace NeonTsunami;

use Carbon\Carbon;
use PHPUnit_Framework_TestCase;

class PostTest extends PHPUnit_Framework_TestCase
{
    public $post;

    public function setUp()
    {
        parent::setUp();

        $this->post = new Post;

        // To prevent the model from needing to talk to the database to get the
        // correct date format, we'll just tell it. The alternative would be to
        // have this test extend TestCase and boot the Laravel application.
        $this->post->setDateFormat('Y-m-d H:i:s');
    }

    public function testSetTitleAttribute()
    {
        $this->post->title = 'Foo Bar Baz';

        $this->assertEquals('foo-bar-baz', $this->post->slug);
    }

    public function testIsPublished()
    {
        $this->assertFalse($this->post->isPublished());

        $this->post->published_at = Carbon::now()->subDay();
        $this->assertTrue($this->post->isPublished());

        $this->post->published_at = Carbon::now()->addDay();
        $this->assertFalse($this->post->isPublished());
    }

    public function testIsUnpublished()
    {
        $this->assertTrue($this->post->isUnpublished());

        $this->post->published_at = Carbon::now();
        $this->assertFalse($this->post->isUnpublished());
    }
}
