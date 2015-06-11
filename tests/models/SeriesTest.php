<?php

namespace NeonTsunami;

use PHPUnit_Framework_TestCase;

class SeriesTest extends PHPUnit_Framework_TestCase
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
