@extends('layouts.app')

@section('title') About Us @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/erectileDysfunction.css"/>
    <link rel="stylesheet" href="/assets/css/mediaqueryerectile.css"/>
    <link rel="stylesheet" href="/assets/css/about.css"/>
@endpush
@section('content')
    <!--About Us Section Start-->
    <section class="about-us-section">
    <div class="container-fluid">
                <div class="row align-items-center">
            <div class="col-md-6">
                <div class="container">
                    <div class="aboutus-all-content">
                        <div class="about-us-content">
                            <h1>About Us</h1>
                        </div>
                        <div class="about-all-details">
                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ullam possimus doloribus omnis voluptatum! Quisquam molestias consequatur accusantium beatae officiis laborum quas explicabo assumenda sunt, autem minus, obcaecati, rem quos. Voluptates?</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="aboutus-image">
                    <img src="/assets/images/about-page-image.jpg" alt="">
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
