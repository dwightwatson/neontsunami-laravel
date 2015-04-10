<?php namespace Admin;

use NeonTsunami\User;

class PagesControllerTest extends \TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\PagesController@index');

        $this->assertResponseOk();
    }

    public function testReports()
    {
        $this->action('GET', 'Admin\PagesController@reports');

        $this->assertResponseOk();
    }

}
