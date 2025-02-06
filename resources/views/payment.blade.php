@extends('layouts.app')

@section('title') Checkout @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/checkoutprogressbar.css"/>
    <link rel="stylesheet" href="/assets/css/checkout.css"/>
    <link rel="stylesheet" href="/assets/css/payment.css"/>
@endpush
@section('content')

    <section class="payment-section">
        <div class="container">
            <div class="payment-all-content" v-if="cart.length">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-6">
                        <div class="payment-image">
                            <img src="/assets/images/payment.svg" alt="">
                        </div>
                    </div>
                    @php
                        $amount = number_format(session('order')->payable_amount ?? 0, 2)
                    @endphp
                    @if($amount > 0)
                        <div class="col-md-6 m-auto mt-5">
                            <div class="row mobile-col-reverse justify-content-center">
                                <div class="col-md-12 col-lg-10">
                                    <div class="payment-content">
                                        <div class="payment-details">
                                            <div class="payment-amount">
                                                <h3>Payment Amount</h3>
                                                <p>{{config('app.currency')}}{{ number_format(session('order')->payable_amount ?? 0, 2) }}</p>
                                            </div>
                                            <div class="payment-card-details">
                                                <form @submit.prevent="payment()" ref="form_payment_direct"
                                                      action="{{route('payment.cardstream.direct')}}" method="POST">
                                                    @csrf
                                                    <div class="cardholder-name">
                                                        <label>Cardholder's Name</label>
                                                        <input
                                                            type="text"
                                                            class="form-control payment-client-name" required
                                                            placeholder="Enter name here..." name="customerName"
                                                        />
                                                    </div>
                                                    <div class="cardholder-number">
                                                        <label>Credit or Debit Card</label>
                                                        <div class="cardnumber-input">
                                                            <div class="card-image">
                                                                <img :src="'/assets/images/cards/'+cardImage" alt=""
                                                                     id="cardImage">
                                                            </div>
                                                            <div class="number-input">
                                                                <input type="text" id="cardNumber"
                                                                       placeholder="0123 XXXX XXXX XXXX"
                                                                       name="cardNumber"
                                                                       class="form-control  payment-client-cardnumber"
                                                                       min="0" maxlength="23" value=""
                                                                       required="required"
                                                                       @keyup="check_card($event)"
                                                                >
                                                            </div>
                                                        </div>
                                                        <div class="card-validity-content">
                                                            <div class="number-validity">

                                                                <input
                                                                    type="text"
                                                                    class="form-control card-inputfield"
                                                                    placeholder="MM"
                                                                    name="cardExpiryMonth" ref="cardExpiryMonth"
                                                                    v-model="cardExpiryMonth"
                                                                    maxlength="2" max="31" min="1"
                                                                    required
                                                                />
                                                                <input
                                                                    type="text"
                                                                    class="form-control card-inputfield"
                                                                    placeholder="YY"
                                                                    name="cardExpiryYear" ref="cardExpiryYear"
                                                                    v-model="cardExpiryYear"
                                                                    maxlength="2" max="99" min="21"
                                                                    required
                                                                />
                                                                <input
                                                                    type="text"
                                                                    class="form-control card-inputfield"
                                                                    placeholder="CVC"
                                                                    id="cardCVV" ref="cardCVV" v-model="cardCVV"
                                                                    name="cardCVV"
                                                                    required
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="cardholder-name">
                                                        <label>Email</label>
                                                        <input
                                                            type="text"
                                                            class="form-control payment-client-name"
                                                            placeholder="Enter your email" name="customerEmail" required
                                                            {{--value="{{ session('guest')->email ?? session('user')->email ?? '' }}"--}}
                                                        />
                                                    </div>
                                                    <div class="cardholder-name">
                                                        <label>Phone</label>
                                                        <input
                                                            type="text"
                                                            class="form-control payment-client-name" required
                                                            placeholder="Enter phone number" name="customerPhone"
                                                            {{--value="{{ session('guest')->phone ?? session('user')->phone ?? '' }}"--}}
                                                        />
                                                    </div>

                                                    <div class="cardholder-address">
                                                        <label>Address</label>
                                                        <input
                                                            type="text"
                                                            class="form-control payment-client-address"
                                                            placeholder="Enter your address here"
                                                            id="address" name="address" required
                                                        />
                                                    </div>
                                                    <div class="cardholder-postcode">
                                                        <label>Postcode</label>
                                                        <input
                                                            type="text"
                                                            class="form-control payment-client-postcode" id="postcode"
                                                            name="postcode"
                                                            placeholder="Enter postcode here" required
                                                        />
                                                    </div>
                                                    <div class="payment-button">
                                                        <input type="hidden" name="payment">
                                                        <input type="hidden" id="amount" name="amount"
                                                               class="form-control"
                                                               value="{{ number_format(session('order')->payable_amount ?? 0, 2) }}">
                                                        <button type="submit" class="btn payment-btn"
                                                                :disabled="loading">
                                                            Payment
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="payment-cardimage text-center">
                                                <img src="assets/images/payment-logo/evo-secure.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="payment-all-content text-center" v-else>
                <img src="/assets/images/empty-cart.png" class="mb-4" alt="">

                <p class="text-center">Your cart is empty!
                    <a href="/"><u>Start shopping</u></a>
                </p>
            </div>

        </div>
    </section>
    <!-- Checkout All Content Section End  -->
