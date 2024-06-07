<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // function to create user
    public function createUser(Request $request){

        // validation
        $validator = Validator::make($request->all(),[
            'name' => "required|string",
            'email' => "required|string|unique:users",
            'phone' => "required|numeric|digits:11",
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
        try{
            $users = User::all();
            $result = array('status' => true, 'message' => count($users). "user(s) fetched", 'data' => $users);
            $responseCode = 200;
            return response()->json($result,$responseCode);
        }catch(Exception $e){
            $result = array('status' => false, 'message' => "API faild due to an error", 'error' => $e->getMessage());
            return response()->json($result, 500);
        }
    }

     // function to return all users detail
     public function getUserDetail($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['status' => false, 'message' => "Users not found"], 404);
        }

        $result = array('status' => true, 'message' => "User found", 'data' => $user);
        $responseCode = 200; //success request
        return response()->json($result,$responseCode);

    }

    // function to update user
    public function updateUser(Request $request, $id){

    $user = User::find($id);
    if(!$user){
        return response()->json(['status' => false, 'message' => "Users not found"], 404);
    }

    // validation
    $validator = Validator::make($request->all(),[
        'name' => "required|string",
        'email' => "required|string|unique:users,email,",$id,
        'phone' => "required|numeric|digits:11"

    ]);

    if($validator->fails()){
        $result = array('status' => false, 'message' => "Validation Error Occured", 'error_message' => $validator->errors());
        return response()->json($result, 400); //bad request
    }

    // update code
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->save();

    $result = array('status' => true, 'message' => "User has been updated successfully !", 'data' => $user);
    return response()->json($result, 200);
    }

    // function to delete user
    public function deleteUser($id){

    $user = User::find($id);
    if(!$user){
        return response()->json(['status' => false, 'message' => "Users not found"], 404);
    }

    $user->delete();
    $result = array('status' => true, 'message' => "User has been deleted successfully !");
    return response()->json($result, 200);
    }

    // login function
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
    }
}
