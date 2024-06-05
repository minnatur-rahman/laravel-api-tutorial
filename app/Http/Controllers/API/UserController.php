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
            'email' => "required|string|unique:users",
            'phone' => "required|numeric",
            'password' => "required|min:6"
        ]);

        if($validator->fails()){
            $result = array('status' => false, 'message' => "Validation Error Occured", 'error_message' => $validator->errors());
            return response()->json($result, 400); //bad request
        }

        $user = user::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        if($user->id){
            $result = array('status' => true, 'message' => "User Created", 'data' => $user);
            $responseCode = 200; //success request
        }else{
            $result = array('status' => false, 'message' => "Something went wrong");
            $responseCode = 400;
        }

        return response()->json($result,$responseCode);

    }

    // function to return all users
    public function getUsers(){
            $users = User::all();
            $result = array('status' => true, 'message' => count($users). "user(s) fetched", 'data' => $users);
            $responseCode = 200; //success request
            return response()->json($result,$responseCode);

    }
}
