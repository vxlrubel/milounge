<?php

namespace App\Services;

use Illuminate\Http\Request;

class ConsumerService
{

    public static function get()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        try {
            $response = $client->get($api_url . '/user');
            $data = $response->getBody();
            return json_decode($data);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public static function update(Request $request)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ];

        try {
            $response = $client->post($api_url . '/user/update', [
                'body' => json_encode($body)
            ]);

            if ($response->getStatusCode()) {
                $data = $response->getBody();
                $data = json_decode($data);
                $user = self::get();
                session()->put('user', $user);
                session()->save();
                return 202;
            }
            return 400;

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

}
