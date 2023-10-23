<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class ProfileController extends Controller
{
    // public function viewProfile($id)
    // {
    //     $user=User::where('id',$id)->first();
    //     return response([
    //         'id'=>$user->id,
    //         'first_name'=>$user->first_name,
    //         'last_name'=>$user->last_name,
    //         'profile_pic'=>str_replace('\\','/',storage_path('app/public/images/'.$user->profilePic)),
    //         'email'=>$user->email,
    //         'birthdate'=>$user->birthdate,
    //         'isVerified'=>$user->isVerified,
    //         'isActive'=>$user->isActive
    //     ],200);
    // }

    public function viewProfile(Request $request)
    {
        return response([
            'id'=>$request->user()->id,
            'first_name'=>$request->user()->first_name,
            'last_name'=>$request->user()->last_name,
            'profile_pic'=>str_replace('http','https',str_replace('\\','/',url('api/profilepic/'.str_replace('.','p3r10D',$request->user()->profilePic)))),
            'email'=>$request->user()->email,
            'birthdate'=>$request->user()->birthdate,
            'isVerified'=>$request->user()->isVerified,
            'isActive'=>$request->user()->isActive
        ],200);
    }
}
