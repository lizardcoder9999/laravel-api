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


            // $forgotPassword['token'] = bcrypt($forgotPassword['token']);
            $forgotPassword['token'] = Hash::make('password', [
                'rounds' => 12,
            ]);
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

    public function deletePasswordResetToken(Request $request){
        $email = $request->email;
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

        // $exists = password_reset::where('email', $email)->get();
        $exists = DB::table('password_resets')->where('email',$email);
        

        if($exists === null){
            return response(['message'=>'unauthorized'],401);
            
        }else{
          $dbToken = $exists->select('token')->get();
        
          return response(['message'=>$request]);
        
        //   if(Hash::check($token, $dbToken->token))  {
        //       return response(['message'=>'authorized']);
        //   }else{
        //       return response(['message'=>'error occured'],401);
        //   }
         
        }

    }




}
