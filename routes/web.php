<?php

use App\Http\Controllers;
use App\Mail\ManeuverAdminNotification;
use App\Mail\NewManeuverNotification;
use App\Models\Maneuver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Models\ManeuverPayment;
use App\Mail\YesterdayCashReportMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/test-maneuver', function(){
    $payments =  ManeuverPayment::all();
        foreach ($payments as $m) {
            echo "Payment ID: " . $m->id . " - Maneuver ID: " . $m->maneuver->id . " - Client ID: " . ($m->maneuver->client ? $m->maneuver->client->name : 'N/A') . "<br>";
        }
});

Route::get('/notificaciones/test', [Controllers\NotificationController::class, 'testForm'])->name('notifications.test.form');
    Route::post('/notificaciones/test', [Controllers\NotificationController::class, 'sendTestNotification'])->name('notifications.test');
    Route::post('/notificaciones/maniobra', [Controllers\NotificationController::class, 'sendManeuverNotification'])->name('notifications.maneuver');
    Route::get('/notificaciones/info', [Controllers\NotificationController::class, 'getAppInfo'])->name('notifications.info');

Route::get('/generate-yesterday-cash-report', function(){
    // Lógica para generar el reporte de ayer
    try {
            // Calcular fecha de ayer
            $yesterday = Carbon::yesterday();
            
            // Obtener pagos en efectivo de ayer, si el dia es lunes debe tomar viernes, sabado y domingo
            if($yesterday->isMonday()){
                $payments = ManeuverPayment::where('payment_method', 'efectivo')
                    ->whereDate('created_at', '>=', $yesterday->subDays(3))
                    ->whereDate('created_at', '<=', $yesterday)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $payments = ManeuverPayment::where('payment_method', 'efectivo')
                    ->whereDate('created_at', $yesterday)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }

            // Calcular totales
            $totalAmount = $payments->sum('amount');
            $cashAmount = $payments->where('payment_method', 'efectivo')->sum('amount');

            // Datos para la vista
            $data = [
                'payments' => $payments,
                'date' => $yesterday,
                'totalAmount' => $totalAmount,
                'cashAmount' => $cashAmount,
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reports.yesterday_cash_report', $data);
            $pdf->setPaper('a4', 'portrait');

            // Nombre del archivo
            $fileName = 'reports/cash_report_' . $yesterday->format('Y-m-d') . '.pdf';
            
            // Guardar en storage público
            $filePath = 'reports/' . $yesterday->format('Y-m-d') . '_cash_report.pdf';
            Storage::disk('public')->put($filePath, $pdf->output());

            // Obtener usuarios que deben recibir el reporte (administradores y contadores)
            $recipients = User::whereIn('role', ['administrador'])
                ->whereNotNull('email')
                ->get();

            // Enviar correo a cada destinatario
            $emailsSent = 0;
            Mail::to('angelgrcroguez@gmail.com')->send(new YesterdayCashReportMail(
                        $yesterday, 
                        $filePath, 
                        $payments->count(), 
                        $totalAmount
                    ));
            /*foreach ($recipients as $recipient) {
                try {
                    Mail::to($recipient->email)->send(new YesterdayCashReportMail(
                        $yesterday, 
                        $filePath, 
                        $payments->count(), 
                        $totalAmount
                    ));
                    $emailsSent++;
                } catch (\Exception $e) {
                    Log::error('Error enviando reporte a ' . $recipient->email . ': ' . $e->getMessage());
                }
            }

            return $this->sendResponse([
                'report_date' => $yesterday->format('Y-m-d'),
                'total_payments' => $payments->count(),
                'total_amount' => $totalAmount,
                'file_path' => $filePath,
                'emails_sent' => $emailsSent,
                'recipients_count' => $recipients->count()
            ], 'Reporte generado y enviado exitosamente.');*/

        } catch (\Exception $e) {
            Log::error('Error generando reporte de efectivo: ' . $e->getMessage());
            return $e->getMessage();
        }
});

Route::get('/generate-monthly-report', function () {
    //Obtene todas las maniobras del mes actual y haz un reporte en pdf donde muestre una tabla por tipo de servicio, al final muestra el total general del mes.
    $currentMonth = now()->month;
    $maneuvers = Maneuver::whereMonth('created_at', $currentMonth)->get();

    $pdf = Pdf::loadView('reports.monthly_report', ['maneuvers' => $maneuvers,'month' => $currentMonth]);
    return $pdf->download('monthly_report.pdf');
});

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