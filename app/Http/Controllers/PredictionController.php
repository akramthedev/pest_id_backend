<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prediction;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PredictionController extends Controller
{
    // Create a new prediction
    public function createPrediction(Request $request)
    {
        
         $validatedData = $request->validate([ 
            'image' => 'nullable', 
        ]);
    
       
         $response = $this->uploadImageToExternalAPI($request->image); 
     
         if (!$response || !isset($response['classA'], $response['classB'], $response['classC'])) {
            return response()->json(['message' => 'Image processing failed'], 400);
        }
    
         $prediction = Prediction::create([
            'user_id' => $request->user_id,  
            'serre_id' => $request->serre_id,  
            'farm_id' => $request->farm_id,  
            'plaque_id' =>$request->plaque_id,
            'created_at' => $request->created_at,
            'result' => rand(30, 70) 
        ]);
    
        // Create the image and link to the prediction
        Image::create([
            'prediction_id' => $prediction->id,
            'name' => $request->image, 
            'size' => 666,  
            'class_A' => $response['classA'],  
            'class_B' => $response['classB'],  
            'class_C' => $response['classC'],  
        ]);
    
        // Return success response
        return response()->json(['message' => 'Prediction created successfully', 'prediction' => $prediction], 201);
 

    }
    
    private function uploadImageToExternalAPI($imagePath)
    {
        // Simulated API response for testing
        return [
            'classA' => rand(1, 30),   
            'classB' => rand(1, 30),   
            'classC' => rand(1, 30),   
        ];
    }
    

    public function getAllPredictions()
    {
        $predictions = Prediction::all();
        return response()->json($predictions, 200);
    }

    public function getUserPredictionsWithImages($userId){
        $predictions = Prediction::where('user_id', $userId)
        ->with('images') 
        ->get();        
        
        return response()->json($predictions, 200);
    }

    public function getUserPredictions($userId)
    {
        $predictions = Prediction::where('user_id', $userId)->get();
        return response()->json($predictions, 200);
    }

    public function getSinglePredictions ($predId){
        $prediction = Prediction::where('id', $predId)->get();
        return response()->json($prediction, 200);
    }


    // Update a prediction
    public function updatePrediction(Request $request, $id)
    { 
        $prediction = Prediction::find($id);
        if (!$prediction) {
            return response()->json(['message' => 'Prediction not found.'], 404);
        }

        $prediction->plaque_id = $request->input('plaque_id');
        $prediction->farm_id = $request->input('farm_id');
        $prediction->serre_id = $request->input('serre_id');
        $prediction->created_at = $request->input('created_at');
        $prediction->save();

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



