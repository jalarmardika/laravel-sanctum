<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    	$rules = [
    		'email' => 'required|email',
    		'password' => 'required'
    	];

    	$validator = Validator::make($request->all(), $rules);
    	if ($validator->fails()) {
    		return Response::json([
    			'success' => false,
    			'message' => 'Login Failed',
    			'errors' => $validator->errors()
    		], 401);
    	}

    	if (!Auth::attempt($request->only('email', 'password'))) {
    		return Response::json([
    			'success' => false,
    			'message' => 'Login Failed',
    		], 401);
    	}

    	$data = User::where('email', $request->email)->first();
    	return Response::json([
    		'success' => true,
    		'message' => 'Login Successfully',
    		'token' => $data->createToken('api-login')->plainTextToken
    	]);
    }

    public function logout(Request $request)
    {
    	$request->user()->currentAccessToken()->delete();

    	return Response::json([
    		'success' => true,
    		'message' => 'Logout Successfully'
    	]);
    }
}
