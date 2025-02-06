@extends('layouts.app')

@section('title')
    Order Confirmation
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/contact.css"/>
@endpush

@section('content')

    <section class="contact-section confirmorder-page-section" style="min-height: 50vh; align-content: center">
        <div class="container">
            <div class="contact-all-content text-center">
                <div class="contact-content mb-lg-5">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6">
                            <div class="confirmorder-page-content">
                                <i class="fa fa-check-circle text-success mb-3" style="font-size: 70px"></i>

                                <h1 class="text-center mb-3">Order Confirmed</h1>

                                <p>{{session('message') ?? 'Order Placed Successfully...'}}</p>

                                <a href="/menu" class="btn mainbtn-primary confirmpage-neworder-btn mt-3">New Order</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Cart All Content Section End  -->
@endsection

@push('script')
    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    message: '{{session('message')}}',
                }
            },
            created() {

                localStorage.removeItem('applied_coupon');

                if(!this.message) {
                    setTimeout(function () {
                        window.location = '/menu';
                    }, 500)
                }
            },
            methods: {},
            computed: {}
        }).mount('#app')

    </script>
@endpush
