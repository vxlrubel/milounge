<!-- Footer Section For Mobile View End -->
<section class="footer-section" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="footer-logo">
                    {{-- <img src="/assets/images/logo.png" alt="{{ config('app.name') }}"> --}}
                    <a href="/home">
                        <img src="{{asset('assets/mi-img/logo.png')}}" class="logo-border-theme" alt="{{ config('app.name') }}">
                    </a>
                </div>
                <div class="footer-details">
                    <div class="footer-opening-time">
                        <h5>Opening Time</h5>
                        @php
                            $opening_time = \App\Services\GlobalSettingService::key('opening_time_'. strtolower(now()->format('l'))) ?? null;
                            $closing_time = \App\Services\GlobalSettingService::key('closing_time_'. strtolower(now()->format('l'))) ?? null;
                            $business_weekly_off_day = \App\Services\GlobalSettingService::key('business_weekly_off_day') ?? null;
                            $today = strtolower(now()->format('l'));

                            $opening_time = \Illuminate\Support\Carbon::parse($opening_time)->format('H:i');
                            $closing_time = \Illuminate\Support\Carbon::parse($closing_time)->format('H:i');
                        @endphp

                        @if($business_weekly_off_day === $today)
                            <p>Today: Closed</p>
                        @else
                            <p>Today: {{$opening_time}} to {{$closing_time}}</p>
                        @endif
                    </div>
                    <div class="footer-all-contactifo footer-large-device">
                        <div class="footer-contact-info">
                            <div class="contact-icon">
                                <span><i class="fa-solid fa-phone"></i></span>
                            </div>
                            <div class="contact-details">
                                <a href="tel:{{$phone ?? ''}}">{{$phone ?? ''}}</a> @if($phone2), <a
                                    href="tel:{{$phone2 ?? ''}}">{{$phone2 ?? ''}}</a>@endif
                            </div>
                        </div>

                        @if($email)
                        <div class="footer-contact-info">
                            <div class="contact-icon">
                                <span><i class="fa-solid fa-envelope"></i></span>
                            </div>
                            <div class="contact-details">
                                <a href="mailto:{{$email ?? ''}}">{{$email ?? ''}}</a>
                            </div>
                        </div>
                        @endif

                        <div class="footer-contact-info">
                            <div class="contact-icon">
                                <span><i class="fa-solid fa-location-dot"></i></span>
                            </div>
                            <div class="contact-details">
                                <a href="#" target="_blank">{{$address ?? ''}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="footer-contactifo-accordion footer-mobile-device">
                        <div class="accordion" id="footerContactInfo">
                            <div class="accordion-item footer-accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button footer-accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#footerContactLink"
                                            aria-expanded="true" aria-controls="footerContactLink">
                                        Our Contact Information
                                    </button>
                                </h2>
                                <div id="footerContactLink" class="accordion-collapse collapse"
                                     data-bs-parent="#footerContactInfo">
                                    <div class="accordion-body footer-accordion-body">
                                        <div>

                                            <div class="footer-contact-info">
                                                <div class="contact-icon">
                                                    <span><i class="fa-solid fa-phone"></i></span>
                                                </div>
                                                <div class="contact-details mobile-contact-details">
                                                    <a href="tel:{{$phone ?? ''}}">{{$phone ?? ''}}</a> @if($phone2), <a
                                                        href="tel:{{$phone2 ?? ''}}">{{$phone2 ?? ''}}</a>@endif
                                                </div>
                                            </div>

                                            @if($email)
                                                <div class="footer-contact-info">
                                                    <div class="contact-icon">
                                                        <span><i class="fa-solid fa-envelope"></i></span>
                                                    </div>
                                                    <div class="contact-details mobile-contact-details">
                                                        <a href="mailto:{{$email ?? ''}}">{{$email ?? ''}}</a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="footer-contact-info">
                                                <div class="contact-icon">
                                                    <span><i class="fa-solid fa-location-dot"></i></span>
                                                </div>
                                                <div class="contact-details mobile-contact-details">
                                                    <a href="#"
                                                       target="_blank">{{$address ?? ''}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-large-device">
                    <div class="footer-links-title">
                        <h3>Useful Links</h3>
                    </div>
                    <div class="footer-useful-link">
                        <ul>
                            <li>
                                <div class="footer-link-icon">
                                    <span><i class="fa-solid fa-caret-right"></i></span>
                                </div>
                                <div class="footer-link-content">
                                    <a href="/about-us">About Us</a>
                                </div>
                            </li>
                            <li>
                                <div class="footer-link-icon">
                                    <span><i class="fa-solid fa-caret-right"></i></span>
                                </div>
                                <div class="footer-link-content">
                                    <a href="/contact-us">Contact Us</a>
                                </div>
                            </li>
                            @if(\App\Services\GlobalSettingService::key('download_menu') === 'TRUE')
                                <li>
                                    <div class="footer-link-icon">
                                        <span><i class="fa-solid fa-caret-right"></i></span>
                                    </div>
                                    <div class="footer-link-content">
                                        <a href="#">Download Menu</a>
                                    </div>
                                </li>
                            @endif
                            <li>
                                <div class="footer-link-icon">
                                    <span><i class="fa-solid fa-caret-right"></i></span>
                                </div>
                                <div class="footer-link-content">
                                    <a href="/menu">Order Now</a>
                                </div>
                            </li>
                            @if(\App\Services\GlobalSettingService::key('table_booking') === 'TRUE')
                                <li>
                                    <div class="footer-link-icon">
                                        <span><i class="fa-solid fa-caret-right"></i></span>
                                    </div>
                                    <div class="footer-link-content">
                                        <a href="/table-booking">Table Booking</a>
                                    </div>
                                </li>
                            @endif
                            @if(\App\Services\GlobalSettingService::key('offer_page') === 'TRUE')
                                <li>
                                    <div class="footer-link-icon">
                                        <span><i class="fa-solid fa-caret-right"></i></span>
                                    </div>
                                    <div class="footer-link-content">
                                        <a href="/offer">Offer</a>
                                    </div>
                                </li>
                            @endif
                            @if(\App\Services\GlobalSettingService::key('gallery_page') === 'TRUE')
                                <li>
                                    <div class="footer-link-icon">
                                        <span><i class="fa-solid fa-caret-right"></i></span>
                                    </div>
                                    <div class="footer-link-content">
                                        <a href="/gallery">Gallery</a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="footer-mobile-device mt-3">
                    <div class="accordion" id="accordionUsefulLink">
                        <div class="accordion-item footer-accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button footer-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#usefulLinks" aria-expanded="true"
                                        aria-controls="usefulLinks">
                                    Useful Links
                                </button>
                            </h2>
                            <div id="usefulLinks" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionUsefulLink">
                                <div class="accordion-body footer-accordion-body">
                                    <div class="footer-useful-link mobilefooter-useful-link">
                                        <ul>
                                            <li>
                                                <div class="footer-link-icon mobilefooter-link-icon">
                                                    <span><i class="fa-solid fa-caret-right"></i></span>
                                                </div>
                                                <div class="footer-link-content mobilefooter-link-content">
                                                    <a href="/about-us">About Us</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="footer-link-icon mobilefooter-link-icon">
                                                    <span><i class="fa-solid fa-caret-right"></i></span>
                                                </div>
                                                <div class="footer-link-content mobilefooter-link-content">
                                                    <a href="/contact-us">Contact Us</a>
                                                </div>
                                            </li>
                                            @if(\App\Services\GlobalSettingService::key('download_menu') === 'TRUE')
                                                <li>
                                                    <div class="footer-link-icon mobilefooter-link-icon">
                                                        <span><i class="fa-solid fa-caret-right"></i></span>
                                                    </div>
                                                    <div class="footer-link-content mobilefooter-link-content">
                                                        <a href="">Download Menu</a>
                                                    </div>
                                                </li>
                                            @endif
                                            <li>
                                                <div class="footer-link-icon mobilefooter-link-icon">
                                                    <span><i class="fa-solid fa-caret-right"></i></span>
                                                </div>
                                                <div class="footer-link-content mobilefooter-link-content">
                                                    <a href="/menu">Order Now</a>
                                                </div>
                                            </li>
                                            @if(\App\Services\GlobalSettingService::key('table_booking') === 'TRUE')
                                                <li>
                                                    <div class="footer-link-icon mobilefooter-link-icon">
                                                        <span><i class="fa-solid fa-caret-right"></i></span>
                                                    </div>
                                                    <div class="footer-link-content mobilefooter-link-content">
                                                        <a href="/table-booking">Table Booking</a>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="footer-links-title">
                        <h3>Follow Us</h3>
                    </div>
                    <div class="footer-social-link">
                        <ul>
                            @if(\App\Services\GlobalSettingService::key('fb_link'))
                                <li>
                                    <a href="{{\App\Services\GlobalSettingService::key('fb_link') ?? '#'}}" target="_blank"><span><i
                                                class="fa-brands fa-facebook-f"></i></span></a>
                                </li>
                            @endif
                            @if(\App\Services\GlobalSettingService::key('insta_link'))
                                <li>
                                    <a href="{{\App\Services\GlobalSettingService::key('insta_link') ?? '#'}}" target="_blank"><span><i
                                                class="fa-brands fa-instagram"></i></span></a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="footer-contactform">
                    <div class="subscribe-title">
                        <p>Subscribe to Our Newsletter</p>
                    </div>
                    <form @submit.prevent="storeNewsletter()">
                        @csrf
                        <div class="mb-3">
                            <input type="email" class="form-control footer-formcontrol" v-model="newsletter_email"
                                   placeholder="Email Address"
                                   required>
                        </div>
                        <button type="submit" class="btn footer-formbtn">Subscribe</button>
                    </form>
                </div>
                {{-- <div class="footer-contactform">
                    <div class="subscribe-title">
                        <p>DELIVERY AREAS</p>
                    </div>
                        <div class="mb-3">
                            <p class="text-white">Delivery Charge £1.00 : Up-to 2 mile radius</p>
                            <p class="text-white">Delivery Charge £3.00 : Up-to 5 mile radius</p>
                        </div>
                </div> --}}
            </div>
        </div>
        <div class="footer-learnmore-links">
            <div class="footer-large-device">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <div class="separator"></div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-4 col-lg-5">
                                <div class="learn-more-link">
                                    <ul>
                                        <li><a href="/faq">FAQs</a></li>
                                        <li><a href="/privacy-policy">Privacy Policy</a></li>
                                        <li><a href="/refund-policy">Refund Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4"></div>
                            <div class="col-md-2 col-lg-3">
                                <div class="yuma-logo footer-large-device">
                                    <a href="https://yuma-technology.co.uk/" target="_blank"><img
                                            src="/assets/images/powered_by_yuma.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <div class="separator"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-mobile-device">
                <div class="row">
                    <div class="col-12">
                        <h6 class="footerlearn-more-title">Lean More</h6>
                    </div>
                    <div class="col-6 m-auto">
                        <div class="footermobile-learnmore-links">
                            <a href="/faq" class="btn fm-lm-linkbtn">FAQs</a>
                        </div>
                    </div>
                    <div class="col-6 m-auto">
                        <div class="footermobile-learnmore-links">
                            <a href="/privacy-policy" class="btn fm-lm-linkbtn">Privacy Policy</a>
                        </div>
                    </div>
                    <div class="col-6 m-auto">
                        <div class="footermobile-learnmore-links">
                            <a href="/refund-policy" class="btn fm-lm-linkbtn">Refund Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="footer-bottom-section">
    <div class="container">
        <div class="row align-items-center mobile-footerbottom-row">
            <div class="col-md-5 col-lg-4">
                <div class="footer-copyright">
                    <p><span><i class="fa-regular fa-copyright"></i></span>Copyright. All right Reserved {{now()->format('Y')}}. <small>v{{config('app.version')}}</small></p>
                </div>
            </div>
            <div class="col-md-7 col-lg-8">
                <div class="payment-option">
                    <div class="payment">
                        <div class="payment-with d-flex align-items-center">
                            <span><i class="fa-solid fa-lock"></i></span>
                            <p>Pay Securely with</p>
                        </div>
                    </div>
                    <div class="payment-method">
                        <div class="payment">
                            <div class="payment-method-logo">
                                <img src="/assets/images/payment-logo/visa.jpg" alt=""/>
                            </div>
                        </div>
                        <div class="payment">
                            <div class="payment-method-logo">
                                <img src="/assets/images/payment-logo/mastercard.jpg" alt=""/>
                            </div>
                        </div>
                        <div class="payment">
                            <div class="payment-method-logo">
                                <img src="/assets/images/payment-logo/Amex.jpg" alt=""/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="yuma-mobile-logo footer-mobile-device">
                    <a href="https://yuma-technology.co.uk/" target="_blank"><img
                            src="/assets/images/Powered-by-yuma-mobile1.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>
