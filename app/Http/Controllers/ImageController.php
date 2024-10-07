<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{


    public function createImage(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'prediction_id' => 'required|exists:predictions,id',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000', 
            'description' => 'string|nullable',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }


        $imagePath = $request->file('image_path')->store('images', 'public');

        $image = Image::create([
            'prediction_id' => $request->prediction_id,
            'name' => $imagePath,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Image created successfully', 'image' => $image], 201);
    }




    public function getPredictionImages($predictionId)
    {
        $images = Image::where('prediction_id', $predictionId)->get();
        return response()->json($images, 200);
    }





    // Update an image
    public function updateImage(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'string|nullable',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $image = Image::find($id);
        if (!$image) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images', 'public');
            $image->image_path = $imagePath;
        }

        $image->description = $request->description ?? $image->description;
        $image->save();

        return response()->json(['message' => 'Image updated successfully', 'image' => $image], 200);
    }




    // Delete an image
    public function deleteImage($id)
    {
        $image = Image::find($id);
        if (!$image) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        
        $image->delete();
        return response()->json(['message' => 'Image deleted successfully.'], 200);
    }
}
