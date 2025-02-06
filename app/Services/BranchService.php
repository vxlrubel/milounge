<?php

namespace App\Services;

class BranchService
{

    public static function current()
    {
        $branches = cache('branches') ?? [];
        if (!count($branches)) return null;

        $first_branch = collect($branches)->first();
        $first_branch = $first_branch->value;
        return session('branch') ?? $first_branch ?? null;
    }

    public static function currentName($value)
    {
        $branches = cache('branches') ?? [];
        if (!count($branches)) return null;

        return collect($branches)->where('value', $value)->first()->name ?? '';
    }

    public static function currentBranch($value)
    {
        $branches = cache('branches') ?? [];
        if (!count($branches)) return null;

        return collect($branches)->where('value', $value)->first() ?? null;
    }

    public static function selected()
    {
        return session('branch');
    }

    public static function first()
    {
        $branches = cache('branches') ?? [];
        if (!count($branches)) return null;

        $first_branch = collect($branches)->first();
        $first_branch = $first_branch->value;
        return $first_branch ?? null;
    }

    public static function getId($value)
    {
        $branches = cache('branches') ?? [];
        if (!count($branches)) return null;

        $branch = collect($branches)->where('value', $value)->first();
        return $branch->id ?? null;
    }

    public static function valid($value)
    {
        $branches = cache('branches') ?? [];
        if (!count($branches)) return null;

        $branch = collect($branches)->where('value', $value)->first();
        return $branch ?? null;
    }

    public static function get()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/branch');
            $branches = $response->getBody();
            $branches = json_decode($branches);

            // keep default branch selected always
            if (count($branches) > 0) {
                session()->put('branch', $branches[0]->value);
            } else {
                session()->forget('branch');
            }

            return $branches;
        } catch (\Exception $exception) {
            return [];
        }
    }

    public static function getCategories()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/branch/categories');
            $categories = $response->getBody();
            return json_decode($categories);
        } catch (\Exception $exception) {
            return [];
        }
    }

    public static function getProducts()
    {
        $api_url = config('api.apiUrl');
        $client = Utils::client();
        try {
            $response = $client->get($api_url . '/branch/products');
            $products = $response->getBody();
            return json_decode($products);
        } catch (\Exception $exception) {
            return [];
        }
    }

}
