<?php

namespace App\Http\Controllers;

use App\Services\ConsultationService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function indexForCategory($category_key)
    {
        if (!$category_key) return back();

        $consultation_list = ConsultationService::get($category_key);
        if (!count($consultation_list)) return redirect('/')->with('error', 'Unknown category!');
        $consultations = collect($consultation_list)->groupBy('group');

        //dd($consultations);
        return view('consultation', compact('consultations', 'consultation_list'));
    }

    public function index(Request $request, $category_key)
    {
        if (!$category_key) return back();

        $product_uuid = $request->product ?? null;
        //$product = ProductService::show($product_uuid);

        $consultations = null;
        $consultation_list = ConsultationService::get($category_key);
        if (count($consultation_list)) {
            $consultations = collect($consultation_list)->groupBy('group');
        }

        //dd($consultations);
        return view('consultation', compact('consultations', 'consultation_list', 'category_key', 'product_uuid'));
    }
}
