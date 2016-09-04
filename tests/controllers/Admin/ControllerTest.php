<?php

namespace Admin;

use NeonTsunami\User;

class ControllerTest extends \TestCase
{
    public function testRedirectsGuests()
    {
        $this->withSession([])
            ->visit('admin')
            ->seePageIs('admin/login');
    }

    public function testAllowsAuthenticatedAccess()
    {
        $this->actingAs(new User)
            ->visit('admin')
            ->seePageIs('admin');
    }
}
