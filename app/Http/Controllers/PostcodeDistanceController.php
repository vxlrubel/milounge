<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostcodeDistanceController extends Controller
{
    public function calculate(Request $request)
    {
        $origins = $request->origins;
        $destinations = $request->destinations;

        try {
            $latlon_1 = DB::table('postcodelatlng')->where('postcode', $origins)->first();
            $latlon_2 = DB::table('postcodelatlng')->where('postcode', $destinations)->first();

            if($latlon_1 && $latlon_2) {
                $lat_1 = $latlon_1->latitude;
                $lon_1 = $latlon_1->longitude;

                $lat_2 = $latlon_2->latitude;
                $lon_2 = $latlon_2->longitude;

                $distance = self::get_distance(new Request([
                    "lat_1" => $lat_1,
                    "lon_1" => $lon_1,
                    "lat_2" => $lat_2,
                    "lon_2" => $lon_2,
                ]));

                return [
                    'distance' => $distance,
                    'from' => $lon_1.','.$lat_1,
                    'to' => $lon_2.','.$lat_2,
                ];

            }

            return null;
        }catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function get_distance(Request $request)
    {
        $lat_1 = $request->lat_1;
        $lon_1 = $request->lon_1;
        $lat_2 = $request->lat_2;
        $lon_2 = $request->lon_2;

        $api = 'http://'.config('app.db_host_postcode_distance').':5000/route/v1/driving/'.$lon_1.','.$lat_1.';'.$lon_2.','.$lat_2.'?overview=false&alternatives=true&steps=false';
        $client = new Guzzle([
            'headers' => [
                'content-type' => 'application/json',
                'Accept' => 'application/json',
                'Cache-Control' => 'no-cache, no-store, must-revalidate'
            ]
        ]);

        try{
            $res = $client->get($api);
            $res = $res->getBody();
            $data = json_decode($res);
            $data = $data->routes[0]->distance ?? 0;

            return $data; // returning distance in meter

        }catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }

}
