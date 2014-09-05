<?php

use Laracasts\TestDummy\Factory;

class AdminPostsControllerTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(Factory::create('User'));
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\PostsController@index');

        $this->assertResponseOk();
        $this->assertViewIs('admin.posts.index');
        $this->assertViewHas('posts');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\PostsController@create');

        $this->assertResponseOk();
        $this->assertViewIs('admin.posts.create');
    }

    public function testStore()
    {
        $this->action('POST', 'Admin\PostsController@store', [
            'title'   => 'Foo',
            'content' => 'Foo bar baz'
        ]);

        $this->assertRedirectedToRoute('admin.posts.show', 'foo');
    }

}
