<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // USER REGISTER API - POST REQUEST
    public function register(Request $request){
        // VALIDATION
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:10',
        ]);

        // CREATE DATA
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_no = isset($request->phone_no) ? $request->phone_no : '';

        $user->save();

        // SEND RESPONSE
        return response()->json([
            'status' => 1,
            'message' => 'User register successfully'
        ]);

    }

    // USER LOGIN API - POST REQUEST
    public function login(Request $request){

        // VALIDATION
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        // VERIFY USER + TOKEN
        $token = Auth::attempt(['email' => $email, 'password' => $password]);
        if(!$token){
            return response()->json([
                'status' => 0,
                'message' => 'Invalid Credintials'
            ]);
        }

        // SEND RESPONSE
        return response()->json([
            'status' => 1,
            'message' => "User loggin successfully",
            'access_token' => $token
        ]);
    }

    // USER PROFILE API - GET REQUEST
    public function profile(){
        $user_data = Auth::user();

        return response()->json([
            'status' => 1,
            'message' => 'Get user details',
            'data' => $user_data
        ],200);
    }

    // USER LOGOUT API - GET REQUEST
    public function logout(){
        Auth::logout();

        return response()->json([
            'status' => 1,
            'message' => 'User logout successfully'
        ],200);
    }
}
