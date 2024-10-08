<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function createStaff(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'fullName' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'nullable|string|min:4',
            'mobile' => 'nullable|string|max:15',
            'typeEmploiyement' => 'nullable|string',
            'admin_id' => 'required',
            'position'=> 'nullable',
            'typeS' => 'nullable'
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        if ($request->admin_id && !Admin::find($request->admin_id)) {
            return response()->json(['error' => 'Admin not found.'], 404);
        } 
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'mobile' => $request->mobile,
            'type' => $request->typeS,
            'canAccess' => 1, 
            'isEmailVerified' => 1
        ]);
    

        $staff = Staff::create([
            'user_id' => $user->id,
            'admin_id' => $request->admin_id,  
            'type' => $request->typeEmploiyement,
            'position' => $request->position
        ]);

        return response()->json(['message' => 'Staff created successfully', 'staff' => $staff], 201);
    }





    public function deleteStaff($id){
        $staff = Staff::where('id', $id)->where('admin_id', auth()->id())->first();

        if (!$staff) {
            return response()->json(['message' => 'Staff not found or you do not have permission to delete this staff member.'], 404);
        }

        $staff->delete();

        $user = User::where('id', $staff->user_id)->first(); 

        if ($user) {
            $user->delete(); 
        }

        return response()->json(['message' => 'Staff member and corresponding user deleted successfully.'], 200);
    }




    
    public function updateTypeStaff($id, $type)
    {
        $staff = Staff::where('id', $id)->where('admin_id', auth()->id())->first();

        if (!$staff) {
            return response()->json(['message' => 'Staff not found or you do not have permission to update this staff member.'], 404);
        }

        $staff->type = $type; 
        $staff->save(); 

        return response()->json(['message' => 'Staff member type updated successfully.', 'staff' => $staff], 200);
    }



    public function getAllStaffs($adminId)
    {
        $staffs = Staff::where('admin_id', $adminId)->get();
        return response()->json($staffs, 200);
    }

}



