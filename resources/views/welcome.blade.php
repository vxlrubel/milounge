@extends('layouts.app')

@section('title') Welcome @endsection

@push('meta')
    <meta property="og:title" content="{{config('app.name')}}"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:description" content="We offer a wide range of products through our web sites."/>
    <meta property="og:type" content="website"/>
    <meta property="article:author" content="Muntasir Hasan"/>
    <meta property="og:url" content="{{config('app.url')}}"/>

    <meta property="og:image" content="{{config('app.url')}}/assets/images/logo.png">

    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
@endpush

@push('style')
    <style>
        .location-modal-header {
            justify-content: center;
            padding: 10px;
        }

        .location-modal-title {
            font-size: 22px;
            text-align: center;
            font-weight: 700;
        }

        .location-modal-body {
            background-image: url('/assets/images/bg-white.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .location-modal-footer {
            padding: 6px 12px;
        }

        .location-body-content {
            padding: 10px 0;
        }

        .location-modal-image img {
            width: 100%;
        }

        .location-modal-image {
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            border-radius: 10px;
            overflow: hidden;
        }

        .location-formlabel {
            color: #181818;
            font-size: 18px;
            font-weight: 600;
        }

        .location-formlabel span {
            color: #ff9900;
            margin-right: 7px;
        }

        .location-form-select {
            border: 1px solid #c5c5c5;
        }

        .starRating-icon {
            /*font-size: 30px;*/
            cursor: pointer;
            color: #b1b1b1;
            margin-right: 5px;
        }

        .starRating-icon:active {
            /*font-size: 30px;*/
            cursor: pointer;
            color: #ff9900;
            margin-right: 5px;
        }

        .client-review-content p{
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .image-border{
            border: 5px dashed #c4284f;
        }
        .bg-theme{
            background-color: hsl(345, 67%, 97%);
        }

    </style>

    <link rel="stylesheet" href="{{asset('/assets/css/mi-style.css')}}">


@endpush

@section('content')
    @php
        $offer = \App\Services\GlobalSettingService::key('offer_advertise_text') ?? null;
        $offer1 = \App\Services\GlobalSettingService::key('offer_advertise_text_1') ?? null;
        $special_offer = \App\Services\GlobalSettingService::key('special_offer') ?? null;
    @endphp
    <section class="clearfix mi-hero-area text-white">
        <div class="mi-hero-overlay">
            <div class="container h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-md-10 col-xl-6">
                        <div class="mi-anim-1">Welcome to</div>
                        <div class="mi-anim-2">Mi-lounge.</div>
                        <div class="mt-3 mb-4 mt-md-4 mb-md-5">
                            <div class="mi-anim-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio excepturi necessitatibus quaerat ipsum voluptates iure! Sunt iure quibusdam itaque consectetur aliquid expedita officiis a quasi!</div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-lg btn-light rounded-1 px-3 mi-anim-4">BARNEA BISTRO</button>
                            <button class="btn btn-lg btn-outline-light rounded-1 px-3 mi-anim-5">BONITO 47</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="clearfix py-4 py-lg-5">
        <div class="container">
            <div class="text-center">
                <h2 class="fs-2">Wembley</h2>
                <p class="m-0">6 Boulevard, Wembley Park, HA9 0HP</p>
            </div>

            <div class="my-4 my-lg-5 d-flex justify-content-center gap-2">
                <button class="btn btn-outline-info rounded-0 btn-sm py-2 px-3 text-uppercase">Menu</button>
                <button class="btn btn-outline-info rounded-0 btn-sm py-2 px-3 text-uppercase">Book a table</button>
                <button class="btn btn-outline-info rounded-0 btn-sm py-2 px-3 text-uppercase">Book an Event</button>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-5 py-5 bg-info">
                    <div style="max-width: 350px" class="mx-auto">
                        <h3 class="fs-4 text-center mb-4">Opening Times</h3>
                        <div class="row" style="--bs-gutter-x: .3rem;">
                            <div class="col-6">
                                <div class="p-2">Monday</div>
                            </div>
                            <div class="col-6">
                                <div class="p-2">
                                    10.00 - 00.00
                                </div>
                            </div>
                        </div>
                        <div class="row" style="--bs-gutter-x: .3rem;">
                            <div class="col-6">
                                <div class="p-2">Tuesday</div>
                            </div>
                            <div class="col-6">
                                <div class="p-2">
                                    10.00 - 00.00
                                </div>
                            </div>
                        </div>
                        <div class="row" style="--bs-gutter-x: .3rem;">
                            <div class="col-6">
                                <div class="p-2 bg-white">Wednesday</div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 bg-white">
                                    10.00 - 00.00
                                </div>
                            </div>
                        </div>
                        <div class="row" style="--bs-gutter-x: .3rem;">
                            <div class="col-6">
                                <div class="p-2">Thursday</div>
                            </div>
                            <div class="col-6">
                                <div class="p-2">
                                    10.00 - 00.00
                                </div>
                            </div>
                        </div>
                        <div class="row" style="--bs-gutter-x: .3rem;">
                            <div class="col-6">
                                <div class="p-2">Friday</div>
                            </div>
                            <div class="col-6">
                                <div class="p-2">
                                    10.00 - 00.00
                                </div>
                            </div>
                        </div>
                        <div class="row" style="--bs-gutter-x: .3rem;">
                            <div class="col-6">
                                <div class="p-2">Saturday</div>
                            </div>
                            <div class="col-6">
                                <div class="p-2">
                                    10.00 - 00.30
                                </div>
                            </div>
                        </div>
                        <div class="row" style="--bs-gutter-x: .3rem;">
                            <div class="col-6">
                                <div class="p-2">Sunday</div>
                            </div>
                            <div class="col-6">
                                <div class="p-2">
                                    10.00 - 00.30
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-7 p-0">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2480.551315248375!2d-0.280808!3d51.558126!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761192a79cf553%3A0xf1ba04fe75ecdf5a!2sHaute%20Dolci!5e0!3m2!1sen!2suk!4v1738824638681!5m2!1sen!2suk" class="iframe-map" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

    <section class="clearfix py-4 py-lg-5 product-slider-area" style="background-color: hsl(190.04deg 89% 95%)">
        <div class="container">
            <div class="owl-carousel product-slide">
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/1.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/2.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/3.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/4.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/5.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/6.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/7.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/8.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/9.webp')}}" alt="">
                    </div>
                </div>
                <div>
                    <div class="product-slider">
                        <img src="{{asset('/assets/mi-img/mi-product/10.webp')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="my-2 border-top border-info"></div>
            <div class="d-flex align-items-center justify-content-center gap-2 ">
                <button class="btn btn-outline-info product-slider-button-prev rounded-1 d-inline-flex justify-content-center align-items-center" style="height: 40px; width:40px;">
                    <i class="fa-solid fa-angle-left"></i>
                </button>
                <button class="btn btn-outline-info product-slider-button-next rounded-1 d-inline-flex justify-content-center align-items-center" style="height: 40px; width:40px;">
                    <i class="fa-solid fa-angle-right"></i>
                </button>
            </div>
        </div>
    </section>


@endsection

@push('script')
    <script>
        $(document).ready(function(){

            const productSlider = ()=>{
                const productCarousel = $('.product-slide');
                productCarousel.owlCarousel({
                    margin: 10,
                    loop: true,
                    dots: false,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    autoplaySpeed: 500,
                    responsive : {
                        0:{
                            items: 2,
                        },
                        576:{
                            items: 3,
                        },
                        768:{
                            items: 4,
                        },
                        992:{
                            items: 5,
                        }
                    }
                });

                $('.product-slider-area').on('click', '.product-slider-button-prev', ()=>{
                    productCarousel.trigger('prev.owl.carousel');
                });

                $('.product-slider-area').on('click', '.product-slider-button-next', ()=>{
                    productCarousel.trigger('next.owl.carousel');
                });
            }

            productSlider();

        });
    </script>

    <script>
        const {
            createApp
        } = Vue

        var app = createApp({
            data() {
                return {
                    api_url: '{{config('api.apiUrl')}}',
                    api_project_url: '{{config('api.apiProjectUrl')}}',
                    headers: {
                        "Authorization": "Bearer {{session('api_token')}}"
                    },

                    cart: JSON.parse(localStorage.getItem('cart')) || [],

                    gs: @json(\App\Services\GlobalSettingService::all()),

                    branches: @json(cache('branches')),
                    branch: '{{session('branch')}}',
                    discount_products: @json($discount_products ?? []),

                    reviews: [],

                    review: {
                        name: '{{session('users')->name ?? null}}',
                        message: '',
                        rate: '',
                    },

                    advertise_splash_screen: false,
                    advertise_splash_screen_expiry_date: '',
                }
            },

            created() {

                const self = this;

                if (self.branches.length > 1) {
                    setTimeout(function () {
                        $("#shopModal").modal('show');
                    }, 500);
                }

                // by default 4 start
                setTimeout(function () {
                    self.startRating(4);
                }, 1000);

                // advertise_splash_screen
                var advertise_splash_screen = self.gs?.advertise_splash_screen ?? 'FALSE';
                var advertise_splash_screen_expiry_date = self.gs?.advertise_splash_screen_expiry_date ?? '';

                if (advertise_splash_screen === 'TRUE') {

                    if(advertise_splash_screen_expiry_date) {
                        /* if advertise date expires */
                        if(moment().format('YYYY-MM-DD') > advertise_splash_screen_expiry_date ) {
                            return false;
                        }
                    }

                    self.advertise_splash_screen = true;

                    self.check_advertise_time();

                    var advertise_shown = localStorage.getItem('advertise_shown');
                    if (!advertise_shown || advertise_shown === '0') {
                        setTimeout(function () {
                            localStorage.setItem('advertise_shown', 1);
                            localStorage.setItem('advertise_expire_time', moment().add(2, 'hours').format('YYYY-MM-DD HH:mm:ss'));
                            $("#splashScreenModal").modal('show');
                        }, 1000);
                    }

                }

                self.getReviews();
            },

            mounted() {
                const self = this;

            },

            methods: {
                floatingButton() {
                    var floatButton = document.getElementById('flotingButtonDiv');
                    var icon = document.getElementById('floatingArrowIcon');
                    if (floatButton.classList.contains("floating-buttonVisible")) {
                        floatButton.classList.remove("floating-buttonVisible");
                        floatButton.classList.add("floating-buttonHidden");
                        icon.innerHTML = '<i class="fa-solid fa-angle-left"></i>';
                    } else {
                        floatButton.classList.remove("floating-buttonHidden");
                        floatButton.classList.add("floating-buttonVisible");
                        icon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                    }
                },
                update_branch_bk: function () {
                    var self = this;
                    if (!self.branch) {
                        return false;
                    }

                    swal({
                        title: "",
                        text: "You are changing shop, Your exiting cart will be empty.",
                        icon: "",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then(async (confirm) => {
                            if (confirm) {

                                localStorage.setItem('cart', JSON.stringify([]));
                                window.location = '/branch/set/' + self.branch;

                            } else {
                                self.branch = '{{\App\Services\BranchService::current()}}';
                            }
                        });
                },
                update_branch: function (branch) {

                    var self = this;
                    if (!branch) {
                        return false;
                    }

                    if(self.cart.length) {
                        swal({
                            title: "",
                            text: "You are changing shop, Your exiting cart will be empty.",
                            icon: "",
                            buttons: true,
                            dangerMode: true,
                        })
                            .then(async (confirm) => {
                                if (confirm) {

                                    localStorage.setItem('cart', JSON.stringify([]));
                                    window.location = '/'+branch +'/menu';

                                }
                            });
                    }else{
                        window.location = '/'+branch +'/menu';

                    }

                },

                showShopModal: function (){
                    const self = this;
                    if(self.branches.length > 1) {
                        $("#shopModal").modal('show');
                    }else{
                        window.location = '/menu'
                    }

                },

                openReviewModal: function () {
                    $("#reviewModal").modal('show');
                },

                startRating: function (number) {
                    const self = this;
                    self.review.rate = number;

                    // clear all the star
                    for (var i = 0; i < 5; i++) {
                        document.getElementById('star' + (i + 1)).style.color = "#b1b1b1";
                    }

                    // paint all the star
                    for (var k = 0; k < number; k++) {
                        document.getElementById('star' + (k + 1)).style.color = "#ff9900";
                    }
                },
                sendReview: function () {
                    const self = this;
                    axios.post(self.api_url + '/review',
                        {
                            name: self.review.name,
                            rate: self.review.rate,
                            message: self.review.message,
                        }
                    )
                        .then(res => {
                            swal("Success!", "Review submitted!", {
                                icon: 'success'
                            });

                            self.review.message = '';

                            window.location.reload()
                        })
                        .catch(err => {
                            console.log(err)
                            swal("Warning!", "Something went wrong!", {
                                icon: 'error'
                            });
                        })
                },

                getReviews: function () {
                    const self = this;
                    self.reviews = [];

                    axios.get(self.api_url + '/review')
                        .then(res => {
                            self.reviews = res.data;

                            setTimeout(function () {
                                self.initReviewCarousel();
                            }, 500)
                        })
                        .catch(err => {
                            console.log(err)
                        })
                },

                check_advertise_time: function () {
                    var now = moment().format('YYYY-MM-DD HH:mm:ss');
                    var advertise_shown_end_time = localStorage.getItem('advertise_expire_time');

                    if (advertise_shown_end_time && now > advertise_shown_end_time) {
                        localStorage.setItem('advertise_shown', 0);
                    }
                },

                initReviewCarousel: function () {
                    $('.client-review-slider').slick({
                        dots: true,
                        arrows: true,
                        slidesToShow: 3,
                        autoplay: false,
                        autoplaySpeed: 2000,
                        slidesToScroll: 1,
                        prevArrow: '<div class="slick-prev offerslider-prev-btn reviewslider-prev-btn"><i class="fas fa-chevron-left"></i></div>',
                        nextArrow: '<div class="slick-next offerslider-next-btn reviewslider-next-btn"><i class="fas fa-chevron-right"></i></div>',
                        responsive: [
                            {
                                breakpoint: 1080,
                                settings: {
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                },
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: 2,
                                    slidesToScroll: 1,
                                },
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                },
                            },
                            {
                                breakpoint: 600,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });
                }

            }
        }).mount('#app')
    </script>
    <script>
        $('.offerproduct-slider').slick({
            dots: false,
            arrows: true,
            slidesToShow: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            slidesToScroll: 1,
            prevArrow: '<div class="slick-prev offerslider-prev-btn"><i class="fas fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next offerslider-next-btn"><i class="fas fa-chevron-right"></i></div>',
            // responsive: [
            //     {
            //         breakpoint: 992,
            //         settings: {
            //             slidesToShow: 3,
            //             slidesToScroll: 1,
            //         },
            //     },
            //     {
            //         breakpoint: 768,
            //         settings: {
            //             slidesToShow: 2,
            //             slidesToScroll: 1,
            //         },
            //     },
            //     {
            //         breakpoint: 600,
            //         settings: {
            //             arrows: true,
            //             slidesToShow: 1,
            //             slidesToScroll: 1
            //         }
            //     }
            // ]
        });
        $('.foodweek-slider').slick({
            dots: false,
            arrows: true,
            slidesToShow: 3,
            autoplay: false,
            autoplaySpeed: 2000,
            slidesToScroll: 1,
            prevArrow: '<div class="slick-prev offerslider-prev-btn"><i class="fas fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next offerslider-next-btn"><i class="fas fa-chevron-right"></i></div>',
            responsive: [
                {
                    breakpoint: 1080,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 600,
                    settings: {
                        arrows: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    </script>

@endpush
