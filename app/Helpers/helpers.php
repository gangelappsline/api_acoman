<?php
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

function sendNotification($title, $body, $tokens, $notification_data = [])
{
    $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../../config/acoman-805a5-firebase-adminsdk-fbsvc-6cd09c3d97.json');
 
        $messaging = $firebase->createMessaging();


        foreach($tokens as $token){
            $message = CloudMessage::fromArray([
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body
                ],
                'data'=>$notification_data
                //'topic' => 'global'
            ]);
     
            $messaging->send($message);
        }
}