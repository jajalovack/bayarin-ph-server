<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class ProfileController extends Controller
{
    public function viewProfile($id)
    {
        $user=User::where('id',$id)->first();
        return response([
            'id'=>$user->id,
            'first_name'=>$user->first_name,
            'last_name'=>$user->last_name,
            'profile_pic'=>str_replace('\\','/',storage_path('app/public/images/'.$user->profilePic)),
            'email'=>$user->email,
            'birthdate'=>$user->birthdate,
            'isVerified'=>$user->isVerified,
            'isActive'=>$user->isActive
        ],200);
    }
}
