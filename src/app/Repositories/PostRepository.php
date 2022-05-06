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
        return Post::where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        return Post::destroy($id);
    }
}
