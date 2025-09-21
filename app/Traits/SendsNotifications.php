<?php

namespace App\Traits;

use App\Services\OneSignalService;
use Illuminate\Support\Facades\Log;

trait SendsNotifications
{
    /**
     * Enviar notificación cuando se crea una nueva maniobra
     */
    public function sendManeuverCreatedNotification()
    {
        try {
            $oneSignalService = app(OneSignalService::class);
            
            $clientName = $this->client ? $this->client->name : 'Cliente';
            $serviceName = $this->service ? $this->service->name : 'Servicio';
            
            $title = "Nueva Maniobra - {$clientName}";
            $message = "Se ha registrado una nueva maniobra: {$serviceName}";
            
            $data = [
                'maneuver_id' => $this->id,
                'type' => 'new_maneuver',
                'url' => url("administrador/maniobras/{$this->id}")
            ];
            
            // Enviar a administradores
            $oneSignalService->sendToSegment('admin', $title, $message, $data);
            
            Log::info('Notificación de nueva maniobra enviada', [
                'maneuver_id' => $this->id,
                'client' => $clientName
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error enviando notificación de maniobra', [
                'error' => $e->getMessage(),
                'maneuver_id' => $this->id
            ]);
        }
    }

    /**
     * Enviar notificación cuando cambia el estado de una maniobra
     */
    public function sendManeuverStatusChangedNotification($oldStatus, $newStatus)
    {
        try {
            $oneSignalService = app(OneSignalService::class);
            
            $title = "Estado de Maniobra Actualizado";
            $message = "La maniobra #{$this->id} cambió de '{$oldStatus}' a '{$newStatus}'";
            
            $data = [
                'maneuver_id' => $this->id,
                'type' => 'status_change',
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'url' => url("administrador/maniobras/{$this->id}")
            ];
            
            // Enviar tanto a admins como al cliente específico
            $oneSignalService->sendToSegment('admin', $title, $message, $data);
            
            if ($this->client && $this->client->user) {
                $oneSignalService->sendToUsers(
                    [$this->client->user->id],
                    $title,
                    $message,
                    $data
                );
            }
            
        } catch (\Exception $e) {
            Log::error('Error enviando notificación de cambio de estado', [
                'error' => $e->getMessage(),
                'maneuver_id' => $this->id
            ]);
        }
    }
}
