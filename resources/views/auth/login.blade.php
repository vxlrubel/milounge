@extends('layouts.app')

@section('title') Login @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/login.css"/>
@endpush
@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-10 m-auto">
                    <div class="login-form">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 login-form-left-bg">
                                <div class="login-form-left">
                                    <div class="login-form-lefttitle">
                                        <h1>Welcome Back to {{ config('app.name') }}</h1>
                                    </div>
                                    <div class="login-form-left-image">
                                        <img src="/assets/images/Login.svg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="login-form-right">
                                    <div class="login-form-righttitle">
                                        <h1>Log in to your account</h1>
                                    </div>
                                    <div class="login-form-content loginpage-form-content">
                                        <form @submit.prevent="login()" id="loginForm">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="user-icon"><i class="fa-regular fa-user"></i></span>
                                                <input type="text" class="form-control login-form-control" v-model="username" name="username"
                                                    placeholder="Email Address" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="password" id="password" class="form-control login-form-control" name="password"
                                                    v-model="password" required
                                                    placeholder="Password">
                                                <span class="input-group-text eye-icon" @click="showPassword()"><i class="fa-regular fa-eye"></i></span>
                                            </div>
                                            <div class="checkbox-link-item">
                                                <div class="form-check">
                                                    <input class="form-check-input login-form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                    <label class="form-check-label login-form-rememberlabel" for="flexCheckDefault">
                                                        Remember Me
                                                    </label>
                                                </div>
                                                <div class="forgot-password-link">
                                                    <a href="/auth/forget-password">forgotten your password?</a>
                                                </div>
                                            </div>
                                            <div class="form-button">
                                                <button type="submit" class="btn login-btn">Login</button>
                                                <a href="{{ url('/auth/redirect/google') }}" class="btn googlelogin-btn"><span><i class="fa-brands fa-google"></i></span> Login with Google</a>
                                            </div>
                                        </form>
                                        <div class="register-link">
                                            <p>Don't have an account yet? <a href="/auth/register">Register here</a></p>
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
                    message: 'Hello Vue!',
                    api_url: '{{config('api.apiUrl')}}',
                    username: '',
                    password: ''
                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
            },
            methods: {
                login: function () {
                    const self = this;

                    axios.post('/auth/login',
                        {
                            username: self.username,
                            password: self.password,
                        }
                    )
                        .then(res => {
                            window.location = "{{session('rp') ?? '/home'}}"
                        })
                        .catch(err => {
                            console.log(err)
                            swal("Warning!", "Unknown login!", {
                                icon: 'error'
                            });
                        })
                },
                showPassword: function () {
                    var x = document.getElementById("password");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
            }
        }).mount('#app')

    </script>
@endpush
