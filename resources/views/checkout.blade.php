@extends('layouts.app')

@section('title')
    Checkout
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/checkoutprogressbar.css"/>
    <link rel="stylesheet" href="/assets/css/checkout.css"/>
    <link rel="stylesheet" href="/assets/css/cart.css"/>
@endpush
@section('content')

    <section class="checkout-section" id="checkoutAllContent">
        <div class="container" v-cloak>
            <div class="checkout-all-content" v-if="cart.length">
                <div class="row checkout-large-device">
                    <div class="col-md-12 m-auto">
                        <div class="text-center header-branchname checkoutheader-branchname">
                            <h5><span><i class="fa-solid fa-location-dot"></i></span>Shop:
                                {{\App\Services\BranchService::currentName(\App\Services\BranchService::current())}}
                                <a href="#" @click="openBranchModal()"
                                   class="ms-2 btn mainbtn-primary login-btn checkout-changebtn btn-sm"
                                   style="font-size: 14px">Change Shop</a>
                            </h5>
                        </div>
                    </div>
                </div>

                <form action="{{route('checkout')}}" @submit.prevent="submit()" method="POST" id="formCheckout">
                    @csrf
                    <div class="row mobile-col-reverse">
                        <div class="col-md-12 col-lg-8">
                            <!-- <div class="back-return-button">
                                <a href="/menu" class="btn mainbtn-primary backreturn-btn"><span><i
                                            class="fa-solid fa-arrow-left"></i></span> Return to Menu</a>
                            </div> -->
                            <!-- Shipping Address -->
                            <div class="shipping-content" id="shipping-content">

                                <div class="shipping-title">
                                    <h3>
                                        <span><i class="fa-solid fa-house"></i></span> Checkout Information
                                    </h3>
                                </div>
                                <div class="shipping-details">
                                    {{--Order Info--}}
                                    <div class="row row-alignment" id="checkout-info">
                                        <div class="col-md-12">
                                            @if(!session('user'))
                                                <div class="mb-2">
                                                    <b class="guest-title">Guest Checkout</b> or <a
                                                        href="/auth/login?rp=/checkout" class="guest-loginlink"><u>I
                                                            have an account</u></a>
                                                </div>
                                            @endif
                                            <div class="checkouttitle">
                                                <h1><span><i class="fa-solid fa-user"></i></span> @if(!session('user'))
                                                        Guest
                                                    @else
                                                        Quick
                                                    @endif Checkout</h1>
                                            </div>

                                            <div class="customer-info">
                                                <div class="shipping-item">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-alignment">
                                                                <label for="payment_type"
                                                                       class="checkout-formlabel shipping-pd-label">Payment
                                                                    Type <span class="text-danger">*</span></label>
                                                                {{--<select
                                                                    class="form-select checkout-forminput checkout-selectOption"
                                                                    aria-label="" name="payment_type"
                                                                    v-model="payment_type"
                                                                    required
                                                                >
                                                                    <option value="">- Select -</option>
                                                                    <option value="CASH">Cash</option>
                                                                    <option value="CARD">Card</option>
                                                                </select>--}}

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="radio" v-model="payment_type"
                                                                               class="btn-check" name="payment_type"
                                                                               id="cash" value="CASH">
                                                                        <label class="btn btn-outline-dark me-2"
                                                                               for="cash"><i
                                                                                class="fa fa-money-bill-wave-alt"></i>
                                                                            Cash</label>

                                                                        <input type="radio" v-model="payment_type"
                                                                               class="btn-check" name="payment_type"
                                                                               id="card" value="CARD">
                                                                        <label class="btn btn-outline-dark"
                                                                               for="card"><i
                                                                                class="fa fa-credit-card"></i>
                                                                            Card</label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="col-alignment">
                                                                <label class="checkout-formlabel shipping-pd-label">
                                                                    Order Type
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input v-show="active_collection" type="radio"
                                                                               v-model="order_type" class="btn-check"
                                                                               name="order_type" id="COLLECTION"
                                                                               value="COLLECTION">
                                                                        <label v-show="active_collection"
                                                                               class="btn btn-outline-dark me-2"
                                                                               for="COLLECTION">Collection</label>

                                                                        <input v-show="active_delivery" type="radio"
                                                                               v-model="order_type" class="btn-check"
                                                                               name="order_type" id="DELIVERY"
                                                                               value="DELIVERY">
                                                                        <label v-show="active_delivery"
                                                                               class="btn btn-outline-dark"
                                                                               for="DELIVERY">Delivery</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="shipping-item">
                                                    <div class="row">
                                                        <div class="col-6 col-md-4">
                                                            <div class="col-alignment">
                                                                <label for=""
                                                                       class="checkout-formlabel shipping-pd-label">@{{
                                                                    order_type.toLowerCase() }} Hour <span
                                                                        class="text-danger">*</span></label>
                                                                <select
                                                                    class="form-select"
                                                                    name="requested_hour"
                                                                    v-model="requested_hour"
                                                                >
                                                                    <option value="">- Select -</option>
                                                                    <option value="ASAP">--- ASAP ---</option>
                                                                    <option v-for="val in filtered_requested_hours"
                                                                            :value="val">
                                                                        @{{ val }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-4">
                                                            <div class="col-alignment"
                                                                 v-if="requested_hour && requested_hour !== 'ASAP'">
                                                                <label for=""
                                                                       class="checkout-formlabel shipping-pd-label">Minutes</label>
                                                                <select
                                                                    class="form-select checkout-forminput checkout-selectOption"
                                                                    aria-label="" name="requested_minute"
                                                                    v-model="requested_minute"
                                                                    required
                                                                >
                                                                    <option v-for="val in requested_minutes"
                                                                            :value="val">@{{ val }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <p v-if="available_requested_time" class="text-uppercase">
                                                                Estimated @{{ order_type }} Time: @{{ timeFormat(available_requested_time, 'HH:mm') }}
                                                            </p>
                                                            <p v-else class="text-uppercase text-danger">
                                                                <span v-if="available_requested_time === ''"></span>
                                                                <span v-else>
                                                                    You cannot place for this time. Please choose different time slot.
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class=""
                                                 v-if="order_type === 'DELIVERY' && parseFloat(gs['minimum_amount_for_delivery'] ?? 0) > 0">
                                                <span><i class="fa fa-info-circle"></i></span> Minimum amount for
                                                delivery is {{config('app.currency')}}@{{
                                                parseFloat(gs['minimum_amount_for_delivery'] ?? 0).toFixed(2) }}
                                            </div>

                                        </div>
                                    </div>

                                    {{--Delivery Address--}}
                                    <div class="row row-alignment" v-if="order_type === 'DELIVERY'">
                                        <div class="col-md-12">
                                            <div class="checkouttitle">
                                                <h1><span><i class="fa-solid fa-user"></i></span> Delivery Address </h1>
                                            </div>
                                            <div class="customer-info">

                                                <div class="shipping-item" v-show="user">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-3">
                                                            <label for="" class="checkout-formlabel"
                                                            >Select address:</label
                                                            >
                                                        </div>
                                                        <div class="col-md-6 col-lg-5">
                                                            <select
                                                                class="form-select checkout-forminput checkout-selectOption"
                                                                aria-label="" name="shipping_address"
                                                                v-model="shipping_address"
                                                                required
                                                            >
                                                                <option value="NEW">New address</option>
                                                                <option v-for="val in shipping_addresses"
                                                                        :value="val.id">
                                                                    @{{ val.prop.house }}, @{{ val.prop.state
                                                                    }}, @{{
                                                                    val.prop.town }} @{{ val.prop.postcode }}
                                                                </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="row row-alignment">
                                                        <div class="col-md-12">
                                                            <div class="shipping-item">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-3">
                                                                        <label for="" class="checkout-formlabel"
                                                                        >Postcode:</label
                                                                        >
                                                                    </div>
                                                                    <div class="col-12 col-md-4">
                                                                        <input
                                                                            type="text"
                                                                            class="form-control checkout-forminput"
                                                                            name="postcode"
                                                                            v-model="postcode"
                                                                            list="postcodes"
                                                                            required
                                                                        />
                                                                    </div>

                                                                </div>

                                                                <div class="row" v-if="show_postcode_ul">
                                                                    <div class="col-md-3"></div>
                                                                    <div class="col-12 col-md-4">
                                                                        <ul class="postcode-list" id="postcodes"
                                                                            v-if="postcodes.length > 0"
                                                                            style="max-height: 150px; overflow-x: hidden;overflow-y: scroll; cursor: pointer; list-style: square; background-color: #FF9900; color: #ffffff">
                                                                            <li v-for="postcode in postcodes"
                                                                                @click="getLocations(postcode)">@{{
                                                                                postcode }}
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row row-alignment"
                                                         v-if="shipping_address === 'NEW' && addresses.length">
                                                        <div class="col-md-12">
                                                            <div class="shipping-item">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-3">
                                                                        <label for="" class="checkout-formlabel"
                                                                        >Choose Address:</label
                                                                        >
                                                                    </div>
                                                                    <div class="col-md-9">
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
                                                                    <div class="col-md-3">
                                                                        <label for="" class="checkout-formlabel"
                                                                        >House:</label
                                                                        >
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input
                                                                            type="text"
                                                                            class="form-control checkout-forminput"
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
                                                                    <div class="col-md-3">
                                                                        <label for="" class="checkout-formlabel"
                                                                        >Street:</label
                                                                        >
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input
                                                                            type="text"
                                                                            class="form-control checkout-forminput"
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
                                                                    <div class="col-md-3">
                                                                        <label for=""
                                                                               class="checkout-formlabel">City:</label>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input
                                                                            type="text"
                                                                            class="form-control checkout-forminput"
                                                                            name="city"
                                                                            v-model="town"
                                                                            required
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{--This confirm address will be available when orhe delivery charge will be calculated by DISTANCE--}}
                                                    <div class="row row-alignment"
                                                         v-if="['DISTANCE', 'PER_MILE'].includes(gs?.delivery_charge_type)">
                                                        <div class="col-md-12">
                                                            <div class="shipping-item">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-3"></div>
                                                                    <div class="col-md-9">
                                                                        <button v-if="postcode" type="button"
                                                                                @click="confirm_address()"
                                                                                class="btn checkout-btn"><i
                                                                                class="fa fa-check"></i>
                                                                            @{{ address_confirmed ? 'Re Confirm' :
                                                                            'Confirm Address' }}
                                                                        </button>

                                                                        <button type="button" v-if="address_confirmed"
                                                                                disabled="disabled"
                                                                                class="btn checkout-btn border-0"><i
                                                                                class="fa fa-check"></i> Confirmed
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--Customer info--}}
                                    <div class="row row-alignment" id="customer-info">
                                        <div class="col-md-12">
                                            <div class="checkouttitle">
                                                <h1><span><i class="fa-solid fa-user"></i></span> Customer info </h1>
                                            </div>
                                            <div class="customer-info">
                                                <div class="shipping-item">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-alignment">
                                                                <label for=""
                                                                       class="checkout-formlabel shipping-pd-label">First
                                                                    Name <span class="text-danger">*</span></label>
                                                                <input
                                                                    type="text"
                                                                    class="form-control checkout-forminput"
                                                                    name="first_name"
                                                                    v-model="first_name"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="col-alignment">
                                                                <label for=""
                                                                       class="checkout-formlabel shipping-pd-label">Last
                                                                    Name <span class="text-danger">*</span></label>
                                                                <input
                                                                    type="text"
                                                                    class="form-control checkout-forminput"
                                                                    name="last_name"
                                                                    v-model="last_name"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="shipping-item">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="col-alignment">
                                                                <label for=""
                                                                       class="checkout-formlabel shipping-pd-label">Phone
                                                                    <span class="text-danger">*</span></label>
                                                                <input
                                                                    type="text"
                                                                    class="form-control checkout-forminput"
                                                                    name="phone"
                                                                    v-model="phone"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="">
                                                                <label for=""
                                                                       class="checkout-formlabel shipping-pd-label">Email
                                                                    <span class="text-danger">*</span></label>
                                                                <input
                                                                    type="email"
                                                                    class="form-control checkout-forminput"
                                                                    name="email"
                                                                    v-model="email"
                                                                    @if(session('user')) readonly @endif
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7 col-lg-6 ms-auto checkoutBtn-alignment">
                                            <div class="shipping-checkout-button">
                                                <input type="hidden" name="cart" v-model="cart_stringify">
                                                <input type="hidden" name="delivery_charge" v-model="delivery_charge">
                                                <input type="hidden" name="discount_amount" v-model="discount_amount">
                                                <input type="hidden" name="service_charge" :value="service_charge">
                                                <input type="hidden" name="requested_timestamp" :value="available_requested_time">
                                                <input type="hidden" name="discount_product"
                                                       :value="applied_discount_product?.id">
                                                <input type="hidden" name="full_cart_comment"
                                                       :value="full_cart_comment">
                                                <button type="submit"
                                                        class="btn checkout-btn checkout-confirm-btn-large"
                                                        :disabled="loading || !available_requested_time">
                                                    <span class="checkoutbtn-icon1"><i
                                                            class="fa-solid fa-lock"></i></span>
                                                    @{{ loading ? 'Processing...' : 'Process' }} @{{ branch_name }}
                                                    <span class="checkoutbtn-icon2"><i
                                                            class="fa-solid fa-angle-right"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 col-lg-4">

                            <div class="orderitemsummary-detailshold">

                                <div class="ordersummary-headtitle">
                                    <h6>Cart</h6>
                                    <div><a href="/cart">Edit Cart</a></div>

                                </div>

                                <div class="checkout-cart-item">

                                    @if(config('app.env') === 'local')
                                        <div class="text-center m-1">
                                            <span class="badge bg-secondary">
                                                <small>expire at @{{ cart_expire_at }}</small>
                                            </span>
                                        </div>
                                    @endif

                                    <div class="cart-busket-item" v-for="(val, index) in cart">
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="cb-item-name">
                                                    <h6>@{{ val.unit }} x @{{ val.product?.short_name }}</h6>
                                                    <div>
                                                        <p v-if="val.selected_components_N.length"
                                                           v-for="component in val.selected_components_N">
                                                            <small>- @{{ component.short_name }} x @{{ component.unit
                                                                }}</small>
                                                            <small v-if="component.sub_components[0]?.uuid">
                                                                (@{{ component.sub_components[0].short_name ||
                                                                '' }})
                                                            </small>
                                                        </p>

                                                        <p v-if="val.selected_components.length"
                                                           v-for="component in val.selected_components">
                                                            <small
                                                                v-show="!['None', 'Normal'].includes(component.short_name)">-
                                                                @{{ component.short_name }}
                                                            </small>

                                                            <br>
                                                            <small v-if="component?.selected_sub_components">
                                                                <small
                                                                    v-for="sub_component in component.selected_sub_components">
                                                                    &nbsp; - @{{ sub_component.short_name || '' }} <br>
                                                                </small>
                                                            </small>
                                                            <small v-if="component?.selected_sub_components_N">
                                                                <small v-for="n in component.selected_sub_components_N">&nbsp;
                                                                    - @{{ n.unit }} x @{{ n.short_name }}
                                                                    <br>
                                                                </small>
                                                            </small>

                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="cb-productitem-comment">
                                                    <input type="text" class="form-control cb-control-form"
                                                           :value="val.comment"
                                                           @keyup="updateCartComment(index, $event.target.value)"
                                                           placeholder="Enter comment(if any)">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="cb-product-action">

                                                    <div class="cart-product-quantity">
                                                        <button type="button" class="btn quantitybtn"
                                                                @click="updateQty('DECREASE', index)"><i
                                                                class="fa-solid fa-minus"></i></button>
                                                        <input type="number" placeholder="0" min="1"
                                                               class="form-control quantityinput"
                                                               :value="val.unit">
                                                        <button type="button" class="btn quantitybtn"
                                                                @click="updateQty('INCREASE', index)"><i
                                                                class="fa-solid fa-plus"></i></button>
                                                    </div>

                                                    <div class="cb-product-price">
                                                        {{config('app.currency')}}@{{ val.total_price || 0.00 }}
                                                    </div>

                                                    <div class="cb-p-action">
                                                        <a @click.prevent="removeCartItem(index)"><span><i
                                                                    class="fa-solid fa-trash"></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cart-busket-checkoutitem">
                                        <div class="row">
                                            <div class="col-12 col-md-12">
                                                <div class="busket-product-commentbox">
                                                    <label><span><i class="fa-solid fa-comment"></i></span>
                                                        Comment</label>
                                                    <textarea name="" id="" cols="30" rows="3"
                                                              class="form-control comment-textarea-formcontrol"
                                                              placeholder="Write your comment here (if any)"
                                                              v-model="full_cart_comment">@{{ full_cart_comment }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="checkoutorder-summary">
                                <div class="ordersummary-headtitle add-coupon-header">
                                    <h6>Add Code</h6>
                                </div>
                                <div class="ordersummary-details">
                                    <div class="p-2">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control coupon-input"
                                                   placeholder="Enter coupon code"
                                                   aria-describedby="button-addon2" v-model="coupon_code">
                                            <button class="btn couponbtn" type="button"
                                                    @click.prevent="apply_coupon_code()">Apply
                                            </button>
                                        </div>

                                        <div
                                            v-if="applied_discount_product && applied_discount_product.property?.is_coupon=== 'TRUE'">
                                            <span class="badge bg-success">@{{ applied_discount_product.short_name }}
                                                <a href="#" class="text-white" @click.prevent="dismissCouponCode()"><i
                                                        class="fa fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="checkoutorder-summary checkoutorder-summary-details">
                                <div class="ordersummary-details">
                                    <div class="chkoutordersummary-content">
                                        <div class="ordersummary-title">
                                            <h6>Subtotal</h6>
                                        </div>
                                        <div class="ordersummary-price">
                                            <p>{{config('app.currency')}}@{{ cart_total.toFixed(2) }}</p>
                                        </div>
                                    </div>
                                    <div class="chkoutordersummary-content">
                                        <div class="ordersummary-title">
                                            <h6>Delivery Charge</h6>
                                            <small v-if="postcode_distance > 0">
                                                @{{ postcode_distance }} miles
                                            </small>
                                        </div>
                                        <div class="ordersummary-price">
                                            <p>{{config('app.currency')}}@{{ delivery_charge }}</p>
                                        </div>
                                    </div>
                                    <div class="chkoutordersummary-content" v-if="gs?.active_service_charge === 'TRUE'">
                                        <div class="ordersummary-title">
                                            <h6>Service Charge</h6>
                                        </div>
                                        <div class="ordersummary-price">
                                            <p>{{config('app.currency')}}@{{ service_charge || 0.00 }}</p>
                                        </div>
                                    </div>
                                    <div class="chkoutordersummary-content">
                                        <div class="ordersummary-title">
                                            <h6>Discount</h6>
                                            <small v-if="applied_discount_product">
                                                @{{ applied_discount_product.description }}
                                            </small>
                                        </div>
                                        <div class="ordersummary-price">
                                            <p>{{config('app.currency')}}@{{ discount_amount }}</p>
                                        </div>
                                    </div>
                                    <div class="chkoutordersummary-content chkoutordersummary-totalcontent">
                                        <div class="ordersummary-title ordersummary-total">
                                            <h6>Total</h6>
                                        </div>
                                        <div class="ordersummary-price ordersummary-totalprice">
                                            <p>{{config('app.currency')}}@{{ net_total }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row proceed-button-mobile">
                        <div class="col-12">
                            <div class="proceed-button">
                                <div class="process-button-hold">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <a href="/menu" class="btn backreturn-btn"><span><i
                                                        class="fa-solid fa-arrow-left"></i></span> Return Menu</a>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn checkoutprocess-btn" :disabled="loading">
                                                <span>@{{ loading ? 'Processing...' : 'Process' }}</span>
                                                {{config('app.currency')}}@{{ net_total }}
                                                <span class="checkoutprocess-arrow">
                                                    <i class="fa-solid fa-arrow-right"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mobile-separator"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div class="checkout-all-content text-center" v-else>
                <img src="/assets/images/empty-cart.png" class="mb-4" alt="">

                <p class="text-center">Your cart is empty!
                    <a href="/"><u>Start shopping</u></a>
                </p>
            </div>
        </div>
    </section>

    <!-- Location Modal -->
    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header location-modal-header">
                    <h1 class="modal-title location-modal-title" id="locationModalLabel">{{config('app.name')}}</h1>
                </div>
                <div class="modal-body location-modal-body">
                    <div class="location-body-content">
                        <div class="row">
                            <div class="col-12 col-md-7 m-auto">
                                <div class="location-modal-image">
                                    <img src="/assets/images/about.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center mt-3 text-center">
                            <div class="col-12 col-md-12 mb-3">
                                <label for="payment_type"
                                       class="location-formlabel"><span><i
                                            class="fa-solid fa-location-dot"></i></span>Please choose shop</label>
                            </div>
                            <div class="col-12 col-md-12 m-auto">
                                <div class="col-alignment">

                                    @foreach(cache('branches') ?? [] as $branch)
                                        <a href="#" @click.prevent="update_branch('{{$branch->value ?? ''}}')"
                                           class="btn mainbtn-primary me-2"> {{$branch->name?? ''}} </a>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        const {createApp} = Vue

        var app = createApp({
            data() {
                return {
                    api_url: '{{config('api.apiUrl')}}',
                    postcode_api_url: '{{config('api.postcodeApiUrl')}}',
                    headers: {
                        "Authorization": "Bearer {{session('api_token')}}"
                    },
                    date_name: '{{date('l')}}',

                    gs: @json(\App\Services\GlobalSettingService::all()),
                    discount_products: @json($discount_products ?? []),
                    products: @json(cache('products') ?? []),

                    user: '{{session('user')->id ?? null}}',

                    cart: JSON.parse(localStorage.getItem('cart')) || [],
                    cart_expire_at: localStorage.getItem('cart_expire_at'),
                    cart_stringify: localStorage.getItem('cart'),
                    full_cart_comment: localStorage.getItem('fullCartComment') || '',
                    coupon_applied: JSON.parse(localStorage.getItem('applied_coupon')) || [],

                    payment_type: "",
                    order_type: "",

                    requested_hour: "",
                    requested_minute: "00",
                    requested_hours: [
                        '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'
                    ],
                    filtered_requested_hours: [],
                    requested_minutes: [
                        '00', '10', '20', '30', '40', '50'
                    ],

                    first_name: '{{session('user')->property->first_name ?? ""}}',
                    last_name: '{{session('user')->property->last_name ?? ""}}',
                    email: '{{session('user')->email ?? ""}}',
                    phone: '{{session('user')->phone ?? ""}}',

                    shipping_address: 'NEW',

                    shipping_addresses: [],

                    postcode: '',
                    house: '',
                    street: '',
                    town: '',
                    country: 'United Kingdom',

                    address: '',
                    postcodes: [],
                    addresses: [],
                    show_postcode_ul: false,

                    //delivery_charge: 0,
                    applied_discount_product: null,
                    discount_amount: 0,

                    // postcode distance
                    postcode_distance: 0,
                    address_confirmed: false,

                    // discount
                    coupon_code: '',

                    clear_cart: '{{session('clear_cart')}}',

                    // Branch Name
                    branch: '{{session('branch')}}',
                    branch_name: '',
                    branch_postcode: '',

                    loading: false,

                    // delivery charge calculation for postcode
                    postcode_with_delivery_charges: [
                        // {
                        //     key: 'SG5',
                        //     value: 1.50,
                        //     charge_below: 22.50,
                        //     free_above: null
                        // }
                    ],

                    service_charge: 0,

                    active_collection: false,
                    active_delivery: false,

                    business_schedules: @json($business_schedules ?? []),
                    available_requested_time: '',

                }
            },
            mounted() {

            },
            created() {
                //axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

                const self = this;
                if (self.user) {
                    self.getShippingAddress();
                }

                // when order completed clear_cart will be true, and it will clear the cart
                if (self.clear_cart) {
                    localStorage.removeItem('full_cart_comment');
                    localStorage.removeItem('cart');
                    self.cart = [];
                }

                // initially order type is collection
                self.filterRequestedHour()

                self.checkDiscount();

                // branch
                var branch = @json(\App\Services\BranchService::currentBranch(\App\Services\BranchService::current()));
                self.branch_postcode = branch?.property?.postcode || '';
                self.branch_name = branch?.name || '';

                // service_charge
                self.service_charge = self.gs?.service_charge || 0.00;

                // it will check if there is coupon applied
                self.checkCouponExpiry();

                // check day wise order type
                self.checkDayWiseOrderType();

                //self.check_individual_item_discount();

            },
            methods: {

                timeFormat: function (time, format) {
                    return moment(time, 'HH:mm:ss').format(format);
                },

                checkDiscount: async function () {
                    const self = this;

                    self.discount_amount = parseFloat(self.cart_individual_item_discount_total.toFixed(2));
                    self.applied_discount_product = null;

                    var on_all_order = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONALLORDER' && product.status === 1 && on === 'EVERYDAY';
                    })
                    var on_all_order_weekdays = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONALLORDER' && product.status === 1 && on === 'WEEKDAYS';
                    })
                    var on_all_order_dates = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONALLORDER' && product.status === 1 && on === 'DATES';
                    })

                    var on_collection = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONCOLLECTION' && product.status === 1 && on === 'EVERYDAY';
                    })
                    var on_collection_weekdays = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONCOLLECTION' && product.status === 1 && on === 'WEEKDAYS';
                    })
                    var on_collection_dates = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONCOLLECTION' && product.status === 1 && on === 'DATES';
                    })

                    var on_delivery = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONDELIVERY' && product.status === 1 && on === 'EVERYDAY';
                    })
                    var on_delivery_weekdays = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONDELIVERY' && product.status === 1 && on === 'WEEKDAYS';
                    })
                    var on_delivery_dates = self.discount_products.find(function (product) {
                        let on = product.property?.on || 'EVERYDAY';
                        return product.short_name === 'ONDELIVERY' && product.status === 1 && on === 'DATES';
                    })

                    // console.log(self.order_type)
                    // console.log(on_delivery)
                    // console.log(on_delivery_weekdays)
                    // console.log(on_delivery_dates)

                    var res = null;

                    if (on_all_order_weekdays) {
                        res = await self.apply_discount(on_all_order_weekdays);
                        if (res) return;
                    }
                    if (on_all_order_dates) {
                        res = await self.apply_discount(on_all_order_dates);
                        if (res) return;
                    }
                    if (on_all_order) {
                        res = await self.apply_discount(on_all_order);
                        if (res) return;
                    }

                    if (self.order_type === 'COLLECTION') {
                        if (on_collection_weekdays) {
                            res = await self.apply_discount(on_collection_weekdays);
                            if (res) return;
                        }
                        if (on_collection_dates) {
                            res = await self.apply_discount(on_collection_dates);
                            if (res) return;
                        }
                        if (on_collection) {
                            res = await self.apply_discount(on_collection);
                            if (res) return;
                        }
                    }

                    if (self.order_type === 'DELIVERY') {
                        if (on_delivery_weekdays) {
                            res = await self.apply_discount(on_delivery_weekdays);
                            if (res) return;
                        }
                        if (on_delivery_dates) {
                            res = await self.apply_discount(on_delivery_dates);
                            if (res) return;
                        }
                        if (on_delivery) {
                            res = await self.apply_discount(on_delivery);
                            if (res) return;
                        }
                    }
                },
                apply_discount: function (product) {
                    const self = this;
                    var discount = 0;

                    var day = moment().format('dddd');
                    var date = moment().format('YYYY-MM-DD');

                    var is_coupon = product.property?.is_coupon || 'FALSE';
                    var type = product.property?.discount_type || 'PERCENTAGE';
                    var value = product.property?.discount_value || '0';
                    value = parseFloat(value);

                    var on = product.property?.on || 'EVERYDAY';
                    var min_amount = product.property?.min_amount || '0';
                    min_amount = parseFloat(min_amount);

                    var cart_total_price = self.cart_discountable_total;

                    // console.log('is_coupon: ' + is_coupon);
                    // console.log('type: ' + type);
                    // console.log('value: ' + value);
                    // console.log('on: ' + on);
                    // console.log('min_amount: ' + min_amount);
                    //
                    // console.log('Current day: ' + day);

                    if (cart_total_price >= min_amount && is_coupon === 'FALSE') {
                        if (on === 'EVERYDAY') {

                            if (type === 'PERCENTAGE') {

                                discount = (cart_total_price * value) / 100;
                                self.applied_discount_product = product;
                            }
                            if (type === 'FIXED') {
                                discount = value;
                                self.applied_discount_product = product;
                            }
                        }
                        if (on === 'WEEKDAYS') {

                            var week_days = product.property?.week_days || '';
                            week_days = week_days ? JSON.parse(week_days) : '';

                            // if today's name exists in week days
                            var week_day_includes_current_day = week_days.includes(day);
                            if (week_day_includes_current_day) {
                                if (type === 'PERCENTAGE') {
                                    discount = (cart_total_price * value) / 100;
                                    self.applied_discount_product = product;
                                }
                                if (type === 'FIXED') {
                                    discount = value;
                                    self.applied_discount_product = product;
                                }
                            }
                        }
                        if (on === 'DATES') {
                            // if today's name exists in week days
                            var start_date = product.property?.start_date;
                            var end_date = product.property?.end_date;

                            if (start_date && end_date) {

                                const startDateStr = start_date;
                                const endDateStr = end_date;
                                const dateToCheckStr = date;

                                // Convert strings to Date objects
                                const startDate = new Date(startDateStr);
                                const endDate = new Date(endDateStr);
                                const dateToCheck = new Date(dateToCheckStr);

                                const isInRange = dateToCheck >= startDate && dateToCheck <= endDate;

                                if (isInRange) {
                                    if (type === 'PERCENTAGE') {
                                        discount = (cart_total_price * value) / 100;
                                        self.applied_discount_product = product;
                                    }
                                    if (type === 'FIXED') {
                                        discount = value;
                                        self.applied_discount_product = product;
                                    }
                                }
                            }
                        }
                    }

                    var total_discount = discount; // see if each item has individual disocunt

                    self.discount_amount = (self.discount_amount + total_discount).toFixed(2);

                    return discount ? discount : null;
                },

                apply_coupon_code: function () {
                    const self = this;
                    if (!self.coupon_code) return false;

                    var discount = 0;
                    var cart_total = self.cart_total;

                    var coupon_product = self.discount_products.find(function (product) {
                        return product.short_name.toLowerCase() === self.coupon_code.toLowerCase();
                    })
                    if (coupon_product) {
                        self.applied_discount_product = coupon_product;

                        var discount_type = coupon_product.property?.discount_type;
                        var discount_value = coupon_product.property?.discount_value;
                        var is_coupon = coupon_product.property?.is_coupon;

                        // if this is not coupon then this discount will work
                        if (is_coupon === 'TRUE') {
                            if (discount_type === 'PERCENTAGE') {
                                discount_value = parseFloat(discount_value);
                                discount = (cart_total * discount_value) / 100;
                                self.discount_amount = discount.toFixed(2);
                            }
                            if (discount_type === 'FIXED') {
                                discount = parseFloat(discount_value);
                                self.discount_amount = discount.toFixed(2);
                            }

                            localStorage.setItem('applied_coupon', JSON.stringify({
                                code: self.coupon_code,
                                expire_at: moment().add(15, 'minute').format('YYYY-MM-DD HH:mm:ss'),
                                applied_discount_product: self.applied_discount_product
                            }));
                        }
                    } else {
                        swal("This Coupon code is not available", {
                            icon: "warning"
                        })
                    }

                    self.coupon_code = '';
                },
                dismissCouponCode: function () {
                    const self = this;

                    localStorage.removeItem('applied_coupon');

                    self.coupon_code = '';
                    self.applied_discount_product = null;

                    self.checkDiscount();
                },
                checkCouponExpiry: function () {
                    const self = this;

                    var applied_coupon = JSON.parse(localStorage.getItem('applied_coupon') || null);
                    if (!applied_coupon) {
                        return false;
                    }

                    var applied_coupon_expire = applied_coupon.expire_at;

                    var current_time = moment().format('YYYY-MM-DD HH:mm:ss');

                    if (current_time > applied_coupon_expire) {
                        localStorage.removeItem('applied_coupon')
                        self.coupon_code = '';
                        self.applied_discount_product = null;

                        self.checkDiscount();
                    } else {
                        self.coupon_code = self.coupon_applied.code || '';
                        self.apply_coupon_code()
                    }

                },

                getShippingAddress: function () {
                    const self = this;
                    axios.get(self.api_url + '/user/shipping-address', {
                        headers: self.headers
                    })
                        .then(res => {
                            self.shipping_addresses = res.data;
                        })
                },

                getPostcodes: async function () {
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

                    await axios.get(self.postcode_api_url + '/postal-code/' + postcode, {
                        headers: {
                            'Access-Control-Allow-Origin': '*',
                        }
                    })
                        .then(res => {
                            self.postcodes = res.data;
                            self.show_postcode_ul = true;
                        })
                },
                getLocations: function (postcode) {
                    const self = this;
                    self.show_postcode_ul = false;
                    self.postcode = postcode;
                    axios.get(self.postcode_api_url + '/postal-code-data/' + postcode, {
                        headers: {
                            'Access-Control-Allow-Origin': '*',
                        }
                    })
                        .then(res => {
                            self.addresses = res.data;
                            self.address = 0;
                        })
                },

                confirm_address: async function () {
                    var self = this;
                    if (!self.postcode) {
                        swal("Please enter postcode!", {
                            icon: 'warning'
                        })
                        return false;
                    }

                    self.postcode = self.postcode.replace(/(\S*)\s*(\d)/, "$1 $2");

                    var response = await self.calculatePostcodeDistance();

                    var result = response.data['distance'] ?? 0;
                    var distanceInMile = parseInt(result) * 0.000621371;
                    distanceInMile = distanceInMile.toFixed(2);
                    self.postcode_distance = parseFloat(distanceInMile);

                    if (distanceInMile) {
                        self.address_confirmed = true;
                    }

                },
                calculatePostcodeDistance: function () {
                    var self = this;

                    var gs_postcode = self.gs?.business_postcode;
                    var branch_postcode = self.branch_postcode;
                    var customer_postcode = self.postcode;

                    var business_postcode = branch_postcode ? branch_postcode : gs_postcode;

                    if (!business_postcode || !customer_postcode || customer_postcode.length < 5) {
                        swal("Please enter business and consumer postcode!", {
                            icon: 'warning'
                        })
                        return false;
                    }

                    return axios.get('/postcode/distance', {
                        params: {
                            origins: business_postcode,
                            destinations: customer_postcode,
                        }
                    })
                    // .then(function (response) {
                    //     var result = response.data['distance'] || 0;
                    //     var distanceInMile = parseInt(result) * 0.000621371;
                    //     distanceInMile = distanceInMile.toFixed(2);
                    //
                    //     self.postcode_distance = distanceInMile;
                    //     return distanceInMile;
                    // })
                    // .catch(function (error) {
                    //     console.log(error)
                    // });
                },

                updateCartComment: function (index, value) {
                    var self = this;

                    self.cart[index].comment = value;

                    localStorage.setItem('cart', JSON.stringify(self.cart));
                    self.cart_stringify = localStorage.getItem('cart');
                },
                removeCartItem: function (index) {
                    const self = this;
                    self.cart.splice(index, 1);
                    localStorage.setItem('cart', JSON.stringify(self.cart));
                    self.cart_stringify = localStorage.getItem('cart');

                    // self.check_individual_item_discount();
                },

                openBranchModal: function () {
                    $("#shopModal").modal('show');
                },
                update_branch: function (branch) {
                    var self = this;
                    if (!branch) {
                        return false;
                    }

                    if (branch === self.branch) {
                        window.location.reload();
                        return false
                    }

                    if (self.cart.length) {
                        swal({
                            title: "",
                            text: "You are changing shop, Your exiting cart will be empty.",
                            icon: "",
                            buttons: true,
                            dangerMode: true,
                        })
                            .then(async (confirm) => {
                                if (confirm) {

                                    localStorage.setItem('cart', JSON.stringify([]));
                                    window.location = '/' + branch + '/menu';

                                }
                            });
                    } else {
                        window.location = '/' + branch + '/menu';

                    }

                },
                update_branch_bk: function () {
                    var self = this;
                    if (!self.branch) {
                        return false;
                    }

                    if (self.cart.length) {

                        swal({
                            title: "",
                            text: "You are changing shop, Your exiting cart will be empty.",
                            icon: "",
                            buttons: true,
                            dangerMode: true,
                        })
                            .then(async (confirm) => {
                                if (confirm) {

                                    localStorage.setItem('cart', JSON.stringify([]));
                                    window.location = '/branch/set/' + self.branch;

                                } else {
                                    self.branch = '{{\App\Services\BranchService::current()}}';
                                }
                            });

                    } else {

                        localStorage.setItem('cart', JSON.stringify([]));
                        window.location = '/branch/set/' + self.branch;

                    }
                },

                submit: async function () {
                    var self = this;

                    if (!self.payment_type) {
                        swal("Please Choose payment type", {
                            icon: "warning"
                        })
                        window.location = '#checkout-info'
                        return false;
                    }

                    if (!self.order_type) {
                        swal("Please Choose order type", {
                            icon: "warning"
                        })
                        window.location = '#checkout-info'
                        return false;
                    }

                    if (!self.requested_hour) {
                        swal("Please choose request hour", {
                            icon: "warning"
                        })
                        window.location = '#checkout-info'
                        return false;
                    }

                    if (!self.first_name || !self.last_name || !self.phone || !self.email) {
                        swal("Please enter your information", {
                            icon: "warning"
                        })

                        window.location = '#customer-info'
                        return false;
                    }

                    if (!self.checkBusinessStatus()) {
                        swal("Online order is not available today", {
                            icon: "warning"
                        })
                        return false;
                    }

                    if (!self.available_requested_time) {
                        swal("Requested time is not available", {
                            icon: "warning"
                        })
                        return false;
                    }

                    // if (!self.checkRequestedTime()) {
                    //     swal("Online order is not available for the requested time", {
                    //         icon: "warning"
                    //     })
                    //     return false;
                    // }

                    if (self.order_type === 'DELIVERY') {

                        // Check minimum amount for delivery
                        var minimum_amount_for_delivery = self.gs['minimum_amount_for_delivery'] || 0;
                        if (!self.checkMinimumAmountForDelivery()) {
                            swal("Minimum amount for Delivery is " + '{{config('app.currency')}}' + minimum_amount_for_delivery, {
                                icon: "warning"
                            })
                            return false;
                        }

                        // When need to calculate delivery charge from postcode distance
                        var delivery_charge_type = self.gs?.delivery_charge_type || 'FIXED';
                        if (delivery_charge_type === 'DISTANCE' && !self.address_confirmed) {
                            swal("Please confirm your address first", {
                                icon: "warning"
                            })
                            return false;
                        }

                        // check maximum delivery distance
                        var maximum_delivery_distance = self.gs?.maximum_delivery_distance ?? null;
                        if (maximum_delivery_distance) {
                            var response = await self.calculatePostcodeDistance();
                            var result = response.data['distance'] ?? 0;
                            var distanceInMile = parseInt(result) * 0.000621371;
                            distanceInMile = distanceInMile.toFixed(2);
                            self.postcode_distance = parseFloat(distanceInMile);

                            if (self.postcode_distance > maximum_delivery_distance) {
                                swal("Maximum delivery distance is " + maximum_delivery_distance + ' mile', {
                                    icon: "warning"
                                })
                                return false;
                            }
                        }

                    }

                    self.loading = true;

                    $("#formCheckout").submit();
                },

                checkBusinessStatus: function () {
                    const self = this;

                    var business_status = self.gs?.business_status || null;
                    var business_off_date = self.gs?.business_off_date || null;
                    var business_weekly_off_day = self.gs?.business_weekly_off_day || null;

                    // Business OPEN or CLOSED
                    if (business_status && business_status === 'CLOSED') return false;

                    // Check business off date
                    var current_date = moment().format('YYYY-MM-DD');
                    if (business_off_date && business_off_date === current_date) return false;

                    // Check business weekly off date name
                    var current_date_name = moment().format('dddd');
                    if (business_weekly_off_day && business_weekly_off_day === current_date_name.toLowerCase()) return false;

                    return true;

                },

                checkDayWiseOrderType: function () {
                    const self = this;

                    var date = moment().format('dddd');
                    date = date.toLocaleLowerCase(); // sunday

                    var today_order_type_key = date + '_order_type';
                    var today_order_type = self.gs[today_order_type_key] || 'COLLECTION&DELIVERY';

                    if (today_order_type === 'COLLECTION&DELIVERY') {
                        self.active_collection = true;
                        self.active_delivery = true;
                    } else if (today_order_type === 'COLLECTION') {
                        self.active_collection = true;
                        self.active_delivery = false;
                    } else if (today_order_type === 'DELIVERY') {
                        self.active_collection = false;
                        self.active_delivery = true;
                    } else {
                        self.active_collection = true;
                        self.active_delivery = true;
                    }

                },

                checkBusinessSchedule: function () {
                    const self = this;

                    var requested_hour = self.requested_hour;
                    var requested_minute = self.requested_minute;
                    var requested_time = requested_hour + ':' + requested_minute + ':00';

                    if (requested_hour === 'ASAP') {
                        requested_time = moment().format('HH:mm:ss');
                    }

                    var res = self.isRequestedTimeInSchedule(requested_time, self.business_schedules)
                    var nex_avl_time = self.getNextAvailableTime(requested_time, self.business_schedules, self.order_type)

                    self.available_requested_time = nex_avl_time;

                    console.log('NEW - Estimated ' + self.order_type + ' time: ' + nex_avl_time);

                    // console.log('req time ' + requested_time)
                    // console.log('curr time ' + moment().format('HH:mm:ss'))
                    // console.log('next available time ' + nex_avl_time)

                },
                isRequestedTimeInSchedule: function (time, schedules) {
                    if (!schedules.length) return false;

                    return schedules.some(schedule => {
                        const [startHour, startMinute, startSecond] = schedule.start_time.split(':').map(Number);
                        const [endHour, endMinute, endSecond] = schedule.end_time.split(':').map(Number);
                        const [currentHour, currentMinute, currentSecond] = time.split(':').map(Number);

                        const startTime = new Date(0, 0, 0, startHour, startMinute, startSecond);
                        const endTime = new Date(0, 0, 0, endHour, endMinute, endSecond);
                        const currentTime = new Date(0, 0, 0, currentHour, currentMinute, currentSecond);

                        return currentTime >= startTime && currentTime <= endTime;
                    });
                },

                getNextAvailableTimeBk: function (requestedTime, schedules, orderType) {
                    const self = this;

                    if (!schedules.length) return null;

                    var estimated_delivery_duration = self.gs['estimated_delivery_duration'] || 0;
                    var estimated_collection_duration = self.gs['estimated_collection_duration'] || 0;

                    estimated_delivery_duration = parseInt(estimated_delivery_duration);
                    estimated_collection_duration = parseInt(estimated_collection_duration);

                    // Estimation times in minutes
                    const estimationTime = orderType.toUpperCase() === "DELIVERY" ? estimated_delivery_duration : estimated_collection_duration;

                    const currentTime = moment().format('HH:mm:ss');

                    // Filter and sort schedules by order type
                    const filteredSchedules = schedules
                        .filter((schedule) =>
                            schedule.order_type.trim().toUpperCase() === orderType.toUpperCase()
                        )
                        .map((schedule) => ({
                            start: schedule.start_time,
                            end: schedule.end_time,
                        }))
                        .sort((a, b) => a.start.localeCompare(b.start));

                    if (!filteredSchedules.length) return null;

                    let nextAvailableTime = null;

                    // Determine time to compare (adjusted based on requested and current times)
                    const timeToCompare = requestedTime < currentTime ? currentTime : requestedTime;

                    // Iterate through the schedules to find the next available slot
                    for (const slot of filteredSchedules) {
                        if (timeToCompare >= slot.start && timeToCompare <= slot.end) {
                            // If within a slot, set the next available time
                            nextAvailableTime = timeToCompare;
                        } else if (timeToCompare < slot.start) {
                            // If before a slot, set the next available time to slot start
                            nextAvailableTime = slot.start;
                        }

                        if (nextAvailableTime !== null) break;
                    }

                    // If no valid time found and requested time is after the last slot, return null
                    if (nextAvailableTime === null) {
                        const lastSlotEnd = filteredSchedules[filteredSchedules.length - 1].end;
                        if (timeToCompare > lastSlotEnd) {
                            return null; // Requested time is beyond the last available slot
                        }
                    }

                    // Apply estimation time
                    // Apply estimation time only if there is a gap smaller than the estimation time
                    if (nextAvailableTime) {
                        const nextMoment = moment(nextAvailableTime, "HH:mm:ss");
                        const requestedMoment = moment(requestedTime, "HH:mm:ss");
                        const startMoment = moment(filteredSchedules[0].start, "HH:mm:ss"); // First slot start time

                        // Check the gap from the restaurant's start time and requested time
                        const gapFromStart = requestedMoment.diff(startMoment, "minutes");

                        // If the gap from the start time is less than the estimation time, adjust the next available time
                        if (gapFromStart < estimationTime || requestedMoment.isBefore(startMoment)) {
                            nextMoment.add(estimationTime, "minutes"); // Add estimation time
                        }

                        // Return the adjusted next available time
                        nextAvailableTime = nextMoment.format("HH:mm:ss");
                    }

                    return nextAvailableTime;
                },
                getNextAvailableTime: function (requestedTime, schedules, orderType) {
                    const self = this;

                    if (!schedules.length) return null;

                    const currentTime = moment().format("HH:mm:ss");

                    // Extract estimation times from settings
                    const {
                        estimated_delivery_duration = 0,
                        estimated_collection_duration = 0,
                        est_del_duration_before_opening_time = 0,
                        est_del_duration_after_opening_time = 0,
                        est_col_duration_before_opening_time = 0,
                        est_col_duration_after_opening_time = 0
                    } = self.gs;

                    const estimationDuration = orderType.toUpperCase() === "DELIVERY"
                        ? {
                            default: parseInt(estimated_delivery_duration),
                            beforeOpening: parseInt(est_del_duration_before_opening_time),
                            afterOpening: parseInt(est_del_duration_after_opening_time)
                        }
                        : {
                            default: parseInt(estimated_collection_duration),
                            beforeOpening: parseInt(est_col_duration_before_opening_time),
                            afterOpening: parseInt(est_col_duration_after_opening_time)
                        };

                    // Filter and sort schedules by order type
                    const filteredSchedules = schedules
                        .filter((schedule) =>
                            schedule.order_type.trim().toUpperCase() === orderType.toUpperCase()
                        )
                        .map((schedule) => ({
                            start: schedule.start_time,
                            end: schedule.end_time
                        }))
                        .sort((a, b) => a.start.localeCompare(b.start));

                    if (!filteredSchedules.length) return null;

                    let nextAvailableTime = null;

                    for (const schedule of filteredSchedules) {
                        const scheduleStart = moment(schedule.start, "HH:mm:ss");
                        const scheduleEnd = moment(schedule.end, "HH:mm:ss");
                        const currentMoment = moment(currentTime, "HH:mm:ss");
                        const requestedMoment = moment(requestedTime, "HH:mm:ss");

                        // Case 1: Requested time is before the schedule's opening time
                        if (requestedMoment.isBefore(scheduleStart)) {
                            nextAvailableTime = scheduleStart
                                .clone()
                                .add(estimationDuration.beforeOpening, "minutes")
                                .format("HH:mm:ss");
                            break;
                        }

                        // Case 2: Current time is within the schedule
                        if (requestedMoment.isBetween(scheduleStart, scheduleEnd, null, "[)")) {
                            const gapFromCurrent = requestedMoment.diff(currentMoment, "minutes");

                            console.log(gapFromCurrent)
                            if (gapFromCurrent < estimationDuration.afterOpening) {
                                // Add estimation duration to current time if the gap is too small
                                nextAvailableTime = currentMoment
                                    .clone()
                                    .add(estimationDuration.afterOpening, "minutes")
                                    .format("HH:mm:ss");

                            } else {
                                // Use the requested time as it's valid
                                nextAvailableTime = requestedMoment.format("HH:mm:ss");
                            }

                            // Ensure the calculated time doesn't exceed the schedule's end time
                            if (moment(nextAvailableTime, "HH:mm:ss").isAfter(scheduleEnd)) {
                                nextAvailableTime = null;
                            }
                        }

                        // Case 3: Requested time is after the current schedule
                        if (requestedMoment.isAfter(scheduleEnd)) {
                            nextAvailableTime = null; // Move to the next schedule
                        }

                        if(nextAvailableTime) {
                            break
                        }
                    }

                    // If no time was found in the schedules, return null
                    if (!nextAvailableTime) {
                        nextAvailableTime = null
                    }

                    return nextAvailableTime;
                },

                checkRequestedTime: function () {
                    const self = this;

                    var requested_hour = self.requested_hour;
                    var requested_minute = self.requested_minute;
                    var requested_time = requested_hour + ':' + requested_minute + ':00';

                    if (requested_hour === 'ASAP') {
                        requested_time = moment().format('HH:mm:ss');
                    }

                    var requested_timestamp = moment().format('YYYY-MM-DD') + ' ' + requested_time;

                    var date = moment().format('dddd');
                    date = date.toLocaleLowerCase(); // sunday
                    var current_time = moment().format('HH:mm:ss');

                    var delivery_from_key = 'delivery_from_' + date;
                    var delivery_from = self.gs[delivery_from_key] || null;

                    var collection_from_key = 'collection_from_' + date;
                    var collection_from = self.gs[collection_from_key] || null;

                    var closing_time_key = 'closing_time_' + date;
                    var closing_time = self.gs[closing_time_key] || null;

                    var estimated_delivery_duration = self.gs['estimated_delivery_duration'] || null;
                    var estimated_collection_duration = self.gs['estimated_collection_duration'] || null;

                    var last_collection_time_key = 'last_collection_time_' + date;
                    var last_delivery_time_key = 'last_delivery_time_' + date;

                    var last_collection_order_time = self.gs['last_collection_order_time'] ?? self.gs[last_collection_time_key] ?? null;
                    var last_delivery_order_time = self.gs['last_delivery_order_time'] ?? self.gs[last_delivery_time_key] ?? null;

                    // check if the order time is after closing time
                    if (current_time >= closing_time) {
                        return false;
                    }

                    var start_time = '';
                    if (self.order_type === 'DELIVERY') {
                        // closing_time = moment(closing_time, 'HH:mm:ss').subtract(estimated_delivery_duration, 'minutes').format('HH:mm:ss');
                        closing_time = last_delivery_order_time ?? moment(closing_time, 'HH:mm:ss').subtract(estimated_delivery_duration, 'minutes').format('HH:mm:ss');
                        start_time = delivery_from;
                    } else if (self.order_type === 'COLLECTION') {
                        // closing_time = moment(closing_time, 'HH:mm:ss').subtract(estimated_collection_duration, 'minutes').format('HH:mm:ss');
                        closing_time = last_collection_order_time ?? moment(closing_time, 'HH:mm:ss').subtract(estimated_collection_duration, 'minutes').format('HH:mm:ss');
                        start_time = collection_from;
                    }

                    if (requested_hour !== 'ASAP' && requested_time < start_time) {
                        return false;
                    }

                    // check if the requested time is older than current time / if old time chosen
                    if (current_time > requested_time) {
                        return false;
                    }

                    // check if the requested time is after opening time

                    // check if the requested time is before closing time
                    if (requested_time > closing_time) {
                        return false;
                    }

                    return true;

                },

                checkMinimumAmountForDelivery: function () {
                    const self = this;

                    var minimum_amount_for_delivery = self.gs['minimum_amount_for_delivery'] || 0;

                    return self.cart_total >= parseFloat(minimum_amount_for_delivery);

                },

                filterRequestedHourBk: function () {
                    const self = this;
                    self.filtered_requested_hours = [];
                    var date_name = self.date_name.toLowerCase();
                    var current_hour = moment().format('HH');

                    if (self.order_type === 'COLLECTION') {
                        var collection_from_key = 'collection_from_' + date_name;
                        var collection_from = self.gs[collection_from_key] || null;
                        if (collection_from) {
                            var collection_hour = moment(collection_from, 'HH:mm:ss').format('HH');
                            self.filtered_requested_hours = self.requested_hours.filter(function (val) {
                                return val >= collection_hour;
                            })
                            if (parseInt(current_hour) > parseInt(collection_hour)) {
                                self.filtered_requested_hours = self.requested_hours.filter(function (val) {
                                    return val >= current_hour;
                                })
                            }
                        }
                    } else if (self.order_type === 'DELIVERY') {
                        var delivery_from_key = 'delivery_from_' + date_name;
                        var delivery_from = self.gs[delivery_from_key] || null;
                        if (delivery_from) {
                            var delivery_hour = moment(delivery_from, 'HH:mm:ss').format('HH')
                            self.filtered_requested_hours = self.requested_hours.filter(function (val) {
                                return val >= delivery_hour;
                            })
                            if (parseInt(current_hour) > parseInt(delivery_hour)) {
                                self.filtered_requested_hours = self.requested_hours.filter(function (val) {
                                    return val >= current_hour;
                                })
                            }
                        }
                    }
                },
                filterRequestedHour: function () {
                    const self = this;
                    self.filtered_requested_hours = [];

                    const currentDayOfWeek = moment().format('dddd').toLowerCase(); // e.g., 'sunday'
                    const currentTime = moment(); // Current moment object

                    // Filter schedules matching the current day and order type
                    const filteredSchedules = self.business_schedules.filter(schedule => {
                        return (
                            schedule.day_of_week.toLowerCase() === currentDayOfWeek &&
                            schedule.order_type === self.order_type
                        );
                    });

                    console.log(self.business_schedules)

                    // Loop through each matching schedule
                    self.business_schedules.forEach(schedule => {
                        const startTime = moment(schedule.start_time, 'HH:mm:ss');
                        const endTime = moment(schedule.end_time, 'HH:mm:ss');

                        // Filter requested hours within the schedule range and after the current time
                        self.filtered_requested_hours = self.filtered_requested_hours.concat(
                            self.requested_hours.filter(hour => {
                                const hourMoment = moment(hour, 'HH');
                                return (
                                    hourMoment.isBetween(startTime, endTime, 'hour', '[)') &&
                                    hourMoment.isSameOrAfter(currentTime, 'hour')
                                );
                            })
                        );
                    });

                    // Remove duplicates and sort the filtered hours
                    self.filtered_requested_hours = [...new Set(self.filtered_requested_hours)].sort((a, b) => a - b);
                },

                updateQty: function (type, index) {
                    var self = this;
                    var total_price = 0;
                    if (type === 'INCREASE') {
                        if (self.cart[index].unit === 10) {
                            return;
                        }

                        self.cart[index].unit++;
                        total_price = self.cart[index].unit_price * self.cart[index].unit;
                        self.cart[index].total_price = total_price.toFixed(2);
                    }
                    if (type === 'DECREASE') {
                        if (self.cart[index].unit === 1) {
                            return;
                        }

                        self.cart[index].unit--;
                        total_price = self.cart[index].unit_price * self.cart[index].unit;
                        self.cart[index].total_price = total_price.toFixed(2);

                    }
                    localStorage.setItem('cart', JSON.stringify(self.cart));

                    self.cart_stringify = localStorage.getItem('cart');

                    // self.check_individual_item_discount();

                },

                timeToSeconds: function (time = null) {
                    if (time) {
                        const [hours, minutes, seconds] = time.split(":").map(Number);
                        return hours * 3600 + minutes * 60 + seconds;
                    }

                    return null;
                },

                calculateEstimatedRequestedTime: function () {
                    const self = this;
                    var requested_delivery_time_calculation = self.gs['requested_delivery_time_calculation'] ?? 'from_delivery_or_collection_time';

                    var requested_hour = self.requested_hour;
                    var requested_minute = self.requested_minute;

                    var date = moment().format('dddd');
                    date = date.toLocaleLowerCase(); // sunday
                    var current_time = moment().format('HH:mm:ss');
                    var current_time_in_sec = self.timeToSeconds(current_time)
                    var opening_time_key = 'opening_time_' + date;
                    var opening_time = self.gs[opening_time_key] ?? null;
                    var opening_time_in_sec = opening_time ? self.timeToSeconds(opening_time) : null;

                    var estimated_collection_duration = self.gs['estimated_collection_duration'] ?? null;
                    var estimated_delivery_duration = self.gs['estimated_delivery_duration'] ?? null;

                    var start_time = null;
                    var duration = 0;
                    var order_type_text = '';

                    var requested_time = moment().format('HH:mm:ss');

                    if (self.order_type === 'DELIVERY') {
                        var delivery_from_key = 'delivery_from_' + date;
                        start_time = self.gs[delivery_from_key] ?? null;
                        duration = estimated_delivery_duration;
                        order_type_text = 'delivery';

                        if (!opening_time_in_sec) {
                            opening_time_in_sec = start_time;
                        }

                        if (requested_hour === 'ASAP') {

                            if (opening_time_in_sec > current_time_in_sec) {
                                // business will open after sometime
                                // requested time will delivery or collection time
                                if (requested_delivery_time_calculation === 'from_delivery_or_collection_time') {
                                    requested_time = start_time;
                                } else {
                                    requested_time = opening_time;
                                }
                                duration = self.gs['est_del_duration_before_opening_time'] ?? null;
                            } else {
                                // business is open
                                duration = self.gs['est_del_duration_after_opening_time'] ?? null;

                                // delivery will start after sometime
                                if (start_time > current_time) {
                                    requested_time = start_time;
                                } else {
                                    requested_time = current_time;
                                }

                            }

                        } else {

                            requested_time = requested_hour + ':' + requested_minute + ':00';

                            if (requested_time < opening_time) {
                                return order_type_text + ' starts at ' + start_time + '. Please choose a different time';
                            }

                            if (current_time > requested_time) {
                                requested_time = current_time;
                            }

                            if (opening_time_in_sec > current_time_in_sec) {
                                // business will open after sometime
                                duration = self.gs['est_del_duration_before_opening_time'] ?? null;

                                // requested time >= opening_time + estimated duration then duration will be 0; no time will add
                                if (requested_time >= moment(start_time, "HH:mm:ss").add(duration, 'minutes').format("HH:mm:ss")) {
                                    duration = 0;
                                }

                            } else {
                                // business is open
                                duration = self.gs['est_del_duration_after_opening_time'] ?? null;

                                // check requested time will current time + estimated duration
                                if (requested_time >= moment(current_time, "HH:mm:ss").add(duration, 'minutes').format("HH:mm:ss")) {
                                    duration = 0;
                                }

                            }
                        }

                    } else {

                        var collection_from_key = 'collection_from_' + date;
                        start_time = self.gs[collection_from_key] ?? null;
                        duration = estimated_collection_duration;
                        order_type_text = 'collection';

                        if (!opening_time_in_sec) {
                            opening_time_in_sec = start_time;
                        }

                        if (requested_hour === 'ASAP') {

                            if (opening_time_in_sec > current_time_in_sec) {
                                // business will open after sometime
                                // requested time will delivery or collection time
                                requested_time = opening_time;
                                duration = self.gs['est_col_duration_before_opening_time'] ?? null;
                            } else {
                                // business is open
                                duration = self.gs['est_col_duration_after_opening_time'] ?? null;
                                requested_time = current_time;
                            }

                        } else {

                            requested_time = requested_hour + ':' + requested_minute + ':00';

                            if (requested_time < opening_time) {
                                return order_type_text + ' starts at ' + start_time + '. Please choose a different time';
                            }

                            if (current_time > requested_time) {
                                requested_time = current_time;
                            }

                            if (opening_time_in_sec > current_time_in_sec) {
                                // business will open after sometime
                                duration = self.gs['est_col_duration_before_opening_time'] ?? null;

                                // requested time >= opening_time + estimated duration then duration will be 0; no time will add
                                if (requested_time >= moment(opening_time, "HH:mm:ss").add(duration, 'minutes').format("HH:mm:ss")) {
                                    duration = 0;
                                }

                            } else {
                                // business is open
                                duration = self.gs['est_col_duration_after_opening_time'] ?? null;

                                // check requested time will current time + estimated duration
                                if (requested_time >= moment(current_time, "HH:mm:ss").add(duration, 'minutes').format("HH:mm:ss")) {
                                    duration = 0;
                                }

                            }
                        }
                    }

                    console.log('Estimated ' + order_type_text + ' time: ' + moment(requested_time, "HH:mm:ss").add(duration, 'minutes').format("HH:mm"));

                    return 'Estimated ' + order_type_text + ' time: ' + moment(requested_time, "HH:mm:ss").add(duration, 'minutes').format("HH:mm");
                },

                getDeliveryChargeForPostcode: function () {
                    var self = this;

                    var charge = self.postcode_with_delivery_charges.find(function (charge) {
                        var key = charge.key.toUpperCase();
                        var postcode = self.postcode.toUpperCase();
                        postcode = postcode.replace(/\s/g, '');
                        return postcode.startsWith(key);
                    });

                    if (charge) {
                        return parseFloat(charge.value).toFixed(2)
                    } else {
                        return self.gs?.delivery_charge ?? 0.00;
                    }

                },

                check_individual_item_discount: function () {
                    var self = this;

                    // Delete all free products
                    self.cart = self.cart.filter(function (c) {
                        return !c?.free;
                    });

                    localStorage.setItem('cart', JSON.stringify(self.cart));
                    self.cart_stringify = localStorage.getItem('cart');

                    var total_discount = 0;
                    self.cart.forEach(function (val, key) {
                        if (val.product.discount) {
                            var condition = null;

                            if (val.product.discount.type === 'buy_nx_get_y') {

                                condition = val.product.discount.condition || null;

                                // Check if there are enough units to qualify for the discount
                                if (parseInt(val.unit) >= parseInt(condition.buy_unit)) {
                                    var discounted_product_id = condition.get_product_id || '';
                                    var discounted_product_unit = parseInt(condition.get_unit) || 0;
                                    var buy_unit = parseInt(condition.buy_unit);

                                    if (!discounted_product_id || !discounted_product_unit) {
                                        return false;
                                    }

                                    var discounted_product = self.products.find(function (p) {
                                        return p.id === discounted_product_id;
                                    });
                                    if (!discounted_product) return false;

                                    // Calculate total free items for complete sets
                                    var eligible_sets = Math.floor(val.unit / buy_unit);
                                    var free_units = eligible_sets * discounted_product_unit;

                                    // Check leftover units for additional free items
                                    var leftover_units = val.unit % buy_unit;
                                    if (leftover_units >= 2) { // Add 1 free item for leftover if >= 2
                                        free_units += discounted_product_unit / buy_unit * leftover_units;
                                    }

                                    // Add free items to the cart
                                    var obj = {
                                        product: discounted_product,
                                        selected_components: [],
                                        selected_components_N: [],
                                        unit: free_units,
                                        unit_price: 0,
                                        price: 0,
                                        component_price: 0,
                                        total_price: 0,
                                        free: true,
                                    };
                                    self.cart.push(obj);
                                }
                            }
                        }
                    });

                    localStorage.setItem('cart', JSON.stringify(self.cart));
                    self.cart_stringify = localStorage.getItem('cart');
                }

            },
            computed: {
                cart_total: function () {
                    var self = this;

                    var total_price = 0;
                    self.cart.forEach(function (val, key) {
                        total_price += (val.unit_price * val.unit);
                    });

                    // self.check_individual_item_discount();

                    return parseFloat(total_price);
                },
                cart_discountable_total: function () {
                    var self = this;

                    var total_price = 0;
                    self.cart.forEach(function (val, key) {
                        if (val.product.discountable === 1) { // only discountable product
                            total_price += (val.unit_price * val.unit);
                        }
                    });

                    return parseFloat(total_price);
                },
                cart_individual_item_discount_total: function () {
                    var self = this;

                    var total_discount = 0;
                    self.cart.forEach(function (val, key) {
                        if (val.product.discount) {
                            if (val.product.discount.type === 'percentage') {
                                var total_amount = (val.unit_price * val.unit);
                                var discount_amount = total_amount - (total_amount * (parseInt(val.product.discount.value) / 100));
                                var payable = total_amount - discount_amount;

                                total_discount += payable;
                            }
                            if (val.product.discount.type === 'fixed') {
                                total_discount += (val.unit_price * val.unit) - parseInt(val.product.discount.value);
                            }
                        }
                    });
                    return parseFloat(total_discount);
                },

                delivery_charge: function () {
                    var self = this;
                    if (self.order_type === 'COLLECTION') {
                        return 0.00;
                    }

                    var delivery_charge_type = self.gs?.delivery_charge_type || 'FIXED';
                    var delivery_charge_fix_amount = self.gs?.delivery_charge || 0.00;

                    if (delivery_charge_type === 'FIXED') {
                        return parseFloat(delivery_charge_fix_amount).toFixed(2);
                    }

                    if (delivery_charge_type === 'DISTANCE') {
                        // Calculate distance and ...
                        var distance = self.postcode_distance;

                        var delivery_charge = 0;

                        // Set delivery charge as a round figure
                        if (distance > 0 && distance < 1) {
                            delivery_charge = 1.00 // remove decimal places
                        } else if (distance >= 1 && distance < 2) {
                            delivery_charge = 1.50 // remove decimal places
                        } else if (distance >= 2 && distance < 3) {
                            delivery_charge = 2.50 // remove decimal places
                        } else if (distance >= 3 && distance < 4) {
                            delivery_charge = 3.00 // remove decimal places
                        } else if (distance >= 4) {
                            delivery_charge = 3.50 // remove decimal places
                        } else {
                            delivery_charge = 0;
                        }
                        return parseFloat(delivery_charge).toFixed(2);
                    }

                    if (delivery_charge_type === 'PER_POSTCODE') {

                        var delivery_charge = self.getDeliveryChargeForPostcode();

                        return parseFloat(delivery_charge).toFixed(2);
                    }

                    if (delivery_charge_type === 'PER_MILE') {

                        var distance = self.postcode_distance;

                        var delivery_charge = 0;

                        // Set delivery charge as a round figure
                        if (distance > 1 && distance < 2) {
                            delivery_charge = 0.00 // remove decimal places
                        } else if (distance >= 2 && distance < 3) {
                            delivery_charge = 2.00 // remove decimal places
                        } else if (distance >= 3 && distance < 4) {
                            delivery_charge = 3.00 // remove decimal places
                        } else if (distance >= 4 && distance < 5) {
                            delivery_charge = 4.00 // remove decimal places
                        } else if (distance >= 5) {
                            delivery_charge = 5.00 // remove decimal places
                        } else {
                            delivery_charge = delivery_charge_fix_amount;
                        }

                        return parseFloat(delivery_charge).toFixed(2);
                    }

                    if (delivery_charge_type === 'FREE_OVER_GBP_N') {

                        var free_delivery_charge_over_amount = self.gs?.free_delivery_charge_over_amount || 0.00;

                        if (self.cart_total() >= free_delivery_charge_over_amount) {
                            return 0.00
                        } else {
                            return delivery_charge_fix_amount;
                        }
                    }

                },
                net_total: function () {
                    var self = this;

                    return (parseFloat(self.cart_total) + parseFloat(self.delivery_charge) + parseFloat(self.service_charge) - parseFloat(self.discount_amount)).toFixed(2);
                },
            },
            watch: {
                address: function (index) {
                    var self = this;
                    if (Number.isInteger(index)) {
                        self.house = self.addresses[index].building_number + ' ' + self.addresses[index].building_name;
                        self.street = self.addresses[index].thoroughfare;
                        self.town = self.addresses[index].posttown;
                    }
                },
                shipping_address: function (val) {
                    var self = this;

                    self.postcode = '';
                    self.house = '';
                    self.town = '';
                    self.street = '';

                    if (val !== 'NEW') {
                        var address = self.shipping_addresses.find(function (add) {
                            return add.id === val;
                        })
                        if (address) {
                            self.postcode = address.prop?.postcode;
                            self.house = address.prop?.house;
                            self.town = address.prop?.town;
                            self.street = address.prop?.state;
                        }
                    }

                },
                postcode: function (val) {
                    var self = this;
                    self.addresses = [];
                    self.address = '';
                    self.address_confirmed = false;
                    self.postcode_distance = 0;

                    // if shipping address NEW selected then will load the postcodes
                    if (self.shipping_address === 'NEW') {
                        self.getPostcodes();
                    }
                },
                requested_hour: function (val) {
                    var self = this;
                    self.requested_minute = '00';
                    self.available_requested_time = '';

                    if(val) {
                        self.checkBusinessSchedule()
                    }
                },
                requested_minute: function (val) {
                    var self = this;
                    self.checkBusinessSchedule()
                },
                cart_total: function () {
                    const self = this;
                    self.checkDiscount();
                },

                full_cart_comment: function (val) {
                    var self = this;
                    localStorage.setItem('fullCartComment', val);
                },

                order_type: function () {
                    const self = this;

                    self.requested_hour = '';
                    self.available_requested_time = '';

                    var applied_coupon = JSON.parse(localStorage.getItem('applied_coupon') || null);
                    if (!applied_coupon) {
                        self.checkDiscount();
                    }

                    self.filterRequestedHour()

                }
            }
        }).mount('#app')

    </script>
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                location.reload();
            }
        });
        // Fix position of Checkout Location
        $(window).scroll(function (e) {
            var $el = $('.checkoutheader-branchname');
            var isPositionFixed = ($el.css('position') == 'fixed');
            var windowSize = $(window).width()
            if (windowSize <= 991) {
                if ($(this).scrollTop() > 150 && !isPositionFixed) {
                    $el.css({
                        'position': 'fixed',
                        'top': '51px',
                        'left': '0px',
                        'right': '0px',
                        'border-radius': '0px',
                        'border-top': '4px solid #fff',
                        'border-bottom': '2px solid #fff',
                        'z-index': '10'
                    });
                }
                if ($(this).scrollTop() < 150 && isPositionFixed) {
                    $el.css({
                        'position': 'static',
                        'top': '0px',
                        'border-radius': '5px',
                        'border-top': '0px',
                        'border-bottom': '0px'
                    });
                }
            } else {
                $el.css({
                    'position': 'static',
                    'top': '0px',
                    'border-radius': '5px',
                    'border-top': '0px',
                    'border-bottom': '0px'
                });
            }
        });
    </script>
@endpush
