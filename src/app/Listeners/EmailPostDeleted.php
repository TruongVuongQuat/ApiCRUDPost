<?php

namespace VCComponent\Laravel\TestPostManage\Listeners;

use Illuminate\Support\Facades\Mail;
use VCComponent\Laravel\TestPostManage\Events\PostDeletedEvent;

class EmailPostDeleted
{
    public function handle(PostDeletedEvent $event)
    {
        $title = $event->post->title;
        $content = $event->post->toJson();
        Mail::send([], [], function ($message) use ($title, $content) {
            $message->to('admin@gmail.com', 'Post deleted')
                ->subject('Post name ' . $title . 'has been deleted!')
                ->text($content);
        });
    }
}
