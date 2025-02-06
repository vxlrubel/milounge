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
             '_token' => $_token,
             'merchantID' => config('services.stream.merchant_id'),
             'action' => 'SALE',
             'type' => '1',
             'currencyCode' => '826',
             'countryCode' => '826',
             'amount' => $amount,
             'orderRef' => $orderId,
             'orderUserRole' => $orderUserRole,
             'orderUserId' => $orderUserId,
             'transactionUnique' => $transactionUnique,
             'redirectURL' => config('app.url').'/payment/cardstream-hosted'
        );

        $signature = \App\Services\Stream::createSignature($tran, config('services.stream.key'))

    @endphp

    <section class="payment-section">
        <div class="container">
            @if($amount > 0 && $orderId)
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
                                                <form name="payment-form" method="post"
                                                      action="https://gateway.cardstream.com/hosted/"
                                                      data-hostedform-modal>
                                                    <input type="hidden" name="_token" value="{{$_token}}"/>
                                                    <input type="hidden" name="merchantID" value="{{config('services.stream.merchant_id')}}"/>
                                                    <input type="hidden" name="action" value="SALE"/>
                                                    <input type="hidden" name="type" value="1"/>
                                                    <input type="hidden" name="currencyCode" value="826"/>
                                                    <input type="hidden" name="countryCode" value="826"/>
                                                    <input type="hidden" name="amount" value="{{$amount}}"/>
                                                    <input type="hidden" name="orderRef" value="{{$orderId}}"/>
                                                    <input type="hidden" name="orderUserRole" value="{{$orderUserRole}}"/>
                                                    <input type="hidden" name="orderUserId" value="{{$orderUserId}}"/>
                                                    <input type="hidden" name="transactionUnique"
                                                           value="{{$transactionUnique}}"/>
                                                    <input type="hidden" name="redirectURL"
                                                           value="{{config('app.url')}}/payment/cardstream-hosted"/>
                                                    <input type="hidden" name="signature" value="{{$signature}}"/>

                                                    <input type="submit" value="Pay Now" class="btn payment-btn m-3">
                                                </form>

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

                    <div class="col-md-12 text-center">
                        <div class="payment-image">
                            <img src="/assets/images/payment.svg" alt="">
                        </div>
                    </div>

                    <p class="text-center">Order amount is invalid!
                        <a href="/checkout"><u>Go to checkout</u></a>
                    </p>
                </div>
            @endif

        </div>
    </section>
    <!-- Checkout All Content Section End  -->
@endsection

@push('script')

    <script>
        // Create a new Hosted Form object which will cause the above <form> to load into a modal
        // overlay over this page.
        // var form = $(document.forms[0]).hostedForm();

        var form = new window.hostedForms.classes.Form(document.forms[0]);

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
