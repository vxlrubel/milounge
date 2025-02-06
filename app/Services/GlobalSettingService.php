<?php

namespace App\Services;

class GlobalSettingService
{

    public static function get()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/global-setting');
            $data = $response->getBody();
            $data = json_decode($data);

            return $data ?? [];

        } catch (\Exception $exception) {
            return [];
        }
    }

    public static function key($key)
    {
        try {

            $gss = cache('globalSettings') ?? [];
            $branch = BranchService::currentBranch(BranchService::current());
            $branch_id = $branch->id ?? null;

            //return $branch_id;
            $gs = collect($gss)->where('key', $key)->where('branch_id', $branch_id)->first() ?? null;

            return $gs->value ?? null;

        } catch (\Exception $exception) {
            return null;
        }
    }

    public static function all()
    {
        try {

            $gss = cache('globalSettings') ?? [];
            $branch = BranchService::currentBranch(BranchService::current());
            $branch_id = $branch->id ?? null;

            $gss = collect($gss)->where('branch_id', $branch_id)->values() ?? [];
            if (count($gss) > 0) {
                $array = [];
                foreach ($gss as $property) {
                    $array[$property->key] = $property->value;
                }
                return $array;
            }

            return null;

        } catch (\Exception $exception) {
            return null;
        }
    }

}
