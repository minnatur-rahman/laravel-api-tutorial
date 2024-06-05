<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // function to create user
    public function createUser(Request $request){

        // validation
        $validator = Validator::make($request->all(),[
            'name' => "required|string",
            'email' => "required|string",
            'phone' => "required|numeric",
            'password' => "required|min:6"
        ]);

        if($validator->fails()){
            $result = array('status' => false, 'message' => "Validation Error Occured", 'error_message' => $validator->error());
            return response()->json($result,$responseCode);
        }

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

        return response()->json($result,$responseCode);

    }
}
