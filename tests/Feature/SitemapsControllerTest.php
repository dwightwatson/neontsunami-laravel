<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SitemapsControllerTest extends TestCase
{
    public function testSitemap()
    {
        $response = $this->get('/sitemap');

        $response->assertStatus(200);
    }
}
