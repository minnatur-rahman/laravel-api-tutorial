<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // function to create user
    public function createUser(Request $request){

        return response()->json(['atatus' => true, 'message' => "Hello World"]);

    }
}
