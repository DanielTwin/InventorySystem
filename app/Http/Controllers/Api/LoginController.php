<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Validator;


class LoginController extends Controller
{
    
    public function register (Request $request) {

    	$validator = $this->validate($request, [
    		'name' => 'required|string|max:255',
	        'email' => 'required|string|email|max:255|unique:users',
	        'role_id' => 'required|in:4',
	        'password' => 'required|string|min:8|confirmed',    //password minimum eight characters.
    	]);

		$request['password']=Hash::make($request['password']);
		$request['remember_token'] = Str::random(10);
		$user = User::create($request->toArray());
		$token = $user->createToken('authToken')->accessToken;
		$response = ['token' => $token];
		return response($response, 201);
	}

    public function login(Request $request){ 

        $login = $request->validate([
    		'email'=>'required|string',
    		'password'=>'required|string',
    	]);

    	if(!Auth::attempt($login)){
    		return response(['message'=>'Invalids Login Credentials']);
    	}

    	$accessToken = Auth::user()->createToken('authToken')->accessToken;
    	return response(['user'=>Auth::user(),'access_token'=>$accessToken]);
        
    }

    public function logout (Request $request) {
	    $token = $request->user()->token();
	    $token->revoke();
	    $response = ['message' => 'You have been successfully logged out!'];
	    return response($response, 200);
	}

}