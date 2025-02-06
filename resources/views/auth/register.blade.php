@extends('layouts.app')

@section('title') Register @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/register.css"/>
@endpush
@section('content')
    <section class="register-section">
        <div class="container">
            <div class="row align-items-top">
                <div class="col-md-12 col-lg-10 m-auto">
                    <div class="register-form">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 register-form-left-bg">
                                <div class="register-form-left">
                                    <div class="register-form-lefttitle">
                                        <h1>Welcome Back to {{ config('app.name') }}</h1>
                                    </div>
                                    <div class="register-form-left-image">
                                        <img src="/assets/images/register.svg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="register-form-right">
                                    <div class="register-form-righttitle">
                                        <h1>Create your account</h1>
                                    </div>
                                    <div class="register-form-content  registerpage-form-content">
                                        <form @submit.prevent="register()">
                                            <div class="mb-3 name-field">
                                                <input type="text" class="form-control" v-model="first_name" placeholder="First name"
                                                    autocomplete="off"
                                                    required>
                                                <input type="text" class="form-control" v-model="last_name" placeholder="Last name"
                                                    autocomplete="off"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <input type="email" class="form-control" v-model="email" placeholder="Email Address"
                                                    autocomplete="off"
                                                    required>
                                            </div>

                                            <div class="mb-3 registerpage-password">
                                                <input type="password" class="form-control" id="password" placeholder="Password"
                                                    autocomplete="off"
                                                    v-model="password" required>
                                                <span class="eye-btn" @click="showPassword()"><i class="fa-regular fa-eye-slash"
                                                                                                id="toggle-password"></i></span>
                                            </div>
                                            {{--<div class="form-check terms-conditions">
                                                <input class="form-check-input register-form-check-input" type="checkbox" value="" id="flexCheckTC" required>
                                                <label class="form-check-label" for="flexCheckTC">
                                                    I have read and agree with the <a href="/terms-and-conditions">terms &
                                                        conditions</a>
                                                </label>
                                            </div>--}}
                                            <div class="register-button">
                                                <input type="submit" class="btn btn-register" value="Create Account">
                                            </div>
                                        </form>
                                        <div class="login-link">
                                            <p>Already have an account? <a href="/auth/login">Sign In</a></p>
                                        </div>
                                    </div>
                                </div>
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

        createApp({
            data() {
                return {
                    api_url: '{{config('api.apiUrl')}}',

                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    username: '',
                    // sex: '',
                    // dob_day: '',
                    // dob_month: '',
                    // dob_year: '',
                    password: '',

                    years: [],

                    checkUsername: '',
                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

                const self = this;
                self.getYears();
            },
            methods: {
                register: async function () {
                    const self = this;

                    if(!self.validatePassword(self.password) || self.password.length < 8) {
                        swal("Password must be 8 character long and contain one special character", {
                            icon: 'warning',
                            dangerMode: true
                        });
                        return false;
                    }

                    var properties = {
                        first_name: self.first_name,
                        last_name: self.last_name,
                        // gender: self.sex,
                        // dob: self.dob,
                    }

                    axios.post(self.api_url + '/consumer/register',
                        {
                            name: self.first_name + ' ' + self.last_name,
                            email: self.email,
                            phone: self.phone,
                            username: self.username,
                            password: self.password,
                            password_confirmation: self.password,
                            properties: properties,
                        }
                    )
                        .then(res => {
                            swal("Registration successful!", {
                                icon: 'success'
                            });

                            setTimeout(function () {
                                window.location = '/auth/login'
                            }, 1000)
                        })
                        .catch(err => {
                            console.log(err)
                            var msg = err.response?.data?.message;
                            swal(msg, {
                                icon: 'warning',
                                dangerMode: true
                            });
                        })
                },
                check_username: function () {
                    const self = this;
                    axios.get(self.api_url + '/consumer/check/username/' + self.username)
                        .then(res => {
                            self.checkUsername = res.data;
                        })
                        .catch(err => {
                            console.log(err)
                        })
                },
                getYears: function () {
                    const self = this;
                    var end_year = parseInt(moment().format('YYYY'));
                    for (var i = 1900; i < end_year; i++) {
                        self.years.push(i);
                    }
                },

                showPassword: function () {
                    var x = document.getElementById("password");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                },

                getRandomNumber: function (min, max) {
                    return Math.floor(Math.random() * (max - min + 1)) + min;
                },

                validatePassword: function (password) {
                    // Regular expression pattern to match special characters
                    var specialCharPattern = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

                    // Check if the password contains at least one special character
                    if (specialCharPattern.test(password)) {
                        return true; // Password is valid
                    } else {
                        return false; // Password does not have a special character
                    }
                }
            },
            computed: {
                dob: function () {
                    const self = this;
                    return self.dob_year + '-' + self.dob_month + '-' + self.dob_day;
                },
            },
            watch: {
                first_name: function (val) {
                    const self = this;
                    var username1 = '';
                    var username2 = '';
                    username1 = val.toLowerCase();
                    if (self.last_name) {
                        username2 = (self.last_name.charAt(0)).toLowerCase();
                    }
                    var username = username1 + '' + username2 + '' +  self.getRandomNumber(0, 999);
                    self.username = username.replace(/\s/g, '');
                },
                last_name: function (val) {
                    const self = this;
                    var username1 = '';
                    var username2 = '';
                    if (self.first_name) {
                        username1 = self.first_name.toLowerCase();
                    }
                    username2 = (val.charAt(0)).toLowerCase();

                    var username = username1 + '' + username2 + '' +  self.getRandomNumber(0, 999);
                    self.username = username.replace(/\s/g, '');
                },
                username: function (val) {
                    const self = this;

                }
            }
        }).mount('#app')

    </script>
@endpush
