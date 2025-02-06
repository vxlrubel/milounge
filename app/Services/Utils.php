<?php

namespace App\Services;

use GuzzleHttp\Client as Guzzle;

class Utils
{
    public static function client(){
        $options = [
            'content-type' => 'application/json',
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache, no-store, must-revalidate'
        ];

        if (session('api_token')){
            $options['Authorization'] = 'Bearer '. session('api_token');
        }

        return new Guzzle([
            'headers' => $options
        ]);
    }

    public static function clientFile(){
        $options = [
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Content-Type' => 'multipart/form-data'
        ];

        if (session('api_token')){
            $options['Authorization'] = 'Bearer '. session('api_token');
        }

        return new Guzzle([
            'headers' => $options
        ]);
    }

    public static function checkEmail($email)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/consumer/check/email/' . $email);
            $data = $response->getBody();
            return json_decode($data);
        } catch (\Exception $exception) {
            return null;
        }
    }

    public static function getProvider()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/consumer/get-provider');
            $data = $response->getBody();
            return json_decode($data);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
