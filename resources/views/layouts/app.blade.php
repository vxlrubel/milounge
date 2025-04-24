<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title> @yield('title') | {{config('app.name')}}</title>

@stack('meta')

<!-- Google Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="/assets/css/all.min.css"/>
    <link rel="stylesheet" href="/assets/css/owl.carousel.css"/>

    <style>
        :root{
            --mi-color-primary: #e5c104;
            --mi-color-primary-hover: #bfa003;
        }
        [v-cloak] {
            display: none;
        }

    </style>
    <link rel="stylesheet" href="/assets/css/slick.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.png"/>
    <link rel="stylesheet" href="/assets/css/foodstyle.css"/>
    {{-- <link rel="stylesheet" href="/assets/css/responsive.css"/> --}}
    <link rel="stylesheet" href="/assets/css/foodresponsive.css"/>
    <link rel="stylesheet" href="/assets/css/mobileheaderresponsive.css"/>
    <link rel="stylesheet" href="/assets/css/modal.css"/>

    <style>
        .mobileheader-logo img{
            max-width: 60px !important;
        }
        .text-justify{
            text-align: justify;
        }
        img.logo-border-theme {
            border: 2px solid #e5c104;
            border-radius: 50%;
        }
    </style>
    @stack('style')

</head>
<body>

@php
    $phone = \App\Services\GlobalSettingService::key('business_phone') ?? '';
    $phone2 = \App\Services\GlobalSettingService::key('business_phone_2') ?? '';
    $email = \App\Services\GlobalSettingService::key('business_email') ?? '';
    $address = \App\Services\GlobalSettingService::key('business_address') ?? '';
@endphp

@include('layouts.header')

<div class="body-wrapper">

    <div id="app">
        @yield('content')
    </div>

    <div id="appFooter">
        @include('layouts.footer')
    </div>

    <div class="modal fade logoutModal" id="logoutModal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirm logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <a type="button" href="{{ route('auth.logout') }}" class="btn mainbtn-primary"
                           onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- JS File Link -->
<script src="/assets/js/jquery.js"></script>
<script src="/assets/js/slick.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/all.min.js"></script>
<script src="/assets/js/owl.carousel.min.js"></script>
@if(config('app.env') === 'production')
    <script src="/assets/js/vue.global.prod.min.js"></script>
@else
    <script src="/assets/js/vue.global.js"></script>
@endif
<script src="/assets/js/axios.min.js"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/sweetalert.min.js"></script>

@stack('script')

<!-- <script src="/assets/js/largemagnifying.js"></script> -->

