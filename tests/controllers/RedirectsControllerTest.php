<?php

class RedirectsControllerTest extends TestCase
{
    public function testGetPost()
    {
        $this->action('GET', 'RedirectsController@getPost', ['foo']);

        $this->assertRedirectedToRoute('posts.show', 'foo');
    }

    public function testGetTag()
    {
        $this->action('GET', 'RedirectsController@getTag', ['foo']);

        $this->assertRedirectedToRoute('tags.show', 'foo');
    }
}
