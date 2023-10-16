<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
    	$posts = Post::with(['author:id,name,email','comments:id,post_id,content,user_id'])->get();
    	return response()->json([
    		'success' => true,
    		'message' => 'Successful in getting all the posts',
    		'data' => PostResource::collection($posts)
    	]);
    }

    public function show(Post $post)
    {
    	$data = $post->load(['author:id,name,email','comments:id,post_id,content,user_id']);
    	return response()->json([
    		'success' => true,
    		'message' => 'Successful in getting post',
    		'data' => new PostResource($data)
    	]);
    }

    public function store(Request $request)
    {
    	# code...
    }
}
