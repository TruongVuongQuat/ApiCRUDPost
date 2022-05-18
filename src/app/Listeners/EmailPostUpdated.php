<?php

namespace VCComponent\Laravel\TestPostManage\Listeners;

use Illuminate\Support\Facades\Mail;
use VCComponent\Laravel\TestPostManage\Events\PostUpdatedEvent;

class EmailPostUpdated
{
    public function handle(PostUpdatedEvent $event)
    {
        $title = $event->post->title;
        $updatedAt = $event->post->updated_at;
        $content = $event->post->toJson();
        Mail::send([], [], function ($message) use ($title, $updatedAt, $content) {
            $message->to('admin@gmail.com', 'Post Updated')
                ->subject('Post name ' . $title . 'has been updated at ' . $updatedAt)
                ->text($content);
        });
    }
}
