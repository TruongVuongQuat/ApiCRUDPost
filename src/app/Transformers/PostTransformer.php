<?php

namespace VCComponent\Laravel\TestPostManage\Transformers;

use League\Fractal\TransformerAbstract;
use VCComponent\Laravel\TestPostManage\Models\Post;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'content' => $post->content,
            'status' => $post->status
        ];
    }
}
