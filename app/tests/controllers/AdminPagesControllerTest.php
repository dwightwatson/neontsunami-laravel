<?php

class AdminPagesControllerTest extends TestCase {

    public function testIndex()
    {
        $this->action('GET', 'Admin\PagesController@index');

        $this->assertResponseOk();
        $this->assertViewIs('admin.pages.index');
    }

    public function testReports()
    {
        $this->action('GET', 'Admin\PagesController@reports');

        $this->assertResponseOk();
        $this->assertViewIs('admin.pages.reports');
    }

}
