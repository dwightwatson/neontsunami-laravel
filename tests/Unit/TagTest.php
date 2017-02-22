<?php

namespace Tests\Unit\Models;

use App\Tag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagTest extends TestCase
{
    public $tag;

    public function setUp()
    {
        parent::setUp();

        $this->tag = new Tag;
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
}
