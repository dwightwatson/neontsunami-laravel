<?php
namespace Admin;

use Post;

use TestCase;
use Laracasts\TestDummy\Factory;

class PostsControllerTest extends TestCase {

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
        $post = Factory::build('Post', ['title' => 'Foo']);

        $input = array_only($post->getAttributes(), $post->getFillable());

        $this->action('POST', 'Admin\PostsController@store', $input);

        $this->assertRedirectedToRoute('admin.posts.show', 'foo');
    }

    public function testStoreFails()
    {
        $this->action('POST', 'Admin\PostsController@store');

        $this->assertRedirectedToRoute('admin.posts.create');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testShow()
    {
        $post = Factory::create('Post');

        $this->action('GET', 'Admin\PostsController@show', $post->slug);

        $this->assertResponseOk();
        $this->assertViewIs('admin.posts.show');
        $this->assertViewHas('post');
    }

    public function testEdit()
    {
        $post = Factory::create('Post');

        $this->action('GET', 'Admin\PostsController@edit', $post->slug);

        $this->assertResponseOk();
        $this->assertViewIs('admin.posts.edit');
        $this->assertViewHas('post');
    }

    public function testUpdate()
    {
        $post = Factory::create('Post', ['slug' => 'foo']);

        $this->action('PUT', 'Admin\PostsController@update', $post->slug, [
            'title' => 'Bar'
        ]);

        $this->assertRedirectedToRoute('admin.posts.show', 'bar');
    }

    public function testUpdateFails()
    {
        $post = Factory::create('Post', ['slug' => 'foo']);

        $this->action('PUT', 'Admin\PostsController@update', $post->slug, [
            'title'   => 'Bar',
            'content' => null
        ]);

        $this->assertRedirectedToRoute('admin.posts.edit', 'foo');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $post = Factory::create('Post');

        $this->action('DELETE', 'Admin\PostsController@destroy', $post->slug);

        $this->assertRedirectedToRoute('admin.posts.index');
        $this->assertEquals(0, Post::count());
    }

}
