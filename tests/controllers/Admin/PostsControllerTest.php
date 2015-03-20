<?php namespace Admin;

use NeonTsunami\Post;
use NeonTsunami\User;

use Laracasts\TestDummy\Factory;
use Laracasts\TestDummy\DbTestCase;

class PostsControllerTest extends DbTestCase {

    public function setUp()
    {
        parent::setUp();

        $this->be(Factory::create(User::class));
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
        $post = Factory::build(Post::class, ['series_id' => null]);

        $input = array_only($post->getAttributes(), $post->getFillable());

        $this->action('POST', 'Admin\PostsController@store', $input);

        $this->assertRedirectedToRoute('admin.posts.show', $post->slug);
    }

    public function testStoreWithTags()
    {
        $this->markTestIncomplete();
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
        $post = Factory::create(Post::class);

        $this->action('GET', 'Admin\PostsController@show', $post);

        $this->assertResponseOk();
        $this->assertViewIs('admin.posts.show');
        $this->assertViewHas('post');
    }

    public function testEdit()
    {
        $post = Factory::create(Post::class);

        $this->action('GET', 'Admin\PostsController@edit', $post);

        $this->assertResponseOk();
        $this->assertViewIs('admin.posts.edit');
        $this->assertViewHas('post');
    }

    public function testUpdate()
    {
        $post = Factory::create(Post::class, ['slug' => 'foo']);

        $input = array_only($post->getAttributes(), $post->getFillable());

        $input['slug'] = 'bar';

        $this->action('PUT', 'Admin\PostsController@update', $post, $input);

        $this->assertRedirectedToRoute('admin.posts.show', 'bar');
    }

    public function testUpdateWithTags()
    {
        $this->markTestIncomplete();
    }

    public function testUpdateFails()
    {
        $post = Factory::create(Post::class, ['slug' => 'foo']);

        $this->action('PUT', 'Admin\PostsController@update', $post, [
            'title'   => 'Bar',
            'content' => null
        ]);

        $this->assertRedirectedToRoute('admin.posts.edit', 'foo');
        $this->assertHasOldInput();
        $this->assertSessionHasErrors();
    }

    public function testDestroy()
    {
        $post = Factory::create(Post::class);

        $this->action('DELETE', 'Admin\PostsController@destroy', $post);

        $this->assertRedirectedToRoute('admin.posts.index');
        $this->assertEquals(0, Post::count());
    }

}
