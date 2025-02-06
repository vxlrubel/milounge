<?php

namespace App\Services;

use Illuminate\Http\Request;

class SendSMSNotification
{
    public function send(Request $request) {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $topic = '/topics/get-sms-info';
        $serverKey = 'AAAAFDnGd2Q:APA91bHlG5oO9rHVi8xVt8z54lKZoo1FemhVjnnP9f1d7zs56aQspTCQdrC5Bx2wpCJDBJzuvXzu07bvjzUOMOG8xTW_qyNeMavAjB35WbdLesBS7tER3TL4_TSv5UOkzj16OtNlcZVA';

        $order_id = $request->order_id ?? null;
        $phone = $request->phone ?? null;
        $name = $request->name ?? '';
        $order_timestamp = $request->order_timestamp ?? '';

        if(!$order_id || !$phone) {
            return false;
        }

        $message = "Hello ".$name.", your order ".$order_id." has been placed to ".config('app.name').". Thanks, YUMA Technology.";

        $data = [
            "to" => $topic,
            "notification" => [
                "body" => "Credential for sending SMS to Customer",
                "title" => "Send SMS"
            ],
            "data" => [
                "order_id" => $order_id,
                "phone" => $phone,
                "message" => $message,
                "order_timestamp" => $order_timestamp
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }

            // Close connection
            curl_close($ch);

            // FCM response
            return $result;

        }catch (\Exception $exception) {
            //Send Email
            APIErrorEmail::send(new Request([
                'api' => $url,
                'body' => "Firebase send notification not working",
                'error_code' => $exception->getCode(),
                'error_message' => $exception->getMessage(),
            ]));
            return null;
        }

    }
}
