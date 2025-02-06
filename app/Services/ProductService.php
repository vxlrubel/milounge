<?php

namespace App\Services;

class ProductService
{

    public static function get($requests = [])
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $show_hierarchy = $requests['show_hierarchy'] ?? null;
        $sort = $requests['sort'] ?? 'asc';
        $type = $requests['type'] ?? null;
        $promotion = $requests['promotion'] ?? null;
        $category = $requests['category'] ?? null;

        $query_parameters = [];
        $query_parameters['sort'] = $sort;

        if ($show_hierarchy)
            $query_parameters['show_hierarchy'] = 'true';

        if ($promotion)
            $query_parameters['promotion'] = 'true';

        if ($type)
            $query_parameters['type'] = $type;

        if ($category)
            $query_parameters['category'] = $category;

        //$query_parameters['platform'] = 'WEB';

        $query_string_parameter = http_build_query($query_parameters);

        try {
            $response = $client->get($api_url . '/products?' . $query_string_parameter);
            $products = $response->getBody();
            return json_decode($products) ?? [];
        } catch (\Exception $exception) {
            return [];
        }
    }

    public static function show($uuid)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/products/' . $uuid);
            $data = $response->getBody();
            return json_decode($data);
        } catch (\Exception $exception) {
            return [];
        }
    }

}
