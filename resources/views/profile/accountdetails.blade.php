@extends('layouts.app')

@section('title') Profile details @endsection

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
                        <div class="accountdetails-content">
                            <!-- Account Details Update Form -->
                            <div class="details-formcontent">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="profile-title">
                                            <h1><span><i class="fa-solid fa-pen-to-square"></i></span>Account Details</h1>
                                        </div>
                                    </div>
                                    <div class="col-md-11 m-auto">
                                        <div class="profile-form">
                                            <form action="{{route('profile-details-update')}}" method="POST">
                                                @csrf
                                                <div class="row accountdetails-row-alignment">
                                                    <div class="col-md-6 accountdetails-colalignment">
                                                        <label for="" class="acde-formlabel">First Name:</label>
                                                        <input type="text" class="form-control" placeholder="First Name"
                                                               v-model="first_name" name="first_name"/>
                                                    </div>
                                                    <div class="col-md-6 accountdetails-colalignment">
                                                        <label for="" class="acde-formlabel">Last Name:</label>
                                                        <input type="text" class="form-control" placeholder="Last Name"
                                                               v-model="last_name" name="last_name"/>
                                                    </div>
                                                </div>
                                                <div class="row accountdetails-row-alignment">
                                                    <div class="col-md-6 accountdetails-colalignment">
                                                        <label for="" class="acde-formlabel">Email:</label>
                                                        <input type="text" class="form-control" placeholder="Email Address"
                                                               v-model="email" name="email" readonly/>
                                                    </div>
                                                    <div class="col-md-6 accountdetails-colalignment">
                                                        <label for="" class="acde-formlabel">Phone:</label>
                                                        <input type="text" class="form-control" placeholder="Phone Number"
                                                               v-model="phone" name="phone"/>
                                                    </div>
                                                </div>
                                                {{--<div class="row accountdetails-row-alignment">
                                                    <div class="col-md-6 accountdetails-colalignment">
                                                        <label for="" class="acde-formlabel">Gender:</label>
                                                        <select class="form-select accountdetails-genderselect"
                                                                aria-label="Default select example" v-model="gender" name="gender">
                                                            <option selected value="">Gender</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 accountdetails-colalignment">
                                                        <label for="" class="acde-formlabel">Date Of Birth:</label>
                                                        <input type="date" class="form-control"
                                                               v-model="dob" name="dob"/>
                                                    </div>
                                                </div>--}}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="account-details-button">
                                                            <input type="submit" class="btn ac-btn" value="Update">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Delivery Address Table View -->
                            <div class="details-formcontent details-formcontent2" v-cloak>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="profile-title">
                                            <h1><span><i class="fa-solid fa-house"></i></span>Delivery Address</h1>
                                        </div>
                                    </div>
                                    <div class="col-md-11 m-auto">
                                        <div class="profile-form">
                                            <form  @submit.prevent="storeShippingAddress()">
                                                @csrf
                                                <div class="ad-content">
                                                    <div class="ad-details">
                                                        <div class="row row-alignment">
                                                            <div class="col-md-12">
                                                                <div class="shipping-item">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-2">
                                                                            <label for="" class="checkout-formlabel"
                                                                            >Postcode:</label>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6 col-md-5">
                                                                            <input
                                                                                type="text"
                                                                                class="form-control checkout-forminput"
                                                                                placeholder="Enter postcode"
                                                                                name="postcode"
                                                                                v-model="postcode"
                                                                                required
                                                                            />
                                                                        </div>
                                                                    </div>

                                                                    <div class="row" v-if="show_postcode_ul">
                                                                        <div class="col-md-2"></div>
                                                                        <div class="col-12 col-md-4">
                                                                            <ul class="postcode-list" id="postcodes"
                                                                                v-if="postcodes.length > 0"
                                                                                style="max-height: 150px; overflow-x: hidden;overflow-y: scroll; cursor: pointer">
                                                                                <li v-for="postcode in postcodes"
                                                                                    @click="getLocations(postcode)">@{{ postcode
                                                                                    }}
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row row-alignment" v-if="addresses.length">
                                                            <div class="col-md-12">
                                                                <div class="shipping-item">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-2">
                                                                            <label for="" class="checkout-formlabel"
                                                                            >Choose Address:</label
                                                                            >
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <select name="address" id="address"
                                                                                    v-model="address"
                                                                                    class="form-control checkout-forminput">
                                                                                <option value="">None</option>
                                                                                <option v-for="(val, index) in addresses"
                                                                                        :value="index">
                                                                                    @{{ val.building_name }}
                                                                                    @{{ val.building_number }}
                                                                                    @{{ val.thoroughfare }}
                                                                                    @{{ val.dependent_thoroughfare }}
                                                                                    @{{ val.posttown }}
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row row-alignment">
                                                            <div class="col-md-12">
                                                                <div class="shipping-item">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-2">
                                                                            <label for="" class="checkout-formlabel"
                                                                            >House:</label
                                                                            >
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <input
                                                                                type="text"
                                                                                class="form-control checkout-forminput"
                                                                                placeholder="Enter house"
                                                                                name="house"
                                                                                v-model="house"
                                                                                required
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row row-alignment">
                                                            <div class="col-md-12">
                                                                <div class="shipping-item">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-2">
                                                                            <label for="" class="checkout-formlabel"
                                                                            >Street:</label
                                                                            >
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <input
                                                                                type="text"
                                                                                class="form-control checkout-forminput"
                                                                                placeholder="Enter street"
                                                                                name="street"
                                                                                v-model="street"
                                                                                required
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row row-alignment">
                                                            <div class="col-md-12">
                                                                <div class="shipping-item">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-2">
                                                                            <label for=""
                                                                                   class="checkout-formlabel">City:</label>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <input
                                                                                type="text"
                                                                                class="form-control checkout-forminput"
                                                                                placeholder="Enter city"
                                                                                name="city"
                                                                                v-model="town"
                                                                                required
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="account-details-button">
                                                        <input type="submit" class="btn ac-btn" value="Save">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-11 m-auto pb-4">
                                        <div class="deliveryaddress-tablecontent">
                                            <div class="deliveryaddress-showtable table-largedevice">
                                                <table class="table text-center table-responsive ad-table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Address</th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="val in shipping_addresses">
                                                        <td>@{{ val.name }}</td>
                                                        <td>
                                                            <p class="">
                                                                <span>@{{ val.prop.house }}</span>
                                                                <span
                                                                    v-if="val.prop.state">, @{{ val.prop.state }}</span>
                                                                <span v-if="val.prop.town">, @{{ val.prop.town }}</span>
                                                                <span v-if="val.prop.postcode">, @{{ val.prop.postcode }}</span>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <div class="largetable-actionoption">
                                                                {{-- <a href="javascript:void(0)"
                                                                   data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                                    <div class="largetable-actionbutton">
                                                                        <i class="fa fa-pen"></i>
                                                                    </div>
                                                                </a> --}}
                                                                <a href="javascript:void(0)"
                                                                   @click="editAddress(val)">
                                                                    <div class="largetable-actionbutton">
                                                                        <i class="fa fa-pen"></i>
                                                                    </div>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                   @click="removeAddress(val)">
                                                                    <div class="largetable-actionbutton ms-2 largedelete-icon">
                                                                        <i class="fa fa-trash-alt"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="deliveryaddress-mobiledevice">
                                            <div class="da-mobile-content" v-for="val in shipping_addresses">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h6><span><i class="fa-solid fa-truck-fast"></i></span> @{{ val.name }}</h6>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <a href="javascript:void(0)"
                                                        @click="editAddress(val)">
                                                         <div class="mobile-actionbutton">
                                                             <i class="fa fa-pen"></i>
                                                         </div>
                                                     </a>
                                                     <a href="javascript:void(0)"
                                                        @click="removeAddress(val)">
                                                         <div class="mobile-actionbutton ms-2 mobiledelete-icon">
                                                             <i class="fa fa-trash-alt"></i>
                                                         </div>
                                                     </a>
                                                    </div>
                                                </div>
                                                <p>
                                                    <span>@{{ val.prop.house }}</span>
                                                    <span
                                                        v-if="val.prop.state">, @{{ val.prop.state }}</span>
                                                    <span v-if="val.prop.town">, @{{ val.prop.town }}</span>
                                                    <span v-if="val.prop.postcode">, @{{ val.prop.postcode }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="changeProfileImage" tabindex="-1" aria-labelledby="profileImage-popup"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{route('profile-upload-picture')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title profileimage-popuptitle" id="profileImage-popup">Change your
                                    Profile Image</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 m-auto">
                                        <div class="current-profileimage">
                                            @if(session('user')->property->profile_image ?? null)
                                                <img src="{{config('api.apiUrl')}}/user/profile-image?_token={{session('api_token')}}" alt="" id="profile_image">
                                            @elseif(session('user')->property->avatar ?? null)
                                                <img src="{{session('user')->property->avatar}}" alt="">
                                            @else
                                                <img src="/assets/images/profile-image/profile.png" alt="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-10 m-auto">
                                        <div class="upload-profileimage">
                                            <input type="file" class="form-control" name="file" accept="image/*" id="picture">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn pass-editbtn">Upload Image</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModal"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title profileimage-popuptitle" id="profileImage-popup">Edit
                                Address</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="updateShippingAddress()" id="formAddress">
                                @csrf
                                <div class="ad-content">
                                    <div class="ad-details">
                                        <div class="row row-alignment">
                                            <div class="col-md-12">
                                                <div class="shipping-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2">
                                                            <label for="" class="checkout-formlabel"
                                                            >Postcode:</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input
                                                                type="text"
                                                                class="form-control checkout-forminput"
                                                                placeholder="Enter postcode"
                                                                name="postcode"
                                                                v-model="edit.postcode"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-alignment">
                                            <div class="col-md-12">
                                                <div class="shipping-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2">
                                                            <label for="" class="checkout-formlabel"
                                                            >House:</label
                                                            >
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input
                                                                type="text"
                                                                class="form-control checkout-forminput"
                                                                placeholder="Enter house"
                                                                name="house"
                                                                v-model="edit.house"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-alignment">
                                            <div class="col-md-12">
                                                <div class="shipping-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2">
                                                            <label for="" class="checkout-formlabel"
                                                            >Street:</label
                                                            >
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input
                                                                type="text"
                                                                class="form-control checkout-forminput"
                                                                placeholder="Enter street"
                                                                name="street"
                                                                v-model="edit.street"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-alignment">
                                            <div class="col-md-12">
                                                <div class="shipping-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2">
                                                            <label for=""
                                                                   class="checkout-formlabel">City:</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input
                                                                type="text"
                                                                class="form-control checkout-forminput"
                                                                placeholder="Enter city"
                                                                name="city"
                                                                v-model="edit.town"
                                                                required
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="account-details-button">
                                        <button type="submit" class="btn ac-btn">Update</button>
                                    </div>
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
                    api_url: '{{config('api.apiUrl')}}',
                    postcode_api_url: '{{config('api.postcodeApiUrl')}}',
                    headers: {
                        "Authorization": "Bearer {{session('api_token')}}"
                    },

                    user_id: '{{session('user')->id ?? ""}}',
                    first_name: '{{session('user')->property->first_name ?? ""}}',
                    last_name: '{{session('user')->property->last_name ?? ""}}',
                    email: '{{session('user')->email ?? ""}}',
                    username: '{{session('user')->username ?? ""}}',
                    phone: '{{session('user')->phone ?? ""}}',
                    // gender: '{{session('user')->property->gender ?? ""}}',
                    // dob: '{{session('user')->property->dob ?? ""}}',

                    shipping_addresses: [],

                    postcode: '',
                    house: '',
                    town: '',
                    street: '',
                    country: 'United Kingdom',

                    edit: {
                        address_id: '',
                        postcode: '',
                        house: '',
                        town: '',
                        street: '',
                        country: 'United Kingdom',
                    },

                    address: '',
                    postcodes: [],
                    addresses: [],
                    show_postcode_ul: false,

                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

                const self = this;
                self.getShippingAddress();
            },
            methods: {
                getShippingAddress: function () {
                    const self = this;
                    axios.get(self.api_url + '/user/shipping-address', {
                        headers: self.headers
                    })
                        .then(res => {
                            self.shipping_addresses = res.data;
                        })
                },
                storeShippingAddress: function () {
                    const self = this;
                    axios.post(self.api_url + '/user/shipping-address', {
                        name: 'Shipping address',
                        type: 'SHIPPING',
                        house: self.house,
                        postcode: self.postcode,
                        town: self.town,
                        state: self.street,
                        country: self.country,

                    }, {
                        headers: self.headers
                    })
                        .then(res => {
                            swal('Success! Address is saved', {
                                icon: 'success'
                            })

                            self.getShippingAddress();
                        })
                },
                removeAddress: function (address) {
                    const self = this;

                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this imaginary file!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                axios.delete(self.api_url + '/user/shipping-address/' + address.id, {
                                    headers: self.headers
                                })
                                    .then(res => {
                                        swal('Success! Address is deleted', {
                                            icon: 'success'
                                        })
                                        self.getShippingAddress();
                                    })
                            }
                        });


                },
                editAddress: function (address) {
                    const self = this;
                    self.edit.address_id = address.id
                    self.edit.postcode = address.prop?.postcode
                    self.edit.house = address.prop?.house
                    self.edit.town = address.prop?.town
                    self.edit.street = address.prop?.state
                    self.edit.country = address.prop?.country
                    $("#editAddressModal").modal('show')
                },
                updateShippingAddress: function () {
                    const self = this;

                    axios.patch(self.api_url + '/user/shipping-address/' + self.edit.address_id, {
                        house: self.edit.house,
                        postcode: self.edit.postcode,
                        town: self.edit.town,
                        state: self.edit.street,
                        country: self.edit.country,
                    }, {
                        headers: self.headers
                    })
                        .then(res => {
                            swal('Success! Address is updated', {
                                icon: 'success'
                            })

                            self.getShippingAddress();
                        })
                },

                updateDetails: function () {
                    const self = this;

                    axios.patch(self.api_url + '/user/' + self.user_id, {
                        first_name: self.first_name,
                        last_name: self.last_name,
                        phone: self.phone,
                        // gender: self.gender,
                        // dob: self.dob,
                    }, {
                        headers: self.headers
                    })
                        .then(res => {
                            swal('Success! Information is updated', {
                                icon: 'success'
                            })
                        })
                },

                // Postcode
                getPostcodes: function () {
                    const self = this;
                    self.postcodes = [];
                    self.show_postcode_ul = false;
                    var postcode = self.postcode;
                    if (self.postcode.length < 3) {
                        return false;
                    }
                    if (self.postcode.length > 3) {
                        postcode = self.postcode.replace(/(\S*)\s*(\d)/, "$1 $2");
                    }

                    // axios.get('https://priapi.yuma-technology.co.uk:9012/delivery/connector/postal_code/' + postcode, {
                    //     headers: {
                    //         'Access-Control-Allow-Origin': '*',
                    //     }
                    // })
                    //     .then(res => {
                    //         self.postcodes = res.data;
                    //         self.show_postcode_ul = true;
                    //     })

                    $.ajax({
                        url: self.postcode_api_url + "/postal-code/" + postcode,
                        type: "GET",
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Access-Control-Allow-Origin', '*')
                        },
                        success: function (res) {
                            self.postcodes = res;
                            self.show_postcode_ul = true;
                        }
                    });


                },
                getLocations: function (postcode) {
                    const self = this;
                    self.show_postcode_ul = false;
                    self.postcode = postcode;

                    $.ajax({
                        url: self.postcode_api_url + "/postal-code-data/" + postcode,
                        type: "GET",
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Access-Control-Allow-Origin', '*')
                        },
                        success: function (res) {
                            self.addresses = res;
                            self.address = 0;
                        }
                    });

                },
            },
            watch: {
                address: function (index) {
                    var self = this;
                    self.house = self.addresses[index].building_number + ' ' + self.addresses[index].building_name;
                    self.street = self.addresses[index].thoroughfare;
                    self.town = self.addresses[index].posttown;

                },
                shipping_address: function (val) {
                    var self = this;
                    self.postcode = '';
                    self.house = '';
                    self.town = '';
                    self.street = '';
                },
                postcode: function (val) {
                    var self = this;
                    self.getPostcodes();
                }
            }
        }).mount('#app')

    </script>
@endpush
