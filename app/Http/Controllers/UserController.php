<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\password_reset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

    public function deletePasswordResetToken(Request $request){
        $email = $request->email;
        $deleted = password_reset::where('email',$email)->delete();
      
        return response(['deleted'=>$deleted]);
    }
}
