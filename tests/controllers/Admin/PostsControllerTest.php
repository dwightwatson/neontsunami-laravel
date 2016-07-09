<?php

namespace Admin;

use NeonTsunami\Post;
use NeonTsunami\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsControllerTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->actingAs(
            factory(User::class)->create()
        );
    }

    public function testIndex()
    {
        $this->visit('admin/posts')
            ->assertViewHas('posts');
    }

    public function testCreate()
    {
        $this->visit('admin/posts/create');
    }

    public function testStore()
    {
        $post = factory(Post::class)->make(['series_id' => null, 'slug' => 'foo']);

        $this->visit('admin/posts/create')
            ->submitForm('Create post', $post->getAttributes())
            ->seePageIs('admin/posts/foo')
            ->see($post->title);
    }

    public function testStoreWithTags()
    {
        $this->markTestIncomplete();
    }

    public function testStoreFails()
    {
        $this->visit('admin/posts/create')
            ->submitForm('Create post')
            ->seePageIs('admin/posts/create');
    }

    public function testShow()
    {
        $post = factory(Post::class)->create();

        $this->visit("admin/posts/{$post->slug}")
            ->see($post->title);
    }

    public function testEdit()
    {
        $post = factory(Post::class)->create();

        $this->visit("admin/posts/{$post->slug}/edit");
    }

    public function testUpdate()
    {
        $post = factory(Post::class)->create(['slug' => 'foo']);

        $this->visit('admin/posts/foo/edit')
            ->submitForm('Save post', ['slug' => 'bar'])
            ->seePageIs('admin/posts/bar');
    }

    public function testUpdateWithTags()
    {
        $this->markTestIncomplete();
    }

    public function testUpdateFails()
    {
        $post = factory(Post::class)->create(['slug' => 'foo']);

        $this->visit('admin/posts/foo/edit')
            ->submitForm('Save post', ['content' => null])
            ->seePageIs('admin/posts/foo/edit');
    }

    public function testDestroy()
    {
        $post = factory(Post::class)->create();

        $this->action('DELETE', 'Admin\PostsController@destroy', $post);

        $this->assertRedirectedToRoute('admin.posts.index');
        $this->assertEquals(0, Post::count());
    }
}
