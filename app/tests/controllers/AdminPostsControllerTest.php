<?php

use Laracasts\TestDummy\Factory;

class AdminPostsControllerTest extends TestCase {

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
        $post = Factory::build('Post');

        $this->action('POST', 'Admin\PostsController@store', []);
    }

}
