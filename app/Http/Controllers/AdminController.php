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

    public function getAdminById($id)
    {
        $admin = Admin::where('user_id', $id)->first();
    
        if ($admin) {
            return response()->json($admin, 200); 
        }
    
        return response()->json(['message' => 'Admin not found'], 202);
    }



    public function updateAdmin(Request $request, $idUser)
    {

        $admin = Admin::where('user_id', $idUser)->first();
    
        $admin->update($request->only('company_name', 'company_mobile', 'company_email'));

        return response()->json(['message' => 'Admin updated successfully', 'admin' => $admin], 200);
    }





    public function deleteAdmin(Request $request)
    {
        $admin = auth()->user();
        

        $admin->delete();

        return response()->json(['message' => 'Admin deleted successfully'], 200);
    }


    
}
