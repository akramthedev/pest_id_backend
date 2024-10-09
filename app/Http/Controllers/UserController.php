<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
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
            'type' => "admin",
            "canAccess" => 0, 
            "isEmailVerified" => 0
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }





    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 202);
        }
    
        if (!$user->canAccess) {  
            return response()->json(['message' => "Veuillez attendre l'approuvation d'un admin."], 203);
        }
    
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 202);
        }
    
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        return response()->json(['message' => 'Login successful', 'token' => $token, 'user' => $user], 200);
    }
    
        
    
    
    public function refuserUser($id)
    {
        // Validate that the user ID exists
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        // Delete the user
        $user->delete();
    
        return response()->json(['message' => 'User successfully deleted.'], 200);
    }
    
    

    public function accepterUser($id)
    {
        // Validate that the user ID exists
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Update canAccess and isEmailVerified attributes
        $user->canAccess = 1; // Set canAccess to true (1)
        $user->isEmailVerified = 1; // Set isEmailVerified to true (1)
        $user->save(); // Save the changes

        return response()->json(['message' => 'User access granted and email verification set to true.'], 200);
    }





    public function getUserById($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

         return response()->json($user, 200);
    }

    
    public function getAdminIdFromUserId($idUser)
    {
        $admin = Admin::where('user_id', $idUser)->first();

         if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 299);
        }
    
         return response()->json($admin, 200);
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

    

    public function updatePassword(Request $request, $id)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'ancien' => 'required|string',
        'nouveau' => 'required|string|min:5',
        'confirmnouveau' => 'required|string|min:5',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json($validator->errors(), 399);
    }

    // Find the user by ID
    $user = User::find($id);

    // Check if the user exists
    if (!$user) {
        return response()->json(['message' => 'User not found'], 301);
    }

    // Verify the old password
    if (!Hash::check($request->ancien, $user->password)) {
        return response()->json(['message' => 'Ancien mot de passe ne matche pas'], 287);
    }

     

    // Update the password
    $user->password = Hash::make($request->nouveau);
    $user->save();

    return response()->json(['message' => 'Mot de passe changé avec succès!'], 200);
}





    public function updateUserRestriction($id, $access)
    {
        // Validate that the user ID exists
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        if($access === "canNotAccess"){
            //we give him access = 1
            $user->canAccess = 1;  
        }
        else{
            // we give him access = 0
            $user->canAccess = 0;  
        }
        $user->save();  

        return response()->json(['message' => 'User access updated successfully.', 'user' => $user], 200);
    }




    public function getAllUsersNonAccepted()
    {
        $users = User::where('canAccess', 0)->where('isEmailVerified', 0)->get();
        $data =  [
            'status' => 200,
            'users' => $users
        ];

        return response()->json($data, 200);
    }

    public function updateUser(Request $request, $idUser)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $idUser, 
            'mobile' => 'nullable|string|max:20',
            'image' => 'nullable|string',
            'type'=> "required|string"
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        // Find the user by ID
        $user = User::find($idUser);
    
        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        // Update the user's attributes
        $user->update($request->only('fullName', 'email', 'mobile', 'image', 'type'));
    
        // Return a success response
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
