<?php

namespace VCComponent\Laravel\TestPostManage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded  = [];

    protected static function newFactory()
    {
        return \VCComponent\Laravel\TestPostManage\Database\Factories\PostFactory::new();
    }
}
