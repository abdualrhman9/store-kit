<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function register(Request $request){
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email|string|max:255|unique:users',
            'password'=>'required|string|min:8confirmed',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=> Hash::make($data['password']),
            'api_token'=>Str::random(36),
        ]);

        return response()->json(new UserResource($user));
    }
}
