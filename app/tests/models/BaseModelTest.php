<?php

class BaseModelTest extends PHPUnit_Framework_TestCase {

    use Watson\Testing\ModelHelpers;

    public $baseModel;

    public function setUp()
    {
        parent::setUp();

        $this->baseModel = new BaseModel;
    }

    public function testUsesSoftDeletingTrait()
    {
        $this->assertContains(
            'Illuminate\Database\Eloquent\SoftDeletingTrait',
            class_uses($this->baseModel)
        );
    }

    public function testUsesValidatingTrait()
    {
        $this->assertContains(
            'Watson\Validating\ValidatingTrait',
            class_uses($this->baseModel)
        );
    }

    public function testSetsDatesProperty()
    {
        $this->assertContains('deleted_at', $this->baseModel->getDates());
    }

}
