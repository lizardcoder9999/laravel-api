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

    public function updateByEmail(Request $request, $email){

        $updateduser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        User::where('email',$email)->update($updateduser);

        return response([$updateduser]);
    }
}

