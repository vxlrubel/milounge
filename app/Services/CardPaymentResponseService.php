<?php

namespace App\Services;

class CardPaymentResponseService
{

    public static function send($req)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'order_id' => $req['order_id'],
            'body' => $req['body'] ?? null,
        ];
        try {
            $response = $client->post($api_url . '/card-payment-response', [
                'body' => json_encode($body)
            ]);
            return json_decode($response->getBody());
        } catch (\Exception $exception) {
            return 500;
        }
    }

}
