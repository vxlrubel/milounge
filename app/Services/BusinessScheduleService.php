<?php

namespace App\Services;

class BusinessScheduleService
{

    public static function get()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/business-schedule', [
                'query' => [
                    'day' => strtolower(now()->format('l')),
                ]
            ]);
            $data = $response->getBody();
            $data = json_decode($data);

            return $data ?? [];

        } catch (\Exception $exception) {
            return null;
        }
    }

}
