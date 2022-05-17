<?php

namespace VCComponent\Laravel\TestPostManage\Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;

use VCComponent\Laravel\TestPostManage\Tests\TestCase;

use VCComponent\Laravel\TestPostManage\Models\Post;

class PostTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_post_list()
    {
        $posts = Post::factory(5)->create();
        $response = $this->call('GET', 'api/posts');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function can_get_post_with_id()
    {
        $posts = Post::factory()->create();
        $response = $this->call('GET', 'api/posts/' . $posts->id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function can_get_post_list_with_search()
    {
        $data = Post::factory(5)->create();
        $search = $data[0]->title;
        $data = $data->filter(function ($d) use ($search) {
            unset($d['created_at']);
            unset($d['updated_at']);
            return $d->title == $search;
        })->toArray();
        $response = $this->json('GET', 'api/posts?search=' . $search, $data);
        $response->assertStatus(200);
        $response->assertJson(['data' => $data]);
    }

    /**
     * @test
     */
    public function can_get_post_list_with_status_filter()
    {
        $data = Post::factory(5)->create();
        $status = $data[0]->status;
        $data = $data->filter(function ($d) use ($status) {
            unset($d['created_at']);
            unset($d['updated_at']);
            return $d->status == $status;
        })->toArray();
        $response = $this->json('GET', 'api/posts?status=' . $status, $data);
        $response->assertStatus(200);
        $response->assertJson(['data' => $data]);
    }

    /**
     * @test
     */
    public function can_get_post_list_with_status_filter_and_search()
    {
        $data = Post::factory(5)->create();
        $search = $data[0]->title;
        $status = $data[0]->status;
        $data = $data->filter(function ($d) use ($search, $status) {
            unset($d['created_at']);
            unset($d['updated_at']);
            if ($d->title == $search && $d->status == $status) {
                return true;
            } else {
                return false;
            }
        })->toArray();
        $response = $this->json('GET', 'api/posts?search=' . $search . '&status=' . $status, $data);
        $response->assertStatus(200);
        $response->assertJson(['data' => $data]);
    }

    /**
     * @test
     */
    public function can_create_post()
    {
        $post = Post::factory()->make()->toArray();
        $response = $this->json('POST', 'api/posts', $post);
        $response->assertStatus(200);
        $response->assertJson(['data' => $post]);
        $this->assertDatabaseHas('posts', $post);
    }

    /**
     * @test
     */
    public function can_update_post()
    {
        $post = Post::factory()->make();
        $post->save();

        unset($post['updated_at']);
        unset($post['created_at']);

        $id = $post->id;
        $post->title = 'update title';
        $data = $post->toArray();

        $response = $this->json('PUT', 'api/posts/' . $id, $data);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'title' => $data['title'],
            ],
        ]);
        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * @test
     */
    public function can_delete_post()
    {
        $post = Post::factory()->create()->toArray();

        unset($post['updated_at']);
        unset($post['created_at']);

        $this->assertDatabaseHas('posts', $post);

        $response = $this->call('DELETE', 'api/posts/' . $post['id']);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    /** @test */
    public function should_not_create_posts_with_null_title()
    {
        $post = Post::factory()->make([
            'title' => null,
        ])->toArray();
        $response = $this->json('POST', 'api/posts/', $post);
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The given data was invalid.']);
    }

    public function should_not_create_posts_with_same_title()
    {
        $post = Post::factory()->make([
            'title' => 'test',
        ])->toArray();
        $response = $this->json('POST', 'api/posts/', $post);
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function should_not_create_posts_with_null_description()
    {
        $post = Post::factory()->make([
            'description' => null,
        ])->toArray();
        $response = $this->json('POST', 'api/posts/', $post);
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function should_not_create_posts_with_null_content()
    {
        $post = Post::factory()->make([
            'content' => null,
        ])->toArray();
        $response = $this->json('POST', 'api/posts/', $post);
        $response->assertStatus(422);
        $response->assertJson(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function should_not_update_undefined_posts()
    {
        $post = Post::factory()->make()->toArray();

        $response = $this->json('PUT', 'api/posts/' . rand(1, 3), $post);

        $response->assertStatus(404);
        $response->assertJson(['message' => 'posts not found']);
    }

    /** @test */
    public function should_not_update_post_with_null_title()
    {
        $post = Post::factory()->create()->toArray();

        $post['title'] = null;

        $response = $this->json('PUT', 'api/posts/' . $post['id'], $post);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function should_not_update_post_with_null_description()
    {
        $post = $post = Post::factory()->create()->toArray();

        $post['description'] = null;

        $response = $this->json('PUT', 'api/posts/' . $post['id'], $post);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function should_not_update_post_with_null_content()
    {
        $post = $post = Post::factory()->create()->toArray();

        $post['content'] = null;

        $response = $this->json('PUT', 'api/posts/' . $post['id'], $post);

        $response->assertStatus(422);
        $response->assertJson(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function should_not_delete_post_with_undefined_id()
    {

        $response = $this->json('DELETE', 'api/posts/' . rand(1, 5));

        $response->assertStatus(400);
        $response->assertJson(['message' => 'posts not found']);
    }
}
