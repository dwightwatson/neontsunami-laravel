<?php

namespace Tests\Unit\Models;

use App\Series;
use Tests\TestCase;

class SeriesTest extends TestCase
{
    public $series;

    public function setUp()
    {
        parent::setUp();

        $this->series = new Series;
    }

    public function testSetNameAttribtue()
    {
        $this->series->name = 'Foo Bar Baz';

        $this->assertEquals('foo-bar-baz', $this->series->slug);
    }
}
