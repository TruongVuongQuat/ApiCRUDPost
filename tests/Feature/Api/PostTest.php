<?php

namespace VCComponent\Laravel\TestPostManage\Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use VCComponent\Laravel\TestPostManage\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseTransactions;

    public function test_can_get_all_post()
    {
        $this->get('api/posts')->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *  @test
     * @return void
     */
    public function test_can_create_post()
    {
        $formData = [
            'title' => 'test title',
            'description' => 'test description',
            'content' => 'test content',
        ];
        $this->withExceptionHandling();
        $this->json('POST', 'api/posts', $formData)->assertStatus(200);
    }

    public function test_can_update_post()
    {
        $formData = [
            'title' => 'test title',
            'description' => 'test description',
            'content' => 'test content',
        ];
        $this->withExceptionHandling();
        $this->json('PUT', 'api/posts/1', $formData)->assertStatus(200);
    }

    public function test_can_delete_post()
    {
        $this->withExceptionHandling();
        $this->delete('api/posts/1')->assertStatus(200);
    }
}
