@extends('layouts.app')

@section('title') Forget Password @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/login.css"/>
    <link rel="stylesheet" href="/assets/css/forgetpassword.css"/>
@endpush
@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-5 m-auto">
                    <div class="login-form">
                        <div class="login-form-header">
                            <h1>Forget your password</h1>
                        </div>
                        <div class="login-form-content">
                            <form @submit.prevent="send">
                                @csrf
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="user-icon"><i class="fa-regular fa-user"></i></span>
                                    <input type="email" class="form-control" v-model="email" name="email" id="email"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-button">
                                    <button type="submit" class="btn login-btn">Send</button>
                                </div>
                            </form>
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
                    email: '',
                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
            },
            methods: {
                send: function () {
                    const self = this;

                    axios.post(self.api_url + '/auth/forget-password',
                        {
                            email: self.email,
                        }
                    )
                        .then(res => {
                            window.location = "/auth/reset-password?email="+self.email
                        })
                        .catch(err => {
                            swal("Warning!", "Unknown error!", {
                                icon: 'error'
                            });
                        })
                }
            }
        }).mount('#app')

    </script>
@endpush
