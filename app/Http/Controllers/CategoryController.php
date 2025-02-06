<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function show($key)
    {
        $category = CategoryService::show($key) ?? null;

        // Products for this category
        $products = collect(cache('products'))->filter(function ($product) use($key) {
            //return str_contains($product->categories, $key);
            return $product->categories === $key;
        })->toArray();

        //dd($products);
        return view('category.show', compact('category', 'products'));
    }
}
