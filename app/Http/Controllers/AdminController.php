<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function getAdmin(Request $request)
    {
        $admin = auth()->user();
        return response()->json($admin, 200);
    }


    public function createAdmin($idAdmin){
        $admin = Admin::create([
            'user_id' => $idAdmin,
        ]);
        return response()->json($admin, 201);
    }


    public function updateAdmin(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'fullName' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:admins,email,' . auth()->id(),
            'mobile' => 'sometimes|required|string|max:15',
            'type' => 'sometimes|required|string',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $admin = auth()->user();
        $admin->update($request->only('fullName', 'email', 'mobile', 'type'));

        return response()->json(['message' => 'Admin updated successfully', 'admin' => $admin], 200);
    }





    public function deleteAdmin(Request $request)
    {
        $admin = auth()->user();
        

        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully'], 200);
    }


    
}
