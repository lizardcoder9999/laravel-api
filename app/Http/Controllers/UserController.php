<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\password_reset;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function forgotPasswordAction(Request $request){

        

        $forgotPassword = [
            'email' => $request->email,
            'token' => $request->token,
        ];

        
        $forgotPassword['token'] = bcrypt($forgotPassword['token']);

        $user_reset = password_reset::create($forgotPassword);

        return response(['user_reset'=>$user_reset]);
    
    }
}
