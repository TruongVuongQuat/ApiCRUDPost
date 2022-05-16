<?php

namespace VCComponent\Laravel\TestPostManage\Repositories;

use VCComponent\Laravel\TestPostManage\Models\Post;

class PostRepository implements PostInterface
{
    public function all()
    {
        return Post::all();
    }

    public function show($id)
    {
        return Post::where('id', $id)->get();
    }

    public function store(array $data)
    {
        return Post::create($data);
    }

    public function update($id, array $data)
    {
        Post::where('id', $id)->update($data);
        $post = Post::find($id);
        return $post;
    }

    public function destroy($id)
    {
        return Post::find($id)->delete();
    }

    public function search($post)
    {
        return Post::where('title', 'like', '%' . $post . '%')
            ->orWhere('description', 'like', '%' . $post . '%')
            ->orWhere('content', 'like', '%' . $post . '%')->get();
    }

    public function filter_status($status)
    {
        return Post::where('status', $status)->get();
    }

    public function search_and_filter_status($search, $status)
    {
        return Post::where([
            ['title', 'like', '%' . $search . '%'],
            ['status', '=', $status]
        ])->orWhere([
            ['description', 'like', '%' . $search . '%'],
            ['status', '=', $status]
        ])->orWhere([
            ['content', 'like', '%' . $search . '%'],
            ['status', '=', $status]
        ])->get();
    }
}
