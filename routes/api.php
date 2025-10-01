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
    Route::post('/firebase-register', [Controllers\API\V1\AuthenticationController::class, 'firebaseRegister']);

    Route::resource('/users', Controllers\API\V1\Admin\UserController::class);

    Route::resource('/maneuvers', Controllers\API\V1\ManeuverController::class);
    Route::resource('/maneuvers/{id}/files', Controllers\API\V1\ManeuverFileController::class);
  });

  Route::prefix('administrador')->middleware(['auth:api', 'check.route.role'])->group(function () {
    Route::resource('/maniobras', Controllers\API\V1\Admin\ManueverController::class);
    Route::resource('/usuarios', Controllers\API\V1\Admin\UserController::class);
    Route::resource('/clientes', Controllers\API\V1\Admin\ClientController::class);
    Route::resource('/dashboard', Controllers\API\V1\Admin\DashboardController::class);
    Route::resource('/reportes', Controllers\API\V1\Admin\ReportController::class);
    Route::resource('/companias', Controllers\API\V1\Admin\CompanyController::class);
  });

  Route::prefix('cliente')->middleware(['auth:api', 'check.route.role'])->group(function () {
    Route::resource('/maniobras', Controllers\API\V1\Client\ManeuverController::class);
    Route::resource('/maniobras/{id}/payments', Controllers\API\V1\Client\ManeuverPaymentController::class)->only(['index', 'store']);
  });

  Route::prefix('caseta')->middleware(['auth:api', 'check.route.role'])->group(function () {
    Route::resource('/maniobras', Controllers\API\V1\Toll\ManeuverController::class);
    Route::resource('/maniobras/{id}/archivos', Controllers\API\V1\Toll\ManeuverFileController::class)->only(['index', 'store']);
    Route::resource('/maniobras/{id}/pagos', Controllers\API\V1\Toll\ManeuverPaymentController::class)->only(['index', 'store']);
  });

  Route::prefix('supervisor')->middleware(['auth:api', 'check.route.role'])->group(function () {});

  Route::prefix('recepcionista')->middleware(['auth:api', 'check.route.role'])->group(function () {
    Route::resource('/maniobras', Controllers\API\V1\Receptionist\ManeuverController::class);
    Route::resource('/clientes', Controllers\API\V1\Receptionist\ClientController::class);
    Route::resource('/dashboard', Controllers\API\V1\Receptionist\DashboardController::class);
    Route::resource('/reportes', Controllers\API\V1\Receptionist\ReportController::class);
  });

  Route::prefix('contador')->middleware(['auth:api', 'check.route.role'])->group(function () {
    Route::resource('/maniobras', Controllers\API\V1\Counter\ManueverController::class);
    Route::resource('/maniobras/{id}/pagos', Controllers\API\V1\Counter\ManueverPaymentController::class)->only(['index', 'store']);
    Route::resource('/reportes', Controllers\API\V1\Counter\ReportController::class);
    Route::resource('/clientes', Controllers\API\V1\Counter\ClientController::class);
    Route::resource('/dashboard', Controllers\API\V1\Counter\DashboardController::class);
    
  });
});
