<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
    	$posts = Post::with(
    		[
    			'author:id,name,email',
    			'comments' => function($query) {
    				return $query->orderBy('id', 'desc')->pluck('id','post_id','content','created_at','updated_at','user_id');
    			}
    		]
    	)
		->orderBy('id', 'desc')
		->get();

    	return response()->json([
    		'success' => true,
    		'message' => 'Successful in getting all the posts',
    		'data' => PostResource::collection($posts)
    	]);
    }

    public function show(Post $post)
    {
    	$data = $post->load(['author:id,name,email','comments:id,post_id,content,created_at,updated_at,user_id']);
    	return response()->json([
    		'success' => true,
    		'message' => 'Successful in getting post',
    		'data' => new PostResource($data)
    	]);
    }

    public function store(Request $request)
    {
    	$rules = [
    		'title' => 'required|max:255',
    		'content' => 'required'
    	];
    	if ($request->file('image')) {
    		$rules['image'] = 'image|file|max:1024';
    	}

    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
    		return response()->json([
    			'success' => false,
    			'message' => 'Data Failed To Save',
    			'errors' => $validator->errors()
    		], 422);
    	}

    	$input = [
    		'title' => $request->title,
    		'user_id' => auth()->user()->id,
    		'content' => $request->content
    	];
    	if ($request->file('image')) {
    		$input['image'] = $request->file('image')->store('post-images');
    	}

    	Post::create($input);
    	return response()->json([
    		'success' => true,
    		'message' => 'Post Saved Successfully'
    	]);
    }

    public function update(Request $request, $id)
    {
    	$rules = [
    		'title' => 'required|max:255',
    		'content' => 'required'
    	];
    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
    		return response()->json([
    			'success' => false,
    			'message' => 'Data Failed To Update',
    			'errors' => $validator->errors()
    		], 422);
    	}

    	$input = [
    		'title' => $request->title,
    		'content' => $request->content
    	];

    	Post::find($id)->update($input);
    	return response()->json([
    		'success' => true,
    		'message' => 'Post Updated Successfully'
    	]);
    }

    public function destroy($id)
    {
    	$post = Post::find($id);
		if ($post->image != "") {
			Storage::delete($post->image);
		}

		$post->delete();

		return response()->json([
    		'success' => true,
    		'message' => 'Post Deleted Successfully'
    	]);
    }
}
