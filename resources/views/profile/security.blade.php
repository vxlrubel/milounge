@extends('layouts.app')

@section('title') My Orders @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/consumerdashboard.css"/>
@endpush
@section('content')
    <section class="consumerdashboard-section">
        <div class="container">
            <div class="consumerdashboard-content">
                <div class="row mt-3 mb-3">
                    <div class="col-md-4 col-lg-3">
                        @include('profile.component.sidebar')
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="accountdetails-content accountsecurity-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-title">
                                        <h1><span><i class="fa-solid fa-lock"></i></span>Security Option</h1>
                                    </div>
                                </div>
                                <div class="col-md-12 m-auto">
                                    <div class="consumeraccount-securitycontent">
                                        @can('is-google-user')
                                            <p>
                                                <em>You are authenticated by Google</em>
                                            </p>
                                        @else

                                            <div class="row">
                                                <div class="col-6 col-sm-6 col-md-6">
                                                    <div class="password-title">
                                                        <label for="">Password:</label>
                                                        <p>********</p>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-6 col-md-6">
                                                    <div class="password-edit-button">
                                                        <button class="btn pass-editbtn" onclick="passwordedit()">Edit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="securityupdate-form" id="securityUpdate_form">

                                                <form @submit.prevent="changePassword()">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control csform-inputfield"
                                                               name="old_password" v-model="old_password"
                                                               placeholder="Old Password">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control csform-inputfield"
                                                               name="password" v-model="password"
                                                               placeholder="New Password">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control csform-inputfield"
                                                               name="password_confirmation"
                                                               v-model="password_confirmation"
                                                               placeholder="Confirm Password">
                                                    </div>
                                                    <div class="pass-update-button">
                                                        <button type="submit" class="btn pass-editbtn">Update</button>
                                                    </div>
                                                </form>
                                                <div class="ad-divider"></div>
                                            </div>

                                        @endcan

                                        <div class="account-disable-content">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="disable-title">
                                                        <label for="">Disable Account:</label>
                                                        <p>Permanently Disable Your {{config('app.name')}} Account</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6">
                                                    <div class="password-edit-button">
                                                        <a href="#" class="btn acc-disablebtn">Disable</a>
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
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        function passwordedit() {
            var openform = document.getElementById('securityUpdate_form');
            openform.classList.toggle('securityupdate-form-open');
        }
    </script>
    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    api_url: '{{config('api.apiUrl')}}',
                    headers: {
                        "Authorization": "Bearer {{session('api_token')}}"
                    },
                    old_password: '',
                    password: '',
                    password_confirmation: '',
                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
            },
            methods: {
                changePassword: function () {
                    const self = this;

                    axios.post(self.api_url + '/change-password', {
                        old_password: self.old_password,
                        password: self.password,
                        password_confirmation: self.password_confirmation,
                    }, {
                        headers: self.headers
                    })
                        .then(res => {
                            swal("Success! Password Changed successfully", {
                                icon: 'success'
                            })
                            self.old_password = '';
                            self.password = '';
                        }).catch(err => {
                        var msg = err.response.data.message || 'Password is not changed!';
                        swal("Warning! " + msg, {
                            icon: 'error'
                        })
                    })
                }
            }
        }).mount('#app')

    </script>
@endpush
