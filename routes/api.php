<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:api');



Route::prefix('/v1')->group(function () {
  Route::post("/test-upload", function (Request $request) {
    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $type = $file->getClientOriginalName();
      // Define the path where you want to store the file
      // Ensure the directory exists or create it
      if (!Storage::disk('public')->exists('tests')) {
        Storage::disk('public')->makeDirectory('tests');
      }
      $path = "tests";
      Storage::disk('public')->putFileAs($path, $file, $type . "." . $file->getClientOriginalExtension());
      return response()->json(['path' => $path], 200);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
  });
  Route::post('login', [Controllers\API\V1\AuthenticationController::class, 'login'])->name('login');

  Route::middleware('auth:api')->group(function () {
    Route::get('/me', [Controllers\API\V1\AuthenticationController::class, 'me']);
    Route::get('/user', [Controllers\API\V1\AuthenticationController::class, 'show']);
    Route::post('/me', [Controllers\API\V1\AuthenticationController::class, 'update']);
    Route::post('/logout', [Controllers\API\V1\AuthenticationController::class, 'logout']);

    Route::resource('/maneuvers', Controllers\API\V1\ManeuverController::class);
    Route::resource('/maneuvers/{id}/files', Controllers\API\V1\ManeuverFileController::class);
  });
});

Route::prefix('administrador')->middleware(['auth:api', 'check.route.role'])->group(function () {});
