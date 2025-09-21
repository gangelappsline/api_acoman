<?php

namespace App\Services;

use Berkayk\OneSignal\OneSignalClient;
use Illuminate\Support\Facades\Log;

class OneSignalService
{
    protected $client;

    public function __construct()
    {
        $this->client = new OneSignalClient(
            config('onesignal.app_id'),
            config('onesignal.rest_api_key'),
            config('onesignal.user_auth_key')
        );
    }

    /**
     * Enviar notificación a todos los usuarios
     */
    public function sendToAll($title, $message, $data = [], $url = null)
    {
        try {
            $this->client->sendNotificationToAll(
                $message,
                $url,
                $data,
                $buttons = null,
                $schedule = null,
                [$title]
            );

            Log::info('OneSignal notification sent to all users', [
                'title' => $title,
                'message' => $message
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error sending OneSignal notification to all users', [
                'error' => $e->getMessage(),
                'title' => $title,
                'message' => $message
            ]);
            throw $e;
        }
    }

    /**
     * Enviar notificación a usuarios específicos por sus IDs
     */
    public function sendToUsers(array $userIds, $title, $message, $data = [], $url = null)
    {
        try {
            $this->client->sendNotificationToUser(
                $message,
                $userIds,
                $url,
                $data,
                $buttons = null,
                $schedule = null,
                [$title]
            );

            Log::info('OneSignal notification sent to specific users', [
                'user_ids' => $userIds,
                'title' => $title
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error sending OneSignal notification to users', [
                'error' => $e->getMessage(),
                'user_ids' => $userIds,
                'title' => $title,
                'message' => $message
            ]);
            throw $e;
        }
    }

    /**
     * Enviar notificación por tags/segmentos
     */
    public function sendToSegment($segment, $title, $message, $data = [], $url = null)
    {
        try {
            $this->client->sendNotificationUsingTags(
                $message,
                [
                    [
                        "field" => "tag",
                        "key" => "segment",
                        "relation" => "=",
                        "value" => $segment
                    ]
                ],
                $url,
                $data,
                $buttons = null,
                $schedule = null,
                [$title]
            );

            Log::info('OneSignal notification sent to segment', [
                'segment' => $segment,
                'title' => $title
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error sending OneSignal notification to segment', [
                'error' => $e->getMessage(),
                'segment' => $segment,
                'title' => $title,
                'message' => $message
            ]);
            throw $e;
        }
    }

    /**
     * Enviar notificación personalizada con más opciones
     */
    public function sendCustomNotification(array $options)
    {
        try {
            $this->client->sendNotificationCustom($options);
            
            Log::info('OneSignal custom notification sent', ['options' => $options]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error sending OneSignal custom notification', [
                'error' => $e->getMessage(),
                'options' => $options
            ]);
            throw $e;
        }
    }

    /**
     * Obtener información de la aplicación
     */
    public function getAppInfo()
    {
        try {
            return $this->client->getApp();
        } catch (\Exception $e) {
            Log::error('Error getting OneSignal app info', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
