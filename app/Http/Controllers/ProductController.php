<?php

namespace App\Http\Controllers;

use App\Services\ProductRelationPriceService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->q ?? null;
        if (!$q) {
            return back();
        }

        $q = strtolower($q);

        $products = collect(cache('products'))
            ->filter(function ($item) use ($q) {
                return str_contains(strtolower($item->tags), $q);
            });

        return view('product.search', compact('q', 'products'));

    }

    public function show($product_uuid)
    {
        $product = ProductService::show($product_uuid);
        //dd($product);
        $product_encoded = json_encode($product);

        $product_relation_price = ProductRelationPriceService::get($product_uuid);
        $product_relation_price_encoded = json_encode($product_relation_price);

        // relevant products
        $category_key = $product->categories ?? null;
        $relevant_products = null;
        if ($category_key) {
            $relevant_products = collect(cache('products'))
                ->where('categories', '=', $category_key)
                ->where('uuid', '!=', $product_uuid);
            $relevant_products = json_encode($relevant_products);
        }

        return view('product.show', compact('product_uuid', 'product', 'product_encoded', 'product_relation_price_encoded', 'relevant_products'));
    }
}
