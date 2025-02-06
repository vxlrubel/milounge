@extends('layouts.app')

@section('title') Reset Password @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/login.css"/>
    <link rel="stylesheet" href="/assets/css/forgetpassword.css"/>
@endpush
@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-lg-5 m-auto">
                    <div class="login-form text-center">
                        <div class="login-form-header">
                            <h1>Reset your password</h1>
                        </div>
                        <div class="login-form-content">
                            <form @submit.prevent="reset()">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" placeholder="Code" name="code" id="code"
                                        v-model="code" autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" placeholder="New password" name="password"
                                        id="password" v-model="password" autocomplete="off">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" placeholder="Confirm password"
                                        v-model="password_confirmation">
                                </div>
                                <div class="form-button">
                                    <input type="hidden" v-model="email">
                                    <button type="submit" class="btn login-btn">Reset Password</button>
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
                    email: '{{$email}}',
                    password: '',
                    password_confirmation: '',
                    code: '',
                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
            },
            methods: {
                reset: function () {
                    const self = this;

                    axios.post(self.api_url + '/auth/reset-password',
                        {
                            email: self.email,
                            code: self.code,
                            password: self.password,
                            password_confirmation: self.password_confirmation,
                        }
                    )
                        .then(res => {
                            swal("Success!", "Successfully reset!", {
                                icon: 'success'
                            });

                            window.location = "/auth/login";
                        })
                        .catch(err => {
                            var msg = err.response.data.message || 'Password is not changed!';
                            swal("Warning! "+msg , {
                                icon: 'error'
                            })
                        })
                }
            }
        }).mount('#app')

    </script>
@endpush

