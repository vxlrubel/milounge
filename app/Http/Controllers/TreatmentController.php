<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductRelationPriceService;

class TreatmentController extends Controller
{
    public function show($key)
    {
        $category = CategoryService::show($key) ?? null;

        $product_uuids = [];

        // Products for this category
        $products = collect(cache('products'))->filter(function ($product) use($key) {
            return str_contains($product->categories, $key) && $product->property->active_consultation === "1";
        })->values();

        foreach ($products as $product) {
            $product_uuids[] = $product->uuid;
        }
        $product_encoded = json_encode($products);

        $product_relation_price = ProductRelationPriceService::getForMultipleProducts($product_uuids);
        $product_relation_price_encoded = json_encode($product_relation_price);

        return view('choosetreatment', compact('category', 'product_encoded', 'product_relation_price_encoded'));
    }
}
