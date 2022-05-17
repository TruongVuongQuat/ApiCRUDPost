<?php

namespace VCComponent\Laravel\TestPostManage\Database\Factories;

use VCComponent\Laravel\TestPostManage\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->words(rand(4, 7), true),
            'description' => $this->faker->sentences(rand(4, 7), true),
            'content'     => $this->faker->paragraphs(rand(4, 7), true),
            'status' => 1
        ];
    }
}
