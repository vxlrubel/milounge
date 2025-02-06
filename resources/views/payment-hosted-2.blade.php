@extends('layouts.app')

@section('title') Checkout @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/checkoutprogressbar.css"/>
    <link rel="stylesheet" href="/assets/css/checkout.css"/>
    <link rel="stylesheet" href="/assets/css/payment.css"/>

    <script src="https://gateway.cardstream.com/sdk/web/v1/js/hostedforms.min.js"></script>
@endpush
@section('content')

    @php
        $_token = csrf_token();

        $user_id = session('user')->id ?? null;
        $guest_id = session('guest')->id ?? null;

        $orderId = session('order_id') ?? null;
        $orderUserRole = session('user') ? 'CONSUMER' : 'GUEST';
        $orderUserId = $user_id ?? $guest_id;

        $amount = number_format(session('order')->payable_amount ?? 0, 2);
        $amount = $amount * 100;
        $transactionUnique = uniqid();
        $tran = array (
             'merchantID' => config('services.stream.merchant_id'),
             'action' => 'SALE',
             'type' => '1',
             'currencyCode' => '826',
             'countryCode' => '826',
             'amount' => $amount,
             'orderRef' => $orderId,
             'orderUserRole' => $orderUserRole,
             'orderUserId' => $orderUserId,
             'redirectURL' => config('app.url').'/payment/cardstream-hosted'
        );

        $signature = \App\Services\Stream::createSignature($tran, config('services.stream.key'))

    @endphp

    <section class="payment-section">
        <div class="container">
            @if($amount > 0)
                <div class="payment-all-content">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="payment-image">
                                <img src="/assets/images/payment.svg" alt="">
                            </div>
                        </div>

                        <div class="col-md-6 m-auto mt-5">
                            <div class="row mobile-col-reverse justify-content-center">
                                <div class="col-md-12 col-lg-10">
                                    <div class="payment-content">
                                        <div class="payment-details">
                                            <div class="payment-amount">
                                                <h3>Payment Amount</h3>
                                                <p>{{config('app.currency')}}{{ number_format(session('order')->payable_amount ?? 0, 2) }}</p>
                                            </div>
                                            <div class="payment-card-details text-center">

                                                <div id="paynow"></div>

                                            </div>
                                            <div class="payment-cardimage text-center">
                                                <img src="/assets/images/payment-logo/evo-secure.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <div class="payment-all-content text-center mt-5">
                    <img src="/assets/images/empty-cart.png" class="mb-4" alt="">

                    <p class="text-center">Your cart is empty!
                        <a href="/"><u>Start shopping</u></a>
                    </p>
                </div>
            @endif

        </div>
    </section>
    <!-- Checkout All Content Section End  -->
@endsection

@push('script')

    <script>
        // Create a new Hosted Form object which will render a payment button which will load
        // the Hosted Payment Pageo load into a modal overlay over this page.

        // The request can be provided from your server.
        var req = {
            merchantID: '{{config('services.stream.merchant_id')}}',
            action: 'SALE',
            type: '1',
            currencyCode: '826',
            countryCode: '826',
            amount: '{{$amount}}',
            orderRef: '{{$orderId}}',
            orderUserRole: '{{$orderUserRole}}',
            orderUserId: '{{$orderUserId}}',
            redirectURL: '{{config('app.url')}}/payment/cardstream-hosted',
            signature: '{{$signature}}',
        };

        var data = {
            id: 'my-payment-form',
            url: 'https://gateway.cardstream.com/hosted/modal/',
            modal: true,
            data: req,
            submit: {
                type: 'button',
                label: 'Pay <i>Now</i>'
            }
        };

        var form = new window.hostedForms.classes.Form('paynow', data);

        console.log(form);

    </script>

    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {}
            },
            async created() {

            },
            methods: {},
            watch: {},
            computed: {}
        }).mount('#app')

    </script>
@endpush
