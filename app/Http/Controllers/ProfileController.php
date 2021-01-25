<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function getByEmail(Request $request, $email){
        $user = User::where('email',$email)->first();

        return response([$user]);
    }
}
