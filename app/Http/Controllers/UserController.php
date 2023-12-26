<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
    	$rules = [
    		'name' => 'required|max:255',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|max:255'
    	];

    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
    		return Response::json([
    			'success' => false,
    			'message' => 'Register Failed',
    			'errors' => $validator->errors()
    		], 401);
    	}

    	$user = new User();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->save();

    	return Response::json([
    		'success' => true,
    		'message' => 'Registration Successfully',
    		'data' => new UserResource($user)
    	]);
    }

    public function profile()
    {
    	return Response::json(new UserResource(Auth::user()));
    }
}
