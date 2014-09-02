<?php namespace Watson\Testing\ModelHelpers;

class UserTest extends PHPUnit_Framework_TestCase {

    public $user;

    public function setUp()
    {
        $this->user = new User;
    }

    public function testValidatesEmail()
    {
        $this->assertValidatesRequired($this->user, 'email');
        $this->assertValidatesEmail($this->user, 'email');
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
