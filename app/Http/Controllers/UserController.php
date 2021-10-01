<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function login(Request $request){
        $data = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user = User::where('email',$data['email'])->get()->first();
        if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])){
            return response()->json([
                'status'=>'success',
                'data'=>[
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'api_token'=>$user->api_token
                ]
            ]);
        }else {
            return response()->json([
                'status'=>'fail',
                'data'=>'No User Match '
            ]);
        }
    }

    public function register(Request $request){
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email|string|max:255|unique:users',
            'password'=>'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=> Hash::make($data['password']),
            'api_token'=>Str::random(36),
        ]);

        return response()->json(new UserResource($user));
    }

    public function update(Request $request, User $user){
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required',
        ]);

        // $this->check($data);
        try{
            $user->update($data);
        }catch(QueryException $ex){
            return response()->json([
                'status'=>'fail',
                'data'=>'Email Hasbeen Taken'
            ]);
        }

        return response()->json(new UserResource($user));
    }

    private function check($data){
        //case 1 : user did not change the wmail
        //
    }

}
