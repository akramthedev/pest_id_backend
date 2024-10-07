<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Serre;
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
        ]);

        return response()->json(['message' => 'Serre created successfully', 'serre' => $serre], 201);
    }

    // Get all serres for a specific farm
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
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $serre = Serre::find($id);
        if (!$serre) {
            return response()->json(['message' => 'Serre not found.'], 404);
        }

        $serre->update($request->only(['name', 'size']));

        return response()->json(['message' => 'Serre updated successfully', 'serre' => $serre], 200);
    }

    // Delete a serre
    public function deleteSerre($id)
    {
        $serre = Serre::find($id);
        if (!$serre) {
            return response()->json(['message' => 'Serre not found.'], 404);
        }

        $serre->delete();
        return response()->json(['message' => 'Serre deleted successfully.'], 200);
    }
}



