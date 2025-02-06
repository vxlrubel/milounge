<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Guest;
use App\Services\ConsumerService;
use App\Services\GuestService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        if(config('services.stream.payment_type') === 'HOSTED') {
            return redirect('/payment/hosted');
        }
        return view('payment');
    }

    public function indexHosted()
    {
        if(config('services.stream.payment_type') === 'DIRECT') {
            return redirect('/payment');
        }
        return view('payment-hosted-2');
    }

}
