<?php

use App\Http\Controllers;
use App\Mail\ManeuverAdminNotification;
use App\Mail\NewManeuverNotification;
use App\Models\Maneuver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/notificaciones/test', [Controllers\NotificationController::class, 'testForm'])->name('notifications.test.form');
    Route::post('/notificaciones/test', [Controllers\NotificationController::class, 'sendTestNotification'])->name('notifications.test');
    Route::post('/notificaciones/maniobra', [Controllers\NotificationController::class, 'sendManeuverNotification'])->name('notifications.maneuver');
    Route::get('/notificaciones/info', [Controllers\NotificationController::class, 'getAppInfo'])->name('notifications.info');


Route::get('/test-email', function () {
    $maneuver = Maneuver::find(10); // Replace with a valid maneuver ID or create a new one for testing
    try {
        Mail::to("angelgrcroguez@gmail.com")->send(new NewManeuverNotification($maneuver));
       Mail::to("angelgrcroguez@gmail.com")->send(new ManeuverAdminNotification($maneuver));
    return "Email sent successfully!";
    } catch (\Exception $e) {
        return "Failed to send email: " . $e->getMessage();
    } catch (\Error $e) {
        return "An error occurred: " . $e->getMessage();
    }
    
});

Route::get('/test-push', function () {
    $token = "eYMvfHoN_IIxwyVNqqpZPV:APA91bFi98FuXDQ8rgsXvTmqG5flHKQuuyv5mr8btulNFoG42Ut8uFVAkgQ0CfLZ9ia4fRYH3CsVyfiEgWDVLlTIHun1i2UUVSTRszWWZQpWTeD3VlsqN7o";
    $data = ["time" => date("YmdHis"), "image" => asset("images/logo.png"), "title" => "Acoman - Actualización de Maniobra", "body" => "La maniobra #123 cambio su estado a aceptada", "route" => '/']; // Define your notification data here
    sendNotification("Acoman - Actualización de Maniobra", "La maniobra #123 cambio su estado a aceptada", [$token], $data);
});

Route::get('/onesignal-debug', function () {
    return view('onesignal-debug');
})->name('onesignal.debug');

Route::get('/onesignal-minimal', function () {
    return view('onesignal-minimal');
})->name('onesignal.minimal');

Route::get('/onesignal-test', function () {
    return view('onesignal-test');
})->name('onesignal.test');

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
    
    // Rutas de notificaciones
    
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