<script>

    var app2 = createApp({
        data() {
            return {
                cart: JSON.parse(localStorage.getItem('cart')) || [],

                branch: '{{\App\Services\BranchService::current()}}',
                branches: @json(cache('branches')),

                delivery_from: '',
                collection_from: '',
                gs: @json(\App\Services\GlobalSettingService::all() ?? []),
            }
        },
        created() {

            const self = this;

            self.checkCartItemExpiry();

            var date = moment().format('dddd');
            date = date.toLocaleLowerCase(); // sunday
            var delivery_from_key = 'delivery_from_' + date;
            var delivery_from = self.gs[delivery_from_key] || null;
            if (delivery_from) {
                self.delivery_from = moment(delivery_from, "HH:mm:ss").format('HH:mm')
            }
            var collection_from_key = 'collection_from_' + date;
            var collection_from = self.gs[collection_from_key] || null;
            if (delivery_from) {
                self.collection_from = moment(collection_from, "HH:mm:ss").format('HH:mm')
            }
        },
        computed: {
            total_price: function () {
                const self = this;
                var total_price = 0;
                self.cart.forEach(function (val) {
                    total_price += parseFloat(val.price);
                })

                return total_price.toFixed(2);
            }
        },
        methods: {
            visibleform: function () {
                const element = document.getElementById("mobileForm");
                if (element.className == "mobileSearchField") {
                    element.className = "mobileSearchVisible";
                } else {
                    element.className = "mobileSearchField";
                }
            },
            mobileCartItem: function () {
                const element = document.getElementById("mobileCart");
                const accountelement = document.getElementById("mobileLoginmenu");
                if (element.className == "mobileCartItem") {
                    element.className = "mobileCartItemVisible";
                    accountelement.className = "mobileLoginItem";
                } else {
                    element.className = "mobileCartItem";
                }
            },
            mobileAccountItem: function () {
                const element = document.getElementById("mobileLoginmenu");
                const cartelement = document.getElementById("mobileCart");
                if (element.className == "mobileLoginItem") {
                    element.className = "mobileLoginItemVisible";
                    cartelement.className = "mobileCartItem";
                } else {
                    element.className = "mobileLoginItem";
                }
            },

            removeCart: function (index) {
                const self = this;

                self.cart.splice(index, 1);

                localStorage.setItem('cart', JSON.stringify(self.cart));

            },

            openBranchModal: function () {
                const self = this;
                if(self.branches.length > 1) {
                    $("#branchModal").modal('show');
                }else{
                    window.location = '/menu'
                }
            },

            set_branch: function () {
                var self = this;
                if (!self.branch) {
                    return false;
                }
                var current_branch = '{{\App\Services\BranchService::current()}}';
                if(current_branch === self.branch) {
                    return false;
                }

                if(self.cart.length || app?.cart?.length) {

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

                }else{

                    localStorage.setItem('cart', JSON.stringify([]));
                    window.location = '/branch/set/' + self.branch;

                }

            },
            update_branch: function (branch) {

                var self = this;
                if (!branch) {
                    return false;
                }

                var current_branch = '{{\App\Services\BranchService::current()}}';
                if(current_branch === branch) {
                    window.location = '/'+branch +'/menu';
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

                            }else{
                                self.branch = '{{\App\Services\BranchService::current()}}';
                            }
                        });
                }else{
                    window.location = '/'+branch +'/menu';

                }

            },

            checkCartItemExpiry: function () {
                const self = this;

                var cart_expire_time = localStorage.getItem('cart_expire_at');

                var current_time = moment().format('YYYY-MM-DD HH:mm:ss');

                if (current_time > cart_expire_time) {
                    self.cart = [];
                    app.cart = [];
                    localStorage.removeItem('cart');
                    localStorage.removeItem('cart_expire_at')
                }

            },
        },
        watch: {
            branch: function (val) {
                /*if(val){
                    localStorage.setItem('cart', JSON.stringify([]));

                    window.location = '/branch/set/'+ val;
                }*/
            },
        },
    }).mount('#appHeader');

    var app3 = createApp({
        data() {
            return {
                api_url: '{{config('api.apiUrl')}}',
                headers: {
                    "Authorization": "Bearer {{session('api_token')}}"
                },
                newsletter_email: ''
            }
        },
        methods: {
            storeNewsletter: function () {
                const self = this;
                axios.post(self.api_url + '/newsletter',
                    {
                        email: self.newsletter_email,
                    }
                )
                    .then(res => {
                        swal("Success!", "Email successfully added for newsletter", {
                            icon: 'success'
                        });
                        self.newsletter_email = '';
                    })
                    .catch(err => {
                        console.log(err)
                        var msg = err.response?.data?.message || "Something went wrong!";
                        swal("Warning!", msg, {
                            icon: 'error'
                        });
                    })
            }
        }
    }).mount('#appFooter');


    @if(session('success') || session('error'))
    $(window).on('load', function () {
        @if(session('success'))
        swal('Success! {{session('success')}}', {
            icon: 'success'
        });
        @endif
        @if(session('error'))
        swal('Warning! {{session('error')}}', {
            icon: 'warning'
        });
        @endif
    })
    @endif

    {{--Clear cart--}}
    @if(session('clear_cart'))
    $(window).on('load', function () {
        localStorage.removeItem('cart');
        localStorage.removeItem('fullCartComment');
        app2.cart = [];
    })
    @endif

    $(document).ready(function () {

        window.addEventListener("error", function (e) {
            //localStorage.removeItem('cart');
        })

        $(".dropdown-mobilemenu a.mainheader-dropdown-item").on("click", function (e) {
            $(this).next("ul").toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });

    $(function () {
        $(document).click(function (event) {
            var clickover = $(event.target);
            var _opened = $(".navbar-collapse").hasClass("navbar-collapse collapse show");
            if (_opened === true && !clickover.hasClass("mobile-navbar-toggler")) {
                $("button.mobile-navbar-toggler").click();
            }
        });
    });

    $('#headerLarge .navbar-nav a').on('click', function () {
        $('#headerLarge .navbar-nav').find('li.active').removeClass('active');
        $(this).parent('li').addClass('active');
    });

    $('body').click(function () {
        var icon = document.getElementById('headerDownArrowIcon');
        if ($('#LocationCollapse').hasClass('show')) {
            $('#LocationCollapse').removeClass('show');
            icon.innerHTML = '<i class="fa-solid fa-angle-down"></i>';
        }
    });
    $(".mobileheader-collapse-btn").click(function () {
        if ($(this).hasClass('collapsed')) {
            $(this).children('.mobileheader-arrowbutton-hold').find('svg').attr('data-icon', 'angle-down');
        } else {
            $(this).children('.mobileheader-arrowbutton-hold').find('svg').attr('data-icon', 'angle-up');
        }
    });
</script>
<script>
    $(window).scroll(function (e) {
        var $el = $('.mobile-header-navsection');
        var isPositionFixed = ($el.css('position') == 'fixed');
        if ($(this).scrollTop() > 55 && !isPositionFixed) {
            $el.css({
                'position': 'fixed',
                'top': '0px',
                'width': '100%',
                'left': '0',
                'right': '0',
            });
        }
        if ($(this).scrollTop() < 55 && isPositionFixed) {
            $el.css({
                'position': 'static',
                'top': '0px',
            });
        }
    });
</script>
</body>
</html>
