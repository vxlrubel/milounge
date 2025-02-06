@extends('layouts.app')

@section('title') Offer @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/erectileDysfunction.css"/>
    <link rel="stylesheet" href="/assets/css/mediaqueryerectile.css"/>
    <link rel="stylesheet" href="/assets/css/about.css"/>
@endpush
@section('content')
    <!--About Us Section Start-->
    <section class="about-us-section">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-6">
                <div class="aboutus-image">
                    <img src="/assets/images/offer/1.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    </section>
    <!--About Us Section End-->
@endsection

@push('script')
    <script>
        const {createApp} = Vue

        var app = createApp({
            data() {
                return {
                    message: 'Hello Vue!',
                }
            }
        }).mount('#app')

    </script>
@endpush
