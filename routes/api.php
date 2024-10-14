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

// Limiting request to 60 requests per minute
Route::middleware(['throttle:api'])->group(function () {

    // Testing API
    Route::get('hallo', function () {
        return response()->json("Hello World", 200);
    });

    // Essentials API
    Route::post('register', [UserController::class, 'register']);                             // done
    Route::post('login', [UserController::class, 'login']);                                   // done

    // Grouping inside Sanctum Middleware         
    // User API 
    Route::get('user_is_welcomed_done/{id}', [UserController::class, 'UserIsWelcomedDone']); 
    Route::get('users', [UserController::class, 'getAllUsers']); 
    Route::get('usersNonAccepted', [UserController::class, 'getAllUsersNonAccepted']); 
    Route::get('user', [UserController::class, 'getUser']); 
    Route::get('getAdminIdFromUserId/{idUser}', [UserController::class, 'getAdminIdFromUserId']); 
    Route::get('user/{id}', [UserController::class, 'getUserById']); 
    Route::post('updateUserInfos/{idUser}', [UserController::class, 'updateUser']); 
    Route::patch('user-type', [UserController::class, 'updateUserType']); 
    Route::delete('deleteUserStaffNotAdmin/{id}', [UserController::class, 'deleteUserStaffNotAdmin']); 
    Route::delete('deleteUserWhoIsAdmin/{id}', [UserController::class, 'deleteUserWhoIsAdmin']); 
    Route::post('accept/{id}', [UserController::class, 'accepterUser']); 
    Route::post('refuse/{id}', [UserController::class, 'refuserUser']); 
    Route::get('updateUserRestriction/{id}/{access}', [UserController::class, 'updateUserRestriction']); 
    Route::post('updatePassword/{id}', [UserController::class, 'updatePassword']); 
    
    // Admin API 
    Route::get('admin', [AdminController::class, 'getAdmin']); 
    Route::patch('admin', [AdminController::class, 'updateAdmin']); 
    Route::delete('admin', [AdminController::class, 'deleteAdmin']); 
    Route::get('admin/{idAdmin}', [AdminController::class, 'createAdmin']); 

    // Staff API 
    Route::post('staff', [StaffController::class, 'createStaff']); 
    Route::delete('staff/{id}', [StaffController::class, 'deleteStaff']); 
    Route::patch('staff/{id}/{type}', [StaffController::class, 'updateTypeStaff']); 
    Route::get('staffs/{adminId}', [StaffController::class, 'getAllStaffs']); 

    // Farms API 
    Route::post('farms', [FarmController::class, 'createFarm']); 
    Route::get('farms/{id}', [FarmController::class, 'getAllFarmsPerAdmin']); 
    Route::patch('farms/{id}', [FarmController::class, 'updateFarm']); 
    Route::delete('farms/{id}', [FarmController::class, 'deleteFarm']); 
    Route::get('farms/getSingleFarm/{id}', [FarmController::class, 'getSingleFarm']);  
    Route::get('getFarmsWithGreenhouses/{id}', [FarmController::class, 'getFarmsWithGreenhouses']);  

    // Serre API 
    Route::post('serres', [SerreController::class, 'createSerre']); 
    Route::get('serres-per-farm/{farmId}', [SerreController::class, 'getAllSerresPerFarm']); 
    Route::patch('serres/{id}', [SerreController::class, 'updateSerre']); 
    Route::delete('serres/{id}', [SerreController::class, 'deleteSerre']); 

    // Prediction API 
    Route::post('create_prediction', [PredictionController::class, 'createPrediction']);  // pending...
    Route::get('predictions', [PredictionController::class, 'getAllPredictions']); 
    Route::get('singlePrediction/{predId}', [PredictionController::class, 'getSinglePredictions']); 
    Route::get('users/{userId}/predictions', [PredictionController::class, 'getUserPredictions']); 
    Route::patch('predictions/{id}', [PredictionController::class, 'updatePrediction']); 
    Route::delete('predictions/{id}', [PredictionController::class, 'deletePrediction']);

    // Image API
    Route::post('images', [ImageController::class, 'createImage']);
    Route::get('predictions/{predictionId}/images', [ImageController::class, 'getPredictionImages']);
    Route::patch('images/{id}', [ImageController::class, 'updateImage']);
    Route::delete('images/{id}', [ImageController::class, 'deleteImage']); 

});
