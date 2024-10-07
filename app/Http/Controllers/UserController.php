<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\AuthorizationException;


class UserController extends Controller
{


    
    public function register(Request $request)
    {

         
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'type' => "admin"
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }






    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(['message' => 'Login successful', 'token' => $token, 'user' => $user], 200);
    }

    


    public function getUser(Request $request)
    {
        return response()->json($request->user());
    }

    public function getAllUsers()
    {
        $users = User::all();
        $data =  [
            'status'=>200,
            'users'=>$users
        ];

        return response()->json($data, 200);
    }



    public function updateUser(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'fullName' => 'sometimes|required|string|max:255',
            'mobile' => 'sometimes|required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->update($request->only('fullName', 'mobile'));
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }




    public function updateUserType(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = $request->user();

        $user->type = $request->type;
        $user->save();

        return response()->json(['message' => 'User type updated successfully', 'user' => $user], 200);
    }




    public function deleteUser(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            throw new AuthorizationException('User not found.');
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
