<div class="header-all-section" id="appHeader">
    <!-- Top Header For Food Website -->
    <section class="top-header-section header-large-device">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-3 col-sm-6 col-md-6">
                    <div class="topheader-social-icon">
                        <ul>
                            @if(\App\Services\GlobalSettingService::key('fb_link') ?? null)
                                <li><a href="{{\App\Services\GlobalSettingService::key('fb_link') ?? null}}" target="_blank"><span><i
                                                class="fa-brands fa-facebook-f"></i></span></a></li>
                            @endif
                            @if(\App\Services\GlobalSettingService::key('insta_link') ?? null)
                                <li><a href="{{\App\Services\GlobalSettingService::key('insta_link') ?? null}}" target="_blank"><span><i
                                                class="fa-brands fa-instagram"></i></span></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-9 col-sm-6 col-md-6">
                    <div class="top-header-links">
                        <ul>
                            <li>
                                <p class="topheader-shoplocation me-2">Shop:</p>
                            </li>
                            <li>
                                <div class="top-header-shop-location">
                                    <select name="shop" id="shop" v-model="branch" @change="set_branch()"
                                            class="form-control form-control-sm">
                                        <option value="">Select Shop</option>
                                        @foreach(cache('branches') ?? [] as $branch)
                                            <option value="{{$branch->value}}">{{$branch->name?? ''}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Header For Food Website -->
    <section class="header-section header-large-device">
        <div class="container">
            <div class="" id="headerLarge">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <a class="navbar-brand header-logo" href="/home">
                            <img src="/assets/images/logo.png" alt="{{ config('app.name') }}">
                            <!-- <img src="/assets/images/howmetown-dark.png" alt=""> -->
                        </a>
                        <div class="collapse navbar-collapse">
                            <ul class="navbar-nav header-navbar-nav m-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link header-navlink" aria-current="page" href="/home">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link header-navlink" href="/menu" @click.prevent="openBranchModal()">Order Now</a>
                                </li>
                                @if(\App\Services\GlobalSettingService::key('table_booking') === 'TRUE')
                                    <li class="nav-item">
                                        <a class="nav-link header-navlink" href="/table-booking">Table Booking</a>
                                    </li>
                                @endif
                                @if(\App\Services\GlobalSettingService::key('offer_page') === 'TRUE')
                                    <li class="nav-item">
                                        <a class="nav-link header-navlink" href="/offer">Offer</a>
                                    </li>
                                @endif

                                @if(\App\Services\GlobalSettingService::key('gallery_page') === 'TRUE')
                                    <li class="nav-item">
                                        <a class="nav-link header-navlink" href="/gallery">Gallery</a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a class="nav-link header-navlink" href="/contact-us">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                        @consumer
                        <!-- Account Button -->
                        <div class="header-button">
                            <div class="dropdown">
                                <button class="btn mainbtn-primary account-btn dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="fa-solid fa-user"></i></span>Account
                                </button>
                                <ul class="dropdown-menu accountbtn-dropdown-menu">
                                    <li><a class="dropdown-item account-btn-item" href="/profile/details"><span><i
                                                    class="fa-solid fa-user"></i></span>My Account</a></li>
                                    <li><a class="dropdown-item account-btn-item" href="/profile/order"><span><i
                                                    class="fa-solid fa-box"></i></span>My Order</a></li>
                                    <li><a class="dropdown-item account-btn-item" data-bs-toggle="modal"
                                           data-bs-target="#logoutModal" href="#"><span><i
                                                    class="fa-solid fa-right-from-bracket"></i></span>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                        @else
                            <div class="header-button">
                                <a href="/auth/login" class="btn mainbtn-primary login-btn">Login</a>
                            </div>
                            @endconsumer
                    </div>
                </nav>
            </div>
        </div>
    </section>
    <section class="mobile-header-section header-mobile-device">
        <div class="mobile-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-7">
                        <div class="mobileheader-logo">
                            <a href="/home"><img src="/assets/images/logo.png" alt="{{ config('app.name') }}"></a>
                        </div>
                    </div>
                    <div class="col-5">
                        @consumer
                        <!-- Account Button -->
                        <div class="mobileheader-button">
                            <div class="dropdown">
                                <button class="btn mainbtn-primary account-btn mobileaccount-btn dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="fa-solid fa-user"></i></span>
                                </button>
                                <ul class="dropdown-menu accountbtn-dropdown-menu mobileaccountbtn-dropdown-menu">
                                    <li><a class="dropdown-item account-btn-item" href="/profile/details"><span><i
                                                    class="fa-solid fa-user"></i></span>My Account</a></li>
                                    <li><a class="dropdown-item account-btn-item" href="/profile/order"><span><i
                                                    class="fa-solid fa-box"></i></span>My Order</a></li>
                                    <li><a class="dropdown-item account-btn-item" data-bs-toggle="modal"
                                           data-bs-target="#logoutModal" href="#"><span><i
                                                    class="fa-solid fa-right-from-bracket"></i></span>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                        @else
                        <div class="mobileheader-button">
                            <a href="/auth/login" class="btn mainbtn-primary login-btn">Login</a>
                        </div>
                        @endconsumer
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="mobile-header-section mobile-header-navsection header-mobile-device">
        <div class="mobileheader-all-navcontent">
            <div class="mobile-header-menu">
                <div class="container">
                    <div class="mobile-header-option">
                        <nav class="navbar navbar-expand-lg">
                            <div class="">
                                <button class="navbar-toggler mobile-navbar-toggler" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                                    @php
                                        $path = \Illuminate\Support\Facades\Request::path();

                                        /*Take the last string*/
                                        if(str_contains($path, '/')) {
                                            $path = basename($path);
                                        }
                                    @endphp
                                    <ul class="navbar-nav mobileheader-navbar-nav m-auto mb-2 mb-lg-0">
                                        <li class="nav-item">
                                            <a class="nav-link mobileheader-navlink" aria-current="page"
                                            href="/home"><span><i class="fa-solid  @if($path === 'home') fa-angles-right @else fa-angle-right @endif"></i></span> Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mobileheader-navlink" href="/menu" @click.prevent="openBranchModal()"><span><i
                                                        class="fa-solid @if($path === 'menu') fa-angles-right @else fa-angle-right @endif"></i></span> Order Now</a>
                                        </li>
                                        @if(\App\Services\GlobalSettingService::key('download_menu') === 'TRUE')
                                            <li class="nav-item">
                                                <a class="nav-link mobileheader-navlink" href="#"><span><i
                                                            class="fa-solid fa-angle-right"></i></span> Download Menu</a>
                                            </li>
                                        @endif
                                        @if(\App\Services\GlobalSettingService::key('offer_page') === 'TRUE')
                                            <li class="nav-item">
                                                <a class="nav-link mobileheader-navlink" href="/offer"><span><i
                                                            class="fa-solid @if($path === 'offer') fa-angles-right @else fa-angle-right @endif"></i></span> Offer</a>
                                            </li>
                                        @endif

                                        @if(\App\Services\GlobalSettingService::key('gallery_page') === 'TRUE')
                                            <li class="nav-item">
                                                <a class="nav-link mobileheader-navlink" href="/gallery"><span><i
                                                            class="fa-solid @if($path === 'gallery') fa-angles-right @else fa-angle-right @endif"></i></span> Gallery</a>
                                            </li>
                                        @endif

                                        @if(\App\Services\GlobalSettingService::key('table_booking') === 'TRUE')
                                            <li class="nav-item">
                                                <a class="nav-link mobileheader-navlink" href="/table-booking"><span><i
                                                            class="fa-solid @if($path === 'table-booking') fa-angles-right @else fa-angle-right @endif"></i></span> Table Booking</a>
                                            </li>
                                        @endif

                                        <li class="nav-item">
                                            <a class="nav-link mobileheader-navlink" href="/contact-us"><span><i
                                                        class="fa-solid @if($path === 'contact-us') fa-angles-right @else fa-angle-right @endif"></i></span> Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <div class="mobileheader-arrow-button btn mobileheader-collapse-btn" id="btn-collapse"
                            data-bs-toggle="collapse" href="#LocationCollapse" role="button" aria-expanded="false"
                            aria-controls="collapseExample">
                            <div class="headerlocation-content">
                                <p>
                                    <span><i
                                            class="fa-solid fa-shop"></i></span> {{\App\Services\BranchService::currentName(\App\Services\BranchService::current())}}
                                </p>
                            </div>
                            <div class="mobileheader-arrowbutton-hold">
                                <p>
                                    <span id="headerDownArrowIcon"><i class="fa-solid fa-angle-down"></i></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="collapse headerlocation-collapse" id="LocationCollapse">
                    <div class="container">
                        <div class="headerlocation-collapse-allcontent">
                            <div class="headerlocation-collapse-title">
                                <h4>{{config('app.name')}}</h4>
                            </div>

                            @if($address)
                                <div class="headerlocation-collapse-address">
                                    <p><span><a href="#" target="_blank">{{$address}}</a></span></p>
                                </div>
                            @endif

                            @if($phone)
                                <div class="headerlocation-collapse-address headerlocation-collapse-phone">
                                    <p><span><a href="tel:{{$phone ?? '#'}}">{{ $phone ?? ''}}</a></span></p>
                                </div>
                            @endif
                            <div class="headerlocation-collapse-openingtime">
                                <h5><span><i class="fa-solid fa-clock"></i></span>Opening Times Today</h5>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="headerlocation-timing-title">
                                        <h6>Delivery From</h6>
                                    </div>
                                    <div>
                                        <p>@{{ delivery_from }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="headerlocation-timing-title">
                                        <h6>Collection from</h6>
                                    </div>
                                    <div>
                                        <p>@{{ collection_from }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="hlc-change-button" v-if="branches.length > 1">
                                <a href="#" @click="openBranchModal()" class="ms-2 btn mainbtn-primary login-btn hlc-change-btn">Change Shop</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location Modal -->
    <div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header location-modal-header">
                    <h1 class="modal-title location-modal-title" id="locationModalLabel">{{config('app.name')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body location-modal-body">
                    <div class="location-body-content">
                        <div class="row">
                            <div class="col-12 col-md-7 m-auto">
                                <div class="location-modal-image">
                                    <img src="/assets/images/about.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center mt-3 text-center">
                            <div class="col-12 col-md-12 mb-3">
                                <label for="payment_type"
                                       class="location-formlabel"><span><i
                                            class="fa-solid fa-location-dot"></i></span>Please choose shop</label>
                            </div>
                            <div class="col-12 col-md-12 m-auto">
                                <div class="col-alignment">

                                    @foreach(cache('branches') ?? [] as $branch)
                                        <a href="#" @click.prevent="update_branch('{{$branch->value ?? ''}}')" class="btn mainbtn-primary me-2"> {{$branch->name?? ''}} </a>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
