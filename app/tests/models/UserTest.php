<?php

use Illuminate\Support\Facades\Hash;

class UserTest extends PHPUnit_Framework_TestCase {

    use Watson\Testing\ModelHelpers;

    public $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = new User;
    }

    public function tearDown()
    {
        parent::tearDown();

        Mockery::close();
    }

    public function testValidatesFirstName()
    {
        $this->assertValidatesRequired($this->user, 'first_name');
    }

    public function testValidatesLastName()
    {
        $this->assertValidatesRequired($this->user, 'last_name');
    }

    public function testValidatesEmail()
    {
        $this->assertValidatesRequired($this->user, 'email');
        $this->assertValidatesEmail($this->user, 'email');
    }

    public function testValidatesPassword()
    {
        $this->assertValidatesRequired($this->user, 'password');
    }

    public function testGetFullNameAttribute()
    {
        $this->user->first_name = 'Foo';
        $this->user->last_name = 'Bar';

        $this->assertEquals('Foo Bar', $this->user->full_name);
    }

    public function testSetPasswordAttribute()
    {
        Hash::shouldReceive('make')
            ->with('secret')
            ->once()
            ->andReturn('foo');

        $this->user->password = 'secret';

        $this->assertEquals('foo', $this->user->password);
    }

    public function testHasManyPosts()
    {
        $this->assertHasMany('User', 'Posts');
    }

    /**
     * @todo Need assertion for hasManyThrough
     */
    public function testHasManyTagsThroughPosts()
    {

    }

}
