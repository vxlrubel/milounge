<?php

namespace App\Services;

class ConsultationService {

    public static function get($category_key) {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        $consultations = [];
        try{
            $response = $client->get($api_url.'/consultation/'.$category_key);
            $consultations = $response->getBody();
            return json_decode($consultations);
        }catch (\Exception $exception){
            return [];
        }
    }

}
