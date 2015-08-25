<?php

namespace Admin;

use NeonTsunami\User;

class ControllerTest extends \TestCase
{
    public function testRedirectsGuests()
    {
        $this->call('GET', 'admin');

        $this->assertRedirectedToRoute('admin.sessions.create');
        $this->assertSessionHas('info', "You'll need to login to access the admin section.");
    }

    public function testAllowsAuthenticatedAccess()
    {
        $this->be(new User);

        $this->call('GET', 'admin');

        $this->assertResponseOk();
    }
}
