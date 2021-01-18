<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class RegisterController extends Controller
{
    public function register(Request $request){
        $register = $request->validate([
            'name' => 'required|string',
            'email' => 'email|required|unique:users',
            'password' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'required|string',
            'country' => 'required|string',
        ]);

        $register['password'] = bcrypt($register['password']);

        $user = User::create($register);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=>$user,'access_token'=>$accessToken]);
    
    }
}
