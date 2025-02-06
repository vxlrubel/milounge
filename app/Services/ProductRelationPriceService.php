<?php

namespace App\Services;

class ProductRelationPriceService
{

    public static function get($product_uuid)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        try {
            $response = $client->get($api_url . '/products/relation-price/' . $product_uuid);
            $data = $response->getBody();
            return json_decode($data) ?? [];
        } catch (\Exception $exception) {
            return [];
        }
    }

    public static function getForMultipleProducts(array $product_uuids)
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();

        $body = [
            "product_uuids" => $product_uuids
        ];

        try {
            $response = $client->get($api_url . '/products/relation-price/multiple-product', [
                "query" => $body
            ]);
            $data = $response->getBody();
            return json_decode($data) ?? [];
        } catch (\Exception $exception) {
            return [];
        }
    }

}
