<?php

namespace App\Http\Controllers;

use App\Services\BranchService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // if branch selected in the dropdown
        $branch_session = BranchService::selected();
        if ($branch_session) {
            return redirect('/' . $branch_session . '/menu');
        }

        $branch_value = BranchService::first();
        $branch_id = BranchService::getId($branch_value);

        $categories = cache('categories') ?? [];
        $products = cache('products') ?? [];

        $categories = collect($categories)->where('branch_id', $branch_id)->values();
        $products = collect($products)->where('type', '=', 'ITEM')->where('branch_id', $branch_id)->values();
        $discount_products = collect(cache('products'))->where('type', '=', 'DISCOUNT')->values() ?? [];

        return view('menu1', compact('categories', 'products', 'discount_products'));
    }

    public function indexBranch($branch)
    {

        if (!BranchService::valid($branch)) {
            return redirect('/home')->with('error', 'Unknown Branch...!');
        }

        session()->put('branch', $branch);
        session()->save();

        $branch_id = BranchService::getId($branch);

        $categories = cache('categories') ?? [];
        $products = cache('products') ?? [];

        $categories = collect($categories)->where('branch_id', $branch_id)->values();
        $products = collect($products)->where('type', '=', 'ITEM')->where('branch_id', $branch_id)->values();
        $discount_products = collect(cache('products'))->where('type', '=', 'DISCOUNT')->values() ?? [];

        return view('menu1', compact('categories', 'products', 'discount_products'));
    }
}
