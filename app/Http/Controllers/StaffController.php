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
 

        if ($request->admin_id && !Admin::find($request->admin_id)) {
            return response()->json(['error' => 'Admin not found.'], 404);
        } 
        $user = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'mobile' => $request->mobile,
            'image' => "https://github.com/akramthedev/pest_id_frontend/blob/master/images/avatar.png?raw=trueimageJOZNJORSFDOJFSWNVDO",
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



