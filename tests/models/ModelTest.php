<?php

namespace NeonTsunami;

use PHPUnit_Framework_TestCase;

class ModelTest extends PHPUnit_Framework_TestCase
{

    public $model;

    public function setUp()
    {
        parent::setUp();

        $this->model = new ModelStub;
    }

    public function testUsesSoftDeletingTrait()
    {
        $traits = class_uses($this->model);

        foreach (class_parents($this->model) as $parent) {
            $traits += class_uses($parent);
        }

        $this->assertContains(
            'Illuminate\Database\Eloquent\SoftDeletes',
            $traits
        );
    }

    public function testSetsDatesProperty()
    {
        $this->assertContains('deleted_at', $this->model->getDates());
    }
}

class ModelStub extends Model
{
}
