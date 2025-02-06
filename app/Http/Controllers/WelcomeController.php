<?php

namespace App\Http\Controllers;

use App\Services\BranchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index($branch = null)
    {
        if ($branch) {
            $branches = cache('branches') ?? [];
            if (!collect($branches)->where('value', $branch)->first()) {
                return redirect('/home')->with('error', 'Unknown Branch...!');
            }

            return redirect('/' . $branch . '/home');

        }

        $discount_products = collect(cache('products'))->where('type', '=', 'DISCOUNT')->values() ?? [];

        return redirect('/home')->with('discount_products', $discount_products);
    }

    public function home()
    {
        $branch = BranchService::selected();
        if ($branch) {
            return redirect('/' . $branch . '/home');
        }

        $branch_value = BranchService::first();
        $branch_id = BranchService::getId($branch_value);

        $products = cache('products');
        $products = collect($products)->where('branch_id', $branch_id)->values();

        $featured_products = collect($products)->filter(function ($product) {
            return isset($product->property->featured) && $product->property->featured == "1";
        });

        $discount_products = collect(cache('products'))->where('type', '=', 'DISCOUNT')->where('property.is_coupon', '=', 'FALSE')->values() ?? [];

        return view('welcome', compact('featured_products', 'discount_products'));
    }

    public function indexBranch($branch)
    {
        if(!BranchService::valid($branch)) {
            session()->forget('branch');
            return redirect('/home')->with('error', 'Unknown Branch...!');
        }

        session()->put('branch', $branch);
        session()->save();

        $branch_id = BranchService::getId($branch);

        $products = cache('products');
        $products = collect($products)->where('branch_id',$branch_id)->values();

        $featured_products = collect($products)->filter(function ($product) {
            return isset($product->property->featured) && $product->property->featured == "1";
        });

        $discount_products = collect(cache('products'))->where('type', '=', 'DISCOUNT')->where('property.is_coupon', '=', 'FALSE')->values() ?? [];

        return view('welcome', compact('featured_products', 'discount_products'));
    }
}
