<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
    {
    	$rules = [
    		'post_id' => 'required|exists:posts,id',
    		'content' => 'required'
    	];
    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
    		return response()->json([
    			'success' => false,
    			'message' => 'Data Failed To Save',
    			'errors' => $validator->errors()
    		], 422);
    	}

    	$input = [
    		'post_id' => $request->post_id,
    		'user_id' => auth()->user()->id,
    		'content' => $request->content
    	];
    	Comment::create($input);
    	return response()->json([
    		'success' => true,
    		'message' => 'Comment Saved Successfully'
    	]);
    }

    public function update(Request $request, $id)
    {
    	$rules = [
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
    		'content' => $request->content
    	];

    	Comment::find($id)->update($input);
    	return response()->json([
    		'success' => true,
    		'message' => 'Comment Updated Successfully'
    	]);
    }

    public function destroy($id)
    {
    	Comment::find($id)->delete();

		return response()->json([
    		'success' => true,
    		'message' => 'Comment Deleted Successfully'
    	]);
    }
}
