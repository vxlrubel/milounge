@extends('layouts.app')

@section('title') Gallery @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/erectileDysfunction.css"/>
    <link rel="stylesheet" href="/assets/css/mediaqueryerectile.css"/>
    <link rel="stylesheet" href="/assets/css/about.css"/>

    <style>
        .yuma-gallery-image img {
            width: 100%;
        }
        .yuma-gallery-image video {
            width: 100%;
        }
    </style>
@endpush
@section('content')
    <!--About Us Section Start-->
    <section class="about-us-section">

        <div class="container-fluid">
            <div class="row mb-3">

                <div class="col-md-6 col-sm-6 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/gourmet.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/sunday.jpg" alt="Images">
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/1.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/2.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/3.jpg" alt="Images">
                        </div>
                    </div>
                </div>

                {{--<div class="col-md-4 col-sm-4">--}}
                {{--<div class="yuma-gallery-item">--}}
                {{--<div class="yuma-gallery-image">--}}
                {{--<img src="/images/baltistan-gallery/4.jpg" alt="Images">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/5.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/6.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/7.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/8.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/9.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/10.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/11.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/12.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/13.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/14.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/15.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/16.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/17.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/18.jpg" alt="Images">
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <img src="/assets/images/gallery/19.jpg" alt="Images">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <video controls>
                                <source src="/assets/videos/balti1.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 mb-3">
                    <div class="yuma-gallery-item">
                        <div class="yuma-gallery-image">
                            <video controls>
                                <source src="/assets/videos/balti2.mp4" type="video/mp4">
                            </video>
                        </div>
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
