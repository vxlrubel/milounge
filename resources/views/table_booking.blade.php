@extends('layouts.app')

@section('title') Table Booking @endsection

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
                    @if(\App\Services\GlobalSettingService::key('table_booking') ?? null === 'TRUE')
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="contact-us-leftcontent">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-11">
                                            <div class="contact-us-content">
                                                <h1><span></span>Table Booking</h1>
                                                <h4>Book your table anytime before you there.</h4>
                                                <p>
                                                    {{--Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry. Lorem Ipsum has been the industry's standard dummy text
                                                    ever
                                                    since the 1500s, when an unknown printer took a galley of type and
                                                    scrambled it to make a type specimen book. It has survived not only
                                                    five
                                                    centuries, but also the leap into electronic typesetting, remaining
                                                    essentially unchanged.--}}
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
                                                                <p><a href="mailto:{{$email ?? ''}}">{{$email ?? ''}}</a>
                                                                </p>
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
                                        <form @submit.prevent="book()">
                                            @csrf
                                            <div class="row contactform-rowalignment">
                                                <div class="col-md-6">
                                                    <div class="form-group contactform-label">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control coontactform-input"
                                                               placeholder="Name" v-model="name" name="name" id="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group contactform-label">
                                                        <label for="phone">Phone Number</label>
                                                        <input type="text" class="form-control coontactform-input"
                                                               placeholder="Phone" v-model="phone" name="phone"
                                                               id="phone" required>
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
                                                <div class="col-md-6">
                                                    <div class="form-group contactform-label">
                                                        <label for="number_of_guest">Number of guest</label>
                                                        <input type="number" min="1"
                                                               class="form-control coontactform-input"
                                                               placeholder="" v-model="number_of_guest" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group contactform-label">
                                                        <label for="arrival_time">Date</label>
                                                        <input type="datetime-local"
                                                               class="form-control coontactform-input"
                                                               placeholder="" v-model="arrival_time" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row contactform-rowalignment">
                                                <div class="col-md-12">
                                                    <div class="form-group contactform-label">
                                                        <label for="">Note</label>
                                                        <textarea class="form-control coontactform-input" rows="4"
                                                                  cols="50"
                                                                  placeholder="Write your note"
                                                                  v-model="message"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="contact-form-button">
                                                <button type="submit" class="btn contactform-btn" :disabled="loading">
                                                    @{{ loading ? 'Booking...' : 'Book' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-md-6" style="min-height: 50vh">
                                <p class="text-center">
                                    Table Booking is inactive
                                </p>
                            </div>
                        </div>
                    @endif
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
                    loading: false,

                    gs: @json(\App\Services\GlobalSettingService::all()),

                    branch: '{{\App\Services\BranchService::current()}}',

                    name: "{{session('user')->name ??  ''}}",
                    phone: "{{session('user')->phone ??  ''}}",
                    email: "{{session('user')->email ??  ''}}",
                    message: '',

                    arrival_time: moment().add(1, 'days').format('YYYY-MM-DD HH:mm'),

                    number_of_guest: 1,
                }
            },
            created() {
                const self = this;
            },
            methods: {
                book: function () {
                    const self = this;

                    // if(!self.checkRequestedTime()) {
                    //     swal("Warning!", "Please choose time correctly", {
                    //         icon: 'error'
                    //     });
                    //     return false;
                    // }

                    self.loading = true;

                    axios.post(self.api_url + '/table-booking',
                        {
                            name: self.name,
                            email: self.email,
                            phone: self.phone,
                            note: self.message,
                            arrival_time: moment(self.arrival_time).format('YYYY-MM-DD HH:mm'),
                            number_of_guest: self.number_of_guest,
                            branch: self.branch,
                        }
                    )
                        .then(res => {
                            swal("Success!", "Table booking request has been sent.", {
                                icon: 'success'
                            });
                            self.message = '';
                            self.number_of_guest = 1;

                            self.loading = false;

                        })
                        .catch(err => {
                            console.log(err)
                            swal("Warning!", "Something went wrong!", {
                                icon: 'error'
                            });

                            self.loading = false;
                        })
                },

                checkRequestedTime: function () {
                    const self = this;

                    var requested_timestamp = moment(self.arrival_time).format('YYYY-MM-DD HH:mm') + ':00';
                    var requested_time = moment(requested_timestamp).format('HH:mm:ss');

                    var date = moment(requested_timestamp).format('dddd');
                    date = date.toLocaleLowerCase(); // sunday
                    var current_time = moment().format('HH:mm:ss');

                    var delivery_from_key = 'delivery_from_' + date;
                    var delivery_from = self.gs[delivery_from_key] || null;

                    var collection_from_key = 'collection_from_' + date;
                    var collection_from = self.gs[collection_from_key] || null;

                    var closing_time_key = 'closing_time_' + date;
                    var closing_time = self.gs[closing_time_key] || null;

                    closing_time = moment(closing_time, 'HH:mm:ss').format('HH:mm:ss');

                    console.log(current_time)
                    console.log(requested_time)
                    console.log(closing_time);
                    console.log(collection_from);

                    // check if the requested time is older than current time
                    // if (current_time > requested_time) {
                    //     return false;
                    // }

                    // check if the requested time is after opening time (collection)
                    if(requested_time < collection_from) {
                        return false;
                    }

                    // check if the requested time is before closing time
                    if (requested_time > closing_time) {
                        return false;
                    }

                    return true;

                },
            }
        }).mount('#app')

    </script>
@endpush
