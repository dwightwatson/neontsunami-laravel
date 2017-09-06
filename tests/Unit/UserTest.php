<?php

namespace App;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = new User;
    }

    public function testGetFullNameAttribute()
    {
        $this->user->first_name = 'Foo';
        $this->user->last_name = 'Bar';

        $this->assertEquals('Foo Bar', $this->user->full_name);
    }
}
