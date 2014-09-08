<?php

class SitemapsControllerTest extends TestCase {

    public function testSitemap()
    {
        $this->action('GET', 'SitemapsController@index');

        $this->assertResponseOk();
    }

}
