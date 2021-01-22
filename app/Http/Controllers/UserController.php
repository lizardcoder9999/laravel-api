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

        $email = User::where('email', $forgotPassword['email']);

        if($email != null) {


            $forgotPassword['token'] = bcrypt($forgotPassword['token']);
            $user_reset = password_reset::create($forgotPassword);
            $link = "http://localhost:4200/reset-password/".$request->token;

            Mail::raw('Hello this is the password reset email you requested ' + ' ' + $link, function ($message) {
                $message->from('site@domain.com', 'Site');
                $message->sender('site@domain.com', 'Website');
                $message->to($forgotPassword['email'] , 'John Doe');
                $message->subject('Password Reset Request');
                
            });

            return response(['user_reset'=>$user_reset]);

        }else{
            return response(['message'=>'Email dosent exist']);
        }

        
        
        

        
    
    }

    public function deletePasswordResetToken(Request $request){
        $email = $request->email;
        $deleted = password_reset::where('email',$email)->delete();
      
        return response(['deleted'=>$deleted]);
    }

    public function verifyRouteAccess(Request $request){
        return response(["message" => "authorized"]);
    }




}
