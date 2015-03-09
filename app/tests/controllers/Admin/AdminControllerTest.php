<?php
namespace Admin;

use User;

use Route;
use TestCase;

class AdminControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        Route::enableFilters();
    }

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
        $this->assertViewIs('admin.pages.index');
    }

}
