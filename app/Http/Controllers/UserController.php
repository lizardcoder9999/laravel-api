<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\password_reset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function forgotPasswordAction(Request $request){
        


        $forgotPassword = [
            'email' => $request->email,
            'token' => $request->token,
        ];

        

        $email = User::where('email', $forgotPassword['email']);
        
        $reqEmail = $request->email;

        if($email != null) {

            $forgotPassword['token'] = Hash::make($forgotPassword['token']);
            $user_reset = password_reset::create($forgotPassword);
            $link = "http://localhost:4200/reset-password/".$request->token;

            Mail::raw('Hello this is the password reset email you requested ' . ' ' . $link, function ($message) use ($reqEmail) {
                $message->from('site@domain.com', 'Site');
                $message->sender('site@domain.com', 'Website');
                $message->to($reqEmail, 'John Doe');
                $message->subject('Password Reset Request');
                
            });

            return response(['user_reset'=>$user_reset]);

        }else{
            return response(['message'=>'Email dosent exist']);
        }
    }

    public function deletePasswordResetToken(Request $request, $email){
    
        $deleted = password_reset::where('email',$email)->delete();
        $deleteTrashed = password_reset::onlyTrashed()->where('email',$email)->forceDelete();
      
        return response(['deleted'=>$deleted]);
    }

    public function verifyRouteAccess(Request $request){
        return response(["message" => "authorized"]);
    }

    public function verifyResetPageAccess(Request $request){
        $email = $request->email; 
        $token = $request->token;

        $exists = DB::table('password_resets')->where('email',$email);
        

        if($exists === null){
            return response(['message'=>'unauthorized'],401);
            
        }else{
          $dbToken = DB::table('password_resets')->where('email',$email)->pluck('token');
        
        
          if (Hash::check($token,$dbToken[0])) {
            return response(['message'=>'authorized']);
        }else{
              return response(['message'=>'unauthorized'],401);
          }

        
        }

    }


    public function updatePassword(Request $request){

        $email = $request->email;
        $password = $request->password;
        $hashedPass = Hash::make($password);
        $token = $request->token;
        $exists = DB::table('password_resets')->where('email',$email);

        if($exists === null){
            return  response(['message'=>'Email dosent exists'],404);
        }else{
            $dbToken = DB::table('password_resets')->where('email',$email)->pluck('token');
            if (Hash::check($token,$dbToken[0])) {
                User::where('email',$email)->update(['password' => $hashedPass]);
                return response(['message'=>'updated'],204);
            }else{
                return response(['message'=>'unauthorized',401]);
            }
            
        }


    }




}
