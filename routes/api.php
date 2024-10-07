<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\SerreController;
use App\Http\Controllers\StaffController;



// limitting request to 60 per 1 minute
Route::middleware(['throttle:40,1'])->group(function () {


    // testing API 
    Route::get('hallo', function () {
        return response()->json("Hello World", 201);
    });


    //Essentials API 
    Route::post('register', [UserController::class, 'register']); 
    Route::post('login', [UserController::class, 'login']);
    Route::get('users', [UserController::class, 'getAllUsers']); 


    // Grouping inside Sanctum Middleware
    Route::middleware('auth:sanctum')->group(function () {
        
        // User API 
        Route::get('user', [UserController::class, 'getUser']); 
        Route::patch('user', [UserController::class, 'updateUser']); 
        Route::patch('user-type', [UserController::class, 'updateUserType']); 
        Route::delete('user', [UserController::class, 'deleteUser']); 

        // Admin API 
        Route::middleware('checkRole:admin')->group(function () {
            Route::get('admin', [AdminController::class, 'getAdmin']); 
            Route::patch('admin', [AdminController::class, 'updateAdmin']); 
            Route::delete('admin', [AdminController::class, 'deleteAdmin']); 
        });

        // Staff API 
        Route::middleware('checkRole:staff')->group(function () {
            Route::post('staff', [StaffController::class, 'createStaff']); 
            Route::delete('staff/{id}', [StaffController::class, 'deleteStaff']); 
            Route::patch('staff/{id}/{type}', [StaffController::class, 'updateTypeStaff']); 
            Route::get('staff/all', [StaffController::class, 'getAllStaffs']); 
        });

        // Farms API 
        Route::post('farms', [FarmController::class, 'createFarm']); 
        Route::get('farms', [FarmController::class, 'getAllFarmsPerAdmin']); 
        Route::patch('farms/{id}', [FarmController::class, 'updateFarm']); 
        Route::delete('farms/{id}', [FarmController::class, 'deleteFarm']); 

        // Serre API 
        Route::post('serres', [SerreController::class, 'createSerre']); 
        Route::get('serres-per-farm/{farmId}', [SerreController::class, 'getAllSerresPerFarm']); 
        Route::patch('serres/{id}', [SerreController::class, 'updateSerre']); 
        Route::delete('serres/{id}', [SerreController::class, 'deleteSerre']); 

        // Prediction API 
        Route::post('predictions', [PredictionController::class, 'createPrediction']); 
        Route::get('predictions', [PredictionController::class, 'getAllPredictions']); 
        Route::get('users/{userId}/predictions', [PredictionController::class, 'getUserPredictions']); 
        Route::patch('predictions/{id}', [PredictionController::class, 'updatePrediction']); 
        Route::delete('predictions/{id}', [PredictionController::class, 'deletePrediction']);

        // Image API
        Route::post('images', [ImageController::class, 'createImage']);
        Route::get('predictions/{predictionId}/images', [ImageController::class, 'getPredictionImages']);
        Route::patch('images/{id}', [ImageController::class, 'updateImage']);
        Route::delete('images/{id}', [ImageController::class, 'deleteImage']); 
    });

});