@endsection

@push('script')
    <script>
        const {createApp} = Vue

        var app = createApp({
            data() {
                return {
                    message: 'Hello Vue!',

                    cart: JSON.parse(localStorage.getItem('cart')) || [],

                    order_id: '{{session('order_id') ?? null}}',
                    cardExpiryMonth: '',
                    cardExpiryYear: '',
                    cardCVV: '',
                    cardImage: 'no-card.png',

                    loading: false,
                }
            },
            async created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

                const self = this;

                if (await self.checkIfAnyItemPriceIsZero()) {
                    window.location = '/cart';
                }

                if (!self.order_id || !self.cart.length) {
                    //window.location = '/';
                }
            },
            methods: {
                payment: function () {
                    var self = this;
                    self.loading = true;

                    self.$refs.form_payment_direct.submit();
                },

                //Check Cardstream card
                check_card: function (event) {

                    var self = this;
                    var num = event.target.value;
                    var number = num.replace(/\s/g, '');

                    if (!number) {
                        self.cardImage = 'no-card.png';
                        return false;
                    }
                    self.cardImage = 'no-card.png';

                    // visa
                    var re = new RegExp("^4");
                    if (number.match(re) != null) {
                        self.cardImage = 'visa.png';
                    }

                    // Mastercard
                    // Updated for Mastercard 2017 BINs expansion
                    // if (/^(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}$/.test(number)){
                    //     self.cardImage = 'master.png';
                    // }
                    re = new RegExp("^5[1-5][0-9]");
                    if (number.match(re) != null) {
                        self.cardImage = 'master.png';
                    }

                    //maestro
                    re = new RegExp("^(5018|5020|5038|6304|6759|6761|6763)[0-9]{8,15}$");
                    if (number.match(re) != null) {
                        self.cardImage = 'maestro.png';
                    }

                    // AMEX
                    re = new RegExp("^3[47]");
                    if (number.match(re) != null) {
                        self.cardImage = 'AE.png';
                    }

                    // Discover
                    re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
                    if (number.match(re) != null) {
                        self.cardImage = 'discover.png';
                    }

                    // Diners
                    re = new RegExp("^36");
                    if (number.match(re) != null) {
                        self.cardImage = 'dinner.png';
                    }

                    // Diners - Carte Blanche
                    re = new RegExp("^30[0-5]");
                    if (number.match(re) != null) {
                        self.cardImage = 'dinner.png';
                    }

                    // JCB
                    re = new RegExp("^35(2[89]|[3-8][0-9])");
                    if (number.match(re) != null) {
                        self.cardImage = 'JCB.png';
                    }

                    // Visa Electron
                    re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
                    if (number.match(re) != null) {
                        self.cardImage = 'visa.png';
                    }

                },

                checkIfAnyItemPriceIsZero: function () {
                    const self = this;
                    var zero_exist = 0;
                    self.cart.forEach(function (val, index) {
                        if (parseFloat(val.total_price) <= 0) {
                            zero_exist++;
                        }
                    })
                    if (zero_exist > 0) {
                        return true
                    }
                    return false;
                },
            },
            watch: {
                cardExpiryMonth: function (val) {
                    var self = this;
                    if (val.length == 2) {
                        self.$refs.cardExpiryYear.focus()
                    }
                },
                cardExpiryYear: function (val) {
                    var self = this;
                    if (val.length == 2) {
                        self.$refs.cardCVV.focus()
                    }
                },
            },
            computed: {
                total_price: function () {
                    const self = this;
                    var total_price = 0;
                    self.cart.forEach(function (val) {
                        total_price += parseFloat(val.price);
                    })

                    return parseFloat(total_price.toFixed(2));
                }
            }
        }).mount('#app')

    </script>
@endpush
