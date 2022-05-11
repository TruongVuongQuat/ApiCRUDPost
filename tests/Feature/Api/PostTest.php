<?php

namespace VCComponent\Laravel\TestPostManage\Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use VCComponent\Laravel\TestPostManage\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function test_validate_create_post()
    {
        $formData = [
            'title' => 'title',
            'description' => 'test description',
            'content' => 'test content',
            'status' => 1,
        ];
        $this->withExceptionHandling();
        $response = $this->call('POST', 'api/posts')->assertStatus(200);
        $response->assertJson(['data' => $formData]);
    }


    public function test_validate_update_post()
    {
        $formData = [
            'title' => 'test title',
            'description' => 'test description',
            'content' => 'test content',
            'status' => 1
        ];
        $this->withExceptionHandling();
        $response = $this->call('POST', 'api/posts/{id}', $formData)->assertStatus(200);
        $response->assertJson(['message' => 'update success']);
    }

    public function test_can_delete_post()
    {
        $this->withExceptionHandling();
        $this->json('DELETE', 'api/posts/1')->assertStatus(200);
    }

    public function test_can_search_post()
    {
        $this->withExceptionHandling();
        $this->json('GET', 'api/search/{post}')->assertStatus(200);
    }

    public function test_filter_status()
    {
        $this->withExceptionHandling();
        $this->json('GET', 'api/posts-filter/{status}')->assertStatus(200);
    }
}
