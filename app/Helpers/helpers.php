<?php
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

function sendNotification($title, $body, $tokens, $notification_data = [])
{
    $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../../config/acoman-805a5-firebase-adminsdk-fbsvc-d318e7f1d4.json');
 
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