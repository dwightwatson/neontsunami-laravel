<?php

namespace Admin;

use NeonTsunami\User;

class ControllerTest extends \TestCase
{
    public function testRedirectsGuests()
    {
        $this->withSession([])
            ->visit('admin')
            ->seePageIs('admin/login')
            ->see("You'll need to login to access the admin section.");
    }

    public function testAllowsAuthenticatedAccess()
    {
        $this->actingAs(new User)
            ->visit('admin');
    }
}
