@extends('layouts.app')

@section('title')
    Cart
@endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/checkoutprogressbar.css"/>
    <link rel="stylesheet" href="/assets/css/cart.css"/>
@endpush
@section('content')

    <section class="cart-section">
        <div class="container" v-cloak>
            <div class="cart-all-content" v-if="cart.length">
                {{-- Cart Table Content For Large Device --}}
                <div class="cart-table-content carttable-content-largedevice">
                    <table class="table table-responsive cart-tabledata">
                        <thead>
                        <tr>
                            <th class="carthead-description">Description</th>
                            <th class="carthead-quantity">Quantity</th>
                            <th class="carthead-price">Price</th>
                            <th class="carthead-action">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(val, index) in cart">
                            <td>
                                <div class="cart-product-image">
                                    <img v-if="val.product.files.length"
                                         :src="'{{config('api.apiUrl')}}/products/image/'+ val.product.files[0].file_name"
                                         :alt="val.product?.short_name"
                                    />

                                    <img v-else
                                         src="/assets/images/placeholder.jpg"
                                         :alt="val.product?.short_name">

                                    <div class="cart-product-details">
                                        <a :href="'/product/'+val.product?.uuid">
                                            <h4>@{{ val.product?.short_name || '' }}</h4>
                                        </a>
                                        <div v-for="sub in val.selected_components" class="hidden-mobile-tbody">
                                            <small>@{{ sub.relation_group }}: @{{ sub.short_name }}</small>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cart-product-quantity">
                                    <button class="btn quantitybtn" @click="updateQty('DECREASE', index)"><i
                                            class="fa-solid fa-minus"></i></button>
                                    <input type="number" placeholder="0" min="1" class="form-control quantityinput"
                                           :value="val.unit">
                                    <button class="btn quantitybtn" @click="updateQty('INCREASE', index)"><i
                                            class="fa-solid fa-plus"></i></button>
                                </div>
                            </td>
                            <td>
                                <div class="cart-product-prices">
                                    <span>{{config('app.currency')}}@{{ val.total_price }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="cart-product-remove">
                                    <a href="#" @click.prevent="removeItem(index)"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="cart-amount-content">
                        <div class="row">
                            <div class="col-6 col-sm-3 col-md-3">
                            </div>
                            <div class="col-6 col-sm-3 col-md-3">
                            </div>
                            <div class="col-6 col-sm-3 col-md-3">
                                <div class="cartamount-hold cartamount-subamount">
                                    <h6>Subtotal</h6>
                                    <p>{{config('app.currency')}}@{{ cart_total }}</p>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3 col-md-3">
                                <div class="cartamount-hold cartamount-totalamount">
                                    <h6>Total</h6>
                                    <p>{{config('app.currency')}}@{{ cart_total }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cart-table-mobilecontent">
                    <div class="mobilecart-product-item">
                        <div class="row align-items-center justify-space-between mcproduct-item-row" v-for="(val, index) in cart">
                            <div class="col-4 col-md-4">
                                <div class="mobilecartproduct-image">
                                    <img v-if="val.product.files.length"
                                         :src="'{{config('api.apiUrl')}}/products/image/'+ val.product.files[0].file_name"
                                         :alt="val.product?.short_name"
                                    />

                                    <img v-else
                                         src="/assets/images/placeholder.jpg"
                                         :alt="val.product?.short_name">
                                </div>
                            </div>
                            <div class="col-8 col-md-8">
                                <div class="row align-items-start justify-space-between">
                                    <div class="col-8 ps-0">
                                        <div class="mobilecart-detailsitem1">
                                            <div class="mobilecartproduct-name">
                                                <h4>@{{ val.product?.short_name }}</h4>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mobilecartproduct-remove">
                                            <a href="#" @click.prevent="removeItem(index)"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center justify-space-between row-alignment">
                                    <div class="col-7 ps-0 pe-2">
                                        <div class="mobilecart-detailsitem2">
                                            <div class="mobilecartproduct-quantity">
                                                <button class="btn mobilequantitybtn"
                                                        @click="updateQty('DECREASE', index)"><i
                                                        class="fa-solid fa-minus"></i></button>
                                                <input type="number" placeholder="0" readonly :value="val.qty"
                                                       class="form-control mobilequantityinput">
                                                <button class="btn mobilequantitybtn"
                                                        @click="updateQty('INCREASE', index)"><i
                                                        class="fa-solid fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5 ps-0">
                                        <div class="mobilecartproduct-price">
                                            <p>{{config('app.currency')}}@{{ val.price }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cart-amount-content">
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <div class="cartamount-hold cartamount-subamount">
                                    <h6>Subtotal</h6>
                                    <p>{{config('app.currency')}}@{{ cart_total }}</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="cartamount-hold cartamount-totalamount">
                                    <h6>Total</h6>
                                    <p>{{config('app.currency')}}@{{ cart_total }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-discount-checkoutbutton">
                    <div class="row align-items-end">
                        <div class="col-sm-8 col-md-7"></div>
                        <div class="col-sm-4 col-md-5">
                            <div class="checkout-button">
                                <a href="/checkout" class="btn quantitybtn checkoutbtn"><span><i
                                            class="fa-solid fa-lock"></i></span> Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cart-all-content text-center" v-else>
                <img src="/assets/images/empty-cart.png" class="mb-4" alt="">

                <p class="text-center">Your cart is empty!
                    <a href="/"><u>Start shopping</u></a>
                </p>
            </div>
        </div>
    </section>
    <!-- Cart All Content Section End  -->
@endsection

@push('script')
    <script>
        const {createApp} = Vue

        var app = createApp({
            data() {
                return {
                    message: 'Hello Vue!',

                    cart: JSON.parse(localStorage.getItem('cart')) || [],
                }
            },
            methods: {
                removeItem: function (index) {
                    const self = this;

                    self.cart.splice(index, 1);

                    app2.cart = self.cart;

                    localStorage.setItem('cart', JSON.stringify(self.cart));

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
                },
            },
            computed: {
                cart_total: function () {
                    var self = this;

                    var total_price = 0;
                    self.cart.forEach(function (val, key) {
                        total_price += (val.unit_price * val.unit);
                    });

                    return parseFloat(total_price.toFixed(2));
                },
            }
        }).mount('#app')

    </script>
@endpush
