<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Serre;
use App\Models\Prediction;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SerreController extends Controller
{
    // Create a new serre
    public function createSerre(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'farm_id' => 'required|exists:farms,id',
            'name' => 'required|string|max:255',
            'size' => 'required|numeric',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $serre = Serre::create([
            'farm_id' => $request->farm_id,
            'name' => $request->name,
            'size' => $request->size,
            "type" => $request->type
        ]);

        return response()->json(['message' => 'Serre created successfully', 'serre' => $serre], 201);
    }

     public function getAllSerresPerFarm($farmId)
    {
        $serres = Serre::where('farm_id', $farmId)->get();
        return response()->json($serres, 200);
    }

    // Update a serre
    public function updateSerre(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'size' => 'numeric',
            'type' => 'string'
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $serre = Serre::find($id);
        if (!$serre) {
            return response()->json(['message' => 'Serre not found.'], 404);
        }

        $serre->update($request->only(['name', 'size', 'type']));

        return response()->json(['message' => 'Serre updated successfully', 'serre' => $serre], 200);
    }

    
    



    public function deleteSerre($id)
    {
        // Find the serre by ID
        $serre = Serre::find($id);
        
        // Check if serre exists
        if (!$serre) {
            return response()->json(['message' => 'Serre not found.'], 404);
        }

        // Get all related predictions
        $predictions = $serre->predictions;

        // Delete images for each prediction
        foreach ($predictions as $prediction) {
            // Delete images associated with the prediction
            $prediction->images()->delete();
        }

        // Now delete all related predictions
        $serre->predictions()->delete();

        // Finally, delete the serre
        $serre->delete();

        // Return success message
        return response()->json(['message' => 'Serre, predictions, and related images deleted successfully.'], 200);
    }




}



