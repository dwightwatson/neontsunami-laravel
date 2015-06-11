<?php

namespace Admin;

use NeonTsunami\Post;
use NeonTsunami\User;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->be(new User);
    }

    public function testIndex()
    {
        $this->action('GET', 'Admin\PostsController@index');

        $this->assertResponseOk();
        $this->assertViewHas('posts');
    }

    public function testCreate()
    {
        $this->action('GET', 'Admin\PostsController@create');

        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->be(factory(User::class)->create());

        $post = factory(Post::class)->make(['series_id' => null]);

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
        $post = factory(Post::class)->create();

        $this->action('GET', 'Admin\PostsController@show', $post);

        $this->assertResponseOk();
        $this->assertViewHas('post');
    }

    public function testEdit()
    {
        $post = factory(Post::class)->create();

        $this->action('GET', 'Admin\PostsController@edit', $post);

        $this->assertResponseOk();
        $this->assertViewHas('post');
    }

    public function testUpdate()
    {
        $post = factory(Post::class)->create(['slug' => 'foo']);

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
        $post = factory(Post::class)->create(['slug' => 'foo']);

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
        $post = factory(Post::class)->create();

        $this->action('DELETE', 'Admin\PostsController@destroy', $post);

        $this->assertRedirectedToRoute('admin.posts.index');
        $this->assertEquals(0, Post::count());
    }
}
