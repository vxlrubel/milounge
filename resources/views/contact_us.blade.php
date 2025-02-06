@extends('layouts.app')

@section('title') Contact Us @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/contact.css"/>
@endpush

@section('content')

    @php
        $phone = \App\Services\GlobalSettingService::key('business_phone') ?? '';
        $phone2 = \App\Services\GlobalSettingService::key('business_phone_2') ?? '';
        $email = \App\Services\GlobalSettingService::key('business_email') ?? '';
        $address = \App\Services\GlobalSettingService::key('business_address') ?? '';
    @endphp

    <section class="contact-section">
        <div class="container">
            <div class="contact-all-content">
                <div class="contact-content">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="contact-us-leftcontent">
                                <div class="row">
                                    <div class="col-md-12 col-lg-11">
                                        <div class="contact-us-content">
                                            <h1><span></span>Contact Us</h1>
                                            <h4>We're here to help, seven days a week</h4>
                                            <p>
                                                Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text ever
                                                since the 1500s, when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen book. It has survived not only five
                                                centuries, but also the leap into electronic typesetting, remaining
                                                essentially unchanged.
                                            </p>
                                        </div>
                                        <div class="contactus-contactinfo">

                                            <div class="contact-info-allitem contact-info-address">
                                                <div class="contact-infoitem">
                                                    <div class="contact-info-icon">
                                                        <i class="fa-solid fa-phone"></i>
                                                    </div>
                                                    <div class="contact-info-content">
                                                        <h6>Phone</h6>
                                                        <p><a href="tel:{{$phone ?? ''}}">{{$phone ?? ''}}</a> @if($phone2), <a href="tel:{{$phone2 ?? ''}}">{{$phone2 ?? ''}}</a>@endif</p>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($email)
                                            <div class="contact-info-allitem contact-info-address">
                                                <div class="contact-infoitem">
                                                    <div class="contact-info-icon">
                                                        <i class="fa-solid fa-envelope"></i>
                                                    </div>
                                                    <div class="contact-info-content">
                                                        <h6>Email</h6>
                                                        <p><a href="mailto:{{$email ?? ''}}">{{$email ?? ''}}</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="contact-info-allitem contact-info-address">
                                                <div class="contact-infoitem">
                                                    <div class="contact-info-icon">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                    </div>
                                                    <div class="contact-info-content">
                                                        <h6>Address</h6>
                                                        <p><a href="#" target="_blank">{{$address ?? ''}}</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="contact-formcontent">
                                <div class="contact-us-form">
                                    <form @submit.prevent="contact()">
                                        @csrf
                                        <div class="row contactform-rowalignment">
                                            <div class="col-md-6">
                                                <div class="form-group contactform-label">
                                                    <label for="">Name</label>
                                                    <input type="text" class="form-control coontactform-input"
                                                           placeholder="Name" v-model="name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group contactform-label">
                                                    <label for="">Phone Number</label>
                                                    <input type="text" class="form-control coontactform-input"
                                                           placeholder="Phone" v-model="phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row contactform-rowalignment">
                                            <div class="col-md-12">
                                                <div class="form-group contactform-label">
                                                    <label for="">Email</label>
                                                    <input type="email" class="form-control coontactform-input"
                                                           placeholder="Email Address" v-model="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row contactform-rowalignment">
                                            <div class="col-md-12">
                                                <div class="form-group contactform-label">
                                                    <label for="">Message</label>
                                                    <textarea class="form-control coontactform-input" rows="4" cols="50"
                                                              placeholder="Write your message"
                                                              v-model="message"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contact-form-button">
                                            <button type="submit" class="btn contactform-btn">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-map-content">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="contact-location-map">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d307.7867981948139!2d-0.42980009440550165!3d51.892091583229686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4876485564027dd9%3A0x25a36489f3bbe12!2sSaree%20Bazaar!5e0!3m2!1sen!2sbd!4v1686813543730!5m2!1sen!2sbd"
                                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        const {createApp} = Vue

        var app = createApp({
            data() {
                return {
                    api_url: '{{config('api.apiUrl')}}',
                    headers: {
                        "Authorization": "Bearer {{session('api_token')}}"
                    },

                    name: '',
                    phone: '',
                    email: '',
                    message: '',
                }
            },
            methods: {
                contact: function () {
                    const self = this;

                    axios.post(self.api_url + '/contact-us',
                        {
                            name: self.name,
                            email: self.email,
                            phone: self.phone,
                            message: self.message,
                            branch: '{{\App\Services\BranchService::current()}}',
                        }
                    )
                        .then(res => {
                            swal("Success!", "Information submitted!", {
                                icon: 'success'
                            });
                        })
                        .catch(err => {
                            console.log(err)
                            swal("Warning!", "Something went wrong!", {
                                icon: 'error'
                            });
                        })
                }
            }
        }).mount('#app')

    </script>
@endpush
