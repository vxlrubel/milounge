<?php

namespace App\Services;

class ExceptionService
{

    public static function send($req)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'file_name' => $req['file_name'],
            'function_name' => $req['function_name'],
            'error_message' => $req['error_message'],
            'info' => $req['info'] ?? null,
        ];
        try {
            $response = $client->post($api_url . '/exception', [
                'body' => json_encode($body)
            ]);
            return json_decode($response->getBody());
        } catch (\Exception $exception) {
            return 500;
        }
    }

}
