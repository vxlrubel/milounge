<?php

namespace App\Services;

use Illuminate\Http\Request;

class GuestService
{

    public static function store(Request $request)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        try {
            $response = $client->post($api_url . '/guest', [
                'body' => json_encode($body)
            ]);

            if ($response->getStatusCode()) {
                $data = $response->getBody();
                $data = json_decode($data);

                session()->put('guest', $data);
                session()->save();
                return 201;
            }
            return 400;

        } catch (\Exception $exception) {
            return null;
        }
    }

}
