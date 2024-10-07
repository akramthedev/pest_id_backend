<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PredictionController extends Controller
{
    // Create a new prediction
    public function createPrediction(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'description' => 'string',
        ]);

        $imagePath = $request->file('image')->store('images');
        $response = $this->uploadImageToExternalAPI($imagePath); 

        if (!$response || !isset($response['classA'], $response['classB'], $response['classC'])) {
            return response()->json(['message' => 'Image processing failed'], 400);
        }

        $prediction = Prediction::create([
            'user_id' => auth()->id(),  
            'serre_id' => $request->serre_id,  
            'farm_id' => $request->farm_id,  
            'classA' => $response['classA'],
            'classB' => $response['classB'],
            'classC' => $response['classC'],
        ]);

         
        Image::create([
            'prediction_id' => $prediction->id,
            'path' => $imagePath,  
        ]);

        return response()->json(['message' => 'Prediction created successfully', 'prediction' => $prediction], 201);
    }



    private function uploadImageToExternalAPI($imagePath)
    {
        //external API for image upload
    }

 

    // Get all predictions
    public function getAllPredictions()
    {
        $predictions = Prediction::all();
        return response()->json($predictions, 200);
    }



    // Get predictions for a specific user
    public function getUserPredictions($userId)
    {
        $predictions = Prediction::where('user_id', $userId)->get();
        return response()->json($predictions, 200);
    }




    // Update a prediction
    public function updatePrediction(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'prediction_data' => 'string',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $prediction = Prediction::find($id);
        if (!$prediction) {
            return response()->json(['message' => 'Prediction not found.'], 404);
        }

        $prediction->update($request->only(['prediction_data']));

        return response()->json(['message' => 'Prediction updated successfully', 'prediction' => $prediction], 200);
    }


    

    // Delete a prediction
    public function deletePrediction($id)
    {
        $prediction = Prediction::find($id);
        if (!$prediction) {
            return response()->json(['message' => 'Prediction not found.'], 404);
        }

        $prediction->delete();
        return response()->json(['message' => 'Prediction deleted successfully.'], 200);
    }
}



