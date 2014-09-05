<?php

class BaseControllerTest extends TestCase {

    public $baseController;

    public function setUp()
    {
        parent::setUp();

        $this->baseController = new BaseController;
    }

    public function testHasCsrfBeforeFilter()
    {
        $beforeFilters = $this->baseController->getBeforeFilters();

        // In the instance there is only one before filter, we can assume
        // that it should be the CSRF filter.
        $this->assertCount(1, $beforeFilters);

        $csrfFilter = head($beforeFilters);

        $this->assertEquals('csrf', $csrfFilter['original']);
        $this->assertEquals(['delete', 'patch', 'post', 'put'], $csrfFilter['options']['on']);
    }

}
