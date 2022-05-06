<?php

namespace VCComponent\Laravel\TestPostManage\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use VCComponent\Laravel\TestPostManage\Repositories\PostInterface;
use VCComponent\Laravel\TestPostManage\Transformers\PostTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\ResourceInterface;

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
        $post = $this->post->store($request->all());
        return response()->json(
            [
                'status' => true,
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
        $post = $this->post->show($id);
        return response()->json(
            [
                'status' => true,
                'data' => $post,
                'message' => 'OK'
            ]
        );
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
        $post = $this->post->update($id, $request->all());
        return response()->json(
            [
                'status' => true,
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
        $post = $this->post->destroy($id);
        return response()->json(
            [
                'status' => true,
                'data' => $post,
                'message' => 'Delete success'
            ]
        );
    }
}
