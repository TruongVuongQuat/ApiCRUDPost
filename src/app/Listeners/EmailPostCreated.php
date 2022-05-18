<?php

namespace VCComponent\Laravel\TestPostManage\Listeners;

use Illuminate\Support\Facades\Mail;
use VCComponent\Laravel\TestPostManage\Events\PostCreatedEvent;

class EmailPostCreated
{
    public function handle(PostCreatedEvent $event)
    {
        $title = $event->post->title;
        $content = $event->post->toJson();
        Mail::send([], [], function ($message) use ($title, $content) {
            $message->to('admin@gmail.com', 'Post Create')
                ->subject('Post name ' . $title . 'has been created!')
                ->text($content);
        });
    }
}
