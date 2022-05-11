<?php

namespace VCComponent\Laravel\TestPostManage\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use VCComponent\Laravel\TestPostManage\Repositories\PostInterface;
use VCComponent\Laravel\TestPostManage\Transformers\PostTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use VCComponent\Laravel\TestPostManage\Models\Post;

class PostController extends Controller
{

    protected $post;
    protected $postTransformer;
    protected $fractal;

    public function __construct(PostInterface $postInterface, Manager $fractal, PostTransformer $postTransformer)
    {
        $this->post = $postInterface;
        $this->postTransformer = $postTransformer;
        $this->fractal = $fractal;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->post->all();
        $posts = new Collection($posts, $this->postTransformer);
        $posts = $this->fractal->createData($posts);
        return $posts->toArray();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:posts,title|max:255',
            'description' => 'required',
            'content' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'data' => $request->all(),
                    'message' => $validator->errors()
                ]
            );
        }
        $post = $this->post->store($request->all());
        return response()->json(
            [
                'status' => 200,
                'data' => $post,
                'message' => 'OK'
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $checkPost = Post::find($id);
        if (isset($checkPost->id)) {
            $post = $this->post->show($id);
            $post = new Collection($post, $this->postTransformer);
            $post = $this->fractal->createData($post);
            return $post->toArray();
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'data' => [],
                    'message' => 'Post not found!'
                ]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|unique:posts,title,' . $id . '|max:255',
            'description' => 'required',
            'content' => 'required',
            'status' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'data' => $request->all(),
                    'message' => $validator->errors()
                ]
            );
        }
        $post = $this->post->update($id, $request->all());
        return response()->json(
            [
                'status' => 200,
                'data' => $post,
                'message' => 'update success'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $checkPost = Post::find($id);
        if (isset($checkPost->id)) {
            $post = $this->post->destroy($id);
            return response()->json(
                [
                    'status' => 200,
                    'data' => $checkPost,
                    'message' => 'Delete success'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 404,
                    'data' => $checkPost,
                    'message' => 'Post not found'
                ]
            );
        }
    }

    public function search($post)
    {
        $posts = $this->post->search($post);
        $posts = new Collection($posts, $this->postTransformer);
        $posts = $this->fractal->createData($posts);
        return $posts->toArray();
    }

    public function filter_status($status)
    {
        $posts = $this->post->filter_status($status);
        $posts = new Collection($posts, $this->postTransformer);
        $posts = $this->fractal->createData($posts);
        return $posts->toArray();
    }
}
