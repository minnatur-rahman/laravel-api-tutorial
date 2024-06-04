<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // function to create user
    public function createUser(Request $request){

        $user = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        if($user->id){
            $result = array('status' => true, 'message' => "User Created", 'data' => $user);
            $responseCode = 200;
        }else{
            $result = array('status' => false, 'message' => "Something went wrong");
            $responseCode = 400;
        }

        return response()->json($result, $responseCode);

    }
}
