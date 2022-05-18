<?php

namespace VCComponent\Laravel\TestPostManage\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use VCComponent\Laravel\TestPostManage\Models\Post;

class PostCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
