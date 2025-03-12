<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;



class AuthController extends Controller
{
    public function register(RegisterUserRequest $request){

        // return 'login';

        $validated = $request->validated();

        // dd($validated);

        $user = User::create($validated);
        // dd($user);

        $token = $user->createToken($request->name);

        return [ 
            'user'=> $user,
            'token'=> $token->plainTextToken
        ];
    } 

    public function login(LoginUserRequest $request){

        $validated = $request->validated();

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password ,$user->password))
        {
            return ['message'=> 'the provided credentails are incorrect'];
        }
   
        $token = $user->createToken($user->name);

        return [ 
            'user'=> $user,
            'token'=> $token->plainTextToken
        ];        
    }

    public function logout(Request $request){

        // dd($request);
        $request->user()->tokens()->delete();
        return ['message'=> 'You are logged out']; 
    }
}
