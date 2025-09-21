<?php

namespace App\Http\Controllers;

use App\Services\OneSignalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $oneSignalService;

    public function __construct(OneSignalService $oneSignalService)
    {
        $this->oneSignalService = $oneSignalService;
    }

    /**
     * Enviar notificación de prueba
     */
    public function sendTestNotification(Request $request)
    {
        try {
            $title = $request->input('title', 'Notificación de Prueba');
            $message = $request->input('message', 'Esta es una notificación de prueba desde Acoman');
            $url = $request->input('url');

            $this->oneSignalService->sendToAll($title, $message, [], $url);

            return response()->json([
                'success' => true,
                'message' => 'Notificación enviada exitosamente'
            ]);
        } catch (\Exception $e) {
            Log::error('Error enviando notificación de prueba', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error enviando notificación: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar notificación de nueva maniobra
     */
    public function sendManeuverNotification(Request $request)
    {
        $request->validate([
            'maneuver_id' => 'required|integer',
            'client_name' => 'required|string',
            'type' => 'required|string'
        ]);

        try {
            $title = "Nueva Maniobra - {$request->client_name}";
            $message = "Se ha registrado una nueva maniobra de tipo: {$request->type}";
            $data = [
                'maneuver_id' => $request->maneuver_id,
                'type' => 'new_maneuver',
                'url' => url("administrador/maniobras/{$request->maneuver_id}")
            ];

            // Enviar a administradores
            $this->oneSignalService->sendToSegment('admin', $title, $message, $data);

            return response()->json([
                'success' => true,
                'message' => 'Notificación de maniobra enviada'
            ]);
        } catch (\Exception $e) {
            Log::error('Error enviando notificación de maniobra', [
                'error' => $e->getMessage(),
                'maneuver_id' => $request->maneuver_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error enviando notificación'
            ], 500);
        }
    }

    /**
     * Obtener información de la app OneSignal
     */
    public function getAppInfo()
    {
        try {
            $info = $this->oneSignalService->getAppInfo();
            return response()->json(['data' => $info]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error obteniendo información: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar formulario de prueba de notificaciones
     */
    public function testForm()
    {
        return view('admin.notifications.test');
    }
}
