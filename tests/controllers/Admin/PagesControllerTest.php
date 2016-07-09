<?php

namespace Admin;

use NeonTsunami\User;

class PagesControllerTest extends \TestCase
{
    public function testIndex()
    {
        $this->actingAs(new User)
            ->visit('admin');
    }

    public function testReports()
    {
        $this->actingAs(new User)
            ->visit('admin/reports');
    }
}
