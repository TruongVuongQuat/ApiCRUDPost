<?php

namespace VCComponent\Laravel\TestPostManage\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use VCComponent\Laravel\TestPostManage\Repositories\PostInterface;
use VCComponent\Laravel\TestPostManage\Transformers\PostTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use VCComponent\Laravel\TestPostManage\Events\PostCreatedEvent;
use VCComponent\Laravel\TestPostManage\Events\PostDeletedEvent;
use VCComponent\Laravel\TestPostManage\Events\PostUpdatedEvent;
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
        if (isset($_GET['search']) && isset($_GET['status'])) {
            $posts = $this->post->search_and_filter_status($_GET['search'], $_GET['status']);
            $posts = new Collection($posts, $this->postTransformer);
            $posts = $this->fractal->createData($posts);
            return $posts->toArray();
        } else if (isset($_GET['search'])) {
            $posts = $this->post->search($_GET['search']);
            $posts = new Collection($posts, $this->postTransformer);
            $posts = $this->fractal->createData($posts);
            return $posts->toArray();
        } else if (isset($_GET['status'])) {
            $posts = $this->post->filter_status($_GET['status']);
            $posts = new Collection($posts, $this->postTransformer);
            $posts = $this->fractal->createData($posts);
            return $posts->toArray();
        } else {
            $posts = $this->post->all();
            $posts = new Collection($posts, $this->postTransformer);
            $posts = $this->fractal->createData($posts);
            return $posts->toArray();
        }
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
                    'data' => $request->all(),
                    'message' => 'The given data was invalid.'
                ],
                422
            );
        }
        $post = $this->post->store($request->all());
        event(new PostCreatedEvent($post));
        return response()->json(
            [
                'data' => $post,
                'message' => 'Create success'
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
                    'data' => [],
                    'message' => 'Post not found!'
                ],
                404
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
                    'data' => $request->all(),
                    'message' => 'The given data was invalid.'
                ],
                422
            );
        }
        $post = $this->post->update($id, $request->all());
        if (isset($post)) {
            event(new PostUpdatedEvent($post));
            return response()->json(
                [
                    'data' => $post,
                    'message' => 'update success'
                ]
            );
        } else {
            return response()->json(
                [
                    'data' => $post,
                    'message' => 'posts not found'
                ],
                404
            );
        }
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
            event(new PostDeletedEvent($checkPost));
            return response()->json(
                [
                    'data' => $checkPost,
                    'message' => 'Delete success',
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'data' => $checkPost,
                    'message' => 'posts not found',
                    'success' => false,
                ],
                400
            );
        }
    }
}
