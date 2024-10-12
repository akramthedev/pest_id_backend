<?php




namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\Serre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FarmController extends Controller
{


    public function createFarm(Request $request)
    {
        

        $farm = Farm::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'location' => $request->location,
            'size' => $request->size,
        ]);

        return response()->json(['message' => 'Farm created successfully', 'farm' => $farm], 201);
    }



    public function getAllFarmsPerAdmin($id)
    {
        $farms = Farm::where('user_id', $id)->get();
        return response()->json($farms, 200);
    }
    
    public function getSingleFarm($id)
    {
        $SingleFarm = Farm::where('id', $id)->get();
        return response()->json($SingleFarm, 200);
    }

    public function updateFarm(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'location' => 'string|max:255|nullable',
            'size' => 'numeric|nullable',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $farm = Farm::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$farm) {
            return response()->json(['message' => 'Farm not found or you do not have permission to update this farm.'], 404);
        }

        $farm->update($request->only(['name', 'location', 'size']));

        return response()->json(['message' => 'Farm updated successfully', 'farm' => $farm], 200);
    }




    public function deleteFarm($id)
    {
        $farm = Farm::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$farm) {
            return response()->json(['message' => 'Farm not found or you do not have permission to delete this farm.'], 404);
        }

        $farm->delete();
        return response()->json(['message' => 'Farm deleted successfully.'], 200);
    }



    public function getFarmsWithGreenhouses($id)
    {
        $farms = Farm::where('user_id', $id)->get();
        $farms->load('serres');
        return response()->json($farms, 200);
        
    }



}


