<?php

namespace VCComponent\Laravel\TestPostManage\Tests\Unit;

use VCComponent\Laravel\TestPostManage\Tests\TestCase;
use VCComponent\Laravel\TestPostManage\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_post_has_a_title()
    {
        $post = Post::factory()->create(['title' => 'Fake Title']);
        $this->assertEquals('Fake Title', $post->title);
    }

    /** @test */
    function a_post_has_a_body()
    {
        $post = Post::factory()->create(['content' => 'Fake content']);
        $this->assertEquals('Fake content', $post->content);
    }
}
