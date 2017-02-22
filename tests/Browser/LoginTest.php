<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testLoginWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email'    => 'test@example.com',
            'password' => 'secret'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new Login)
                ->attempt($user->email, 'secret')
                ->assertPathIs('/admin');
        });
    }

    public function testLoginWithIncorrectCredentials()
    {
        $user = factory(User::class)->create([
            'email'    => 'test@example.com',
            'password' => 'secret'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit(new Login)
                ->attempt($user->email, 'password')
                ->assertPathIs('/admin/login')
                ->assertSee('Your login credentials were invalid.');
        });
    }
}
