<?php

namespace App\Services;

class FCMNotificationService
{

    public static function send($req){


        $order_id = $req['order_id'];
        $topic_key = $req['topic_key'];

        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'order_id' => $order_id,
            'topic_key' => $topic_key,
        ];

        try {
            $response = $client->post($api_url . '/notification/fcm-new', [
                'body' => json_encode($body)
            ]);

            return $response->getStatusCode();

        } catch (\Exception $exception) {

            ExceptionService::send([
                'file_name' => __FILE__,
                'function_name' => __FUNCTION__,
                'error_message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

}
