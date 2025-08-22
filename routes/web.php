<?php

use App\Http\Controllers;
use App\Mail\ManeuverAdminNotification;
use App\Models\Maneuver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::get('/test-email', function () {
    $maneuver = Maneuver::find(1); // Replace with a valid maneuver ID or create a new one for testing
    try {
       Mail::to("angelgrcroguez@gmail.com")->send(new ManeuverAdminNotification($maneuver));
    return "Email sent successfully!";
    } catch (\Exception $e) {
        return "Failed to send email: " . $e->getMessage();
    } catch (\Error $e) {
        return "An error occurred: " . $e->getMessage();
    }
    
});

Route::get('/test-push', function () {
    $token = "d_Ax7jbOTvmrTl6sZUT0XH:APA91bHI7oXRHdRHR2mfMlyS2SqJRy6DEyHVvQGriulMs4B4w2JDGFKBjRtJG3dKbglPnDRHbIqTJfBopH6K2Ynmi6EgIN_4o1Z0Ud8ZqP3gtpEl6WrkNgQ";
    $data = ["time" => date("YmdHis"), "image" => asset("images/logo_icon.png"), "title" => "Su cuenta ha sido verificada correctamente", "body" => "Hemos aprobado su solicitud para ser un ofertante en Kigadu", "route" => '/']; // Define your notification data here
    sendNotification("Su cuenta ha sido verificada correctamente", "Hemos aprobado su solicitud para ser un ofertante en Kigadu", [$token], $data);
});

Route::get('/',  [Controllers\AuthController::class, 'login'])->name('login');

Route::post('/login-post', [Controllers\AuthController::class, 'loginPost']);

Route::post('/logout', [Controllers\AuthController::class, 'logout'])->middleware(['auth'])->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('administrador')->middleware(['auth', 'check.route.role'])->group(function () {
    Route::resource('/clientes', Controllers\Admin\ClientController::class);
    Route::resource('/maniobras', Controllers\Admin\ManueverController::class);
    Route::resource('/reportes', Controllers\Admin\ConfigurationController::class);
});
// Rutas para ADMIN (prefijo: "admin")
Route::prefix('administrador')->middleware(['auth', 'check.route.role'])->group(function () {
    Route::get('/dashboard', [Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/servicios', Controllers\Admin\ServiceController::class);
    Route::resource('/usuarios', Controllers\Admin\UserController::class);
    Route::resource('/clientes', Controllers\Admin\ClientController::class);
    Route::resource('/configuracion', Controllers\Admin\ConfigurationController::class);
    Route::resource('/maniobras', Controllers\Admin\ManueverController::class);
    Route::resource('/alertas', Controllers\Admin\AlertController::class);
    Route::resource('/reportes', Controllers\Admin\ConfigurationController::class);
});

// Rutas para CLIENTE (prefijo: "cliente")
Route::prefix('cliente')->middleware(['auth', 'check.route.role'])->group(function () {
    Route::get('/dashboard', [Controllers\Client\DashboardController::class, 'index']);
    
    Route::resource('/maniobras', Controllers\Client\ManeuverController::class);
});


// Rutas para CLIENTE (prefijo: "cliente")
Route::prefix('caseta')->group(function () {
    Route::get('/', [Controllers\Toll\HomeController::class, 'index']);
    Route::post('/login', [Controllers\Toll\HomeController::class, 'login']);

    Route::group(['middleware' => ['auth', 'check.route.role']], function () {
        Route::get('/programacion', [Controllers\Toll\ManueverController::class, 'index']);
    });
});

// Rutas para SUPERVISOR (prefijo: "supervisor")
Route::prefix('supervisor')->middleware(['auth', 'check.route.role'])->group(function () {
    
});