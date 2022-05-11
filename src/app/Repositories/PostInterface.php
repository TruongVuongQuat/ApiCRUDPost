<?php

namespace VCComponent\Laravel\TestPostManage\Repositories;

interface PostInterface
{
    public function all();

    public function show($id);

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);

    public function search($post);

    public function filter_status($status);
}
