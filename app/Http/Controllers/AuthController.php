<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields=$request->validate([
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'profilePic'=>'nullable|string',
            'birthdate'=>'required|date',
            'email'=>'required|string|email|unique:users,email',
            'password'=>'required|string|confirmed'
        ]);

        $user=User::create([
            'first_name'=>$fields['first_name'],
            'last_name'=>$fields['last_name'],
            'profilePic'=>$fields['profilePic'],
            'birthdate'=>$fields['birthdate'],
            'email'=>$fields['email'],
            'password'=>bcrypt($fields['password']),
        ]);

        $token=$user->createToken('qwerty')->plainTextToken;

        return response([
            'user'=>$user,
            'token'=>$token
        ],201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message'=>'Logged out'
        ],200);
    }

    public function login(Request $request)
    {
        $fields=$request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);

        $user=User::where('email',$fields['email'])->first();

        if (!$user||!Hash::check($fields['password'],$user->password))
        {
            return response([
                'message'=>'Bad credentials'
            ],401);
        }

        $token=$user->createToken('qwerty')->plainTextToken;

        return response([
            'user'=>$user,
            'token'=>$token
        ],200);
    }
}
