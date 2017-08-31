<?php

namespace Tests\Feature;

use Tests\TestCase;

class SitemapsControllerTest extends TestCase
{
    public function testSitemap()
    {
        $response = $this->get('/sitemap');

        $response->assertStatus(200);
    }
}
