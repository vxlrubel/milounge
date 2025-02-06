<?php

namespace App\Services;

class CategoryService
{

    public static function get()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        $categories = [];
        try {
            $response = $client->get($api_url . '/category');
            $categories = $response->getBody();
            return json_decode($categories);
        } catch (\Exception $exception) {
            return [];
        }
    }

    public static function show($key)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/category/' . $key);
            $category = $response->getBody();
            return json_decode($category);
        } catch (\Exception $exception) {
            return [];
        }
    }

}
