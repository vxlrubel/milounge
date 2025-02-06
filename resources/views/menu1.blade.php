@extends('layouts.app')

@section('title') Our Menu @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/ourmenu.css"/>
@endpush

@section('content')

    <section class="our-menu-section">
        <div class="our-menu-overlay"></div>

        @if(count(cache('branches')) > 1)
            <div class="container">
                <div class="menu-header-branchname large-device">
                    <div class="row">
                        <div class="col-md-12 m-auto">
                            <div class="text-center header-branchname">
                                <h5>
                                    You are ordering
                                    to {{\App\Services\BranchService::currentName(\App\Services\BranchService::current())}}
                                    <a href="#" @click="openBranchModal()"
                                       class="ms-2 btn mainbtn-primary login-btn mt-1 mb-1 btn-sm"
                                       style="font-size: 14px">Change
                                        Shop</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{--Large Device--}}
        <div class="container" v-cloak>
            <div class="our-menus-content large-device">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div id="list-example" class="list-group menu-list" v-for="category in categories">
                                    <div class="menu-title">
                                        <h3>@{{ category.name }}</h3>
                                    </div>
                                    <div class="menu-list-allitem">
                                        <div class="" v-for="sub_category in category.sub_categories">
                                            <a class="list-group-item list-group-item-action menu-list-item"
                                               :href="'#'+sub_category.key">
                                                <div>
                                                    <span>
                                                        <i class="fa-solid fa-caret-right"></i>
                                                    </span>
                                                    @{{ sub_category.name }}
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true"
                                     class="scrollspy-example" tabindex="0">

                                    <div v-for="category in categories" :id="category.key">
                                        <div v-for="(sub_category, i) in category.sub_categories"
                                             class="all-list-item-content alllistitem-content-large">

                                            <div class="accordion" :id="'accordionExample' + sub_category.key"
                                                 v-if="sub_category">

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header category-accordion-header"
                                                        :id="sub_category.key">
                                                        <button class="accordion-button food-item-accordion-button"
                                                                type="button" data-bs-toggle="collapse"
                                                                :data-bs-target="'#cat'+sub_category.key"
                                                                aria-expanded="true"
                                                                :aria-controls="'cat'+ sub_category.key">
                                                            @{{ sub_category.name }}
                                                        </button>
                                                        <span v-if="sub_category.short_description">@{{ sub_category.short_description }}</span>
                                                    </h2>
                                                    <div :id="'cat'+ sub_category.key"
                                                         class="accordion-collapse collapse show"
                                                         :data-bs-parent="'#accordionExample' + sub_category.key">
                                                        <div class="accordion-body food-item-accordion-body">
                                                            <div v-if="sub_category.products?.length"
                                                                 v-for="product in sub_category.products"
                                                                 class="row align-items-start clickable-modal"
                                                                 @click="showProduct(product)">

                                                                <div class="col-md-9">
                                                                    <div class="food-item-name">
                                                                        <h3>@{{ product.short_name }}</h3>
                                                                        <p v-html="product.property?.short_description"
                                                                           class="food-description"></p>
                                                                        <div class="food-item-price">
                                                                            <p>
                                                                                <span
                                                                                    v-if="product.sub_products.length">from </span>{{config('app.currency')}}
                                                                                @{{ getProductPrice(product) }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="food-item-image">
                                                                        <img v-if="product.files?.length"
                                                                             :src="api_project_url + '/files/products/' + product.files[0]?.file_name"
                                                                             alt="">
                                                                    </div>
                                                                    <!-- <div class="food-item-addtocart">
                                                                        <a href="#" class="btn mainbtn-primary foodmenuitem-addbtn">Add</a>
                                                                    </div> -->
                                                                </div>
                                                            </div>

                                                            <div v-else>
                                                                <small>
                                                                    No product found!
                                                                </small>
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
                    <div class="col-md-4">
                        <div class="four-delivery-content">
                            <div class="four-dc-item">
                                <div class="four-dc-icon">
                                    <span><i class="fa-solid fa-bicycle"></i></span>
                                </div>
                                <p>Delivery From: @{{ delivery_from }}</p>
                            </div>
                            <div class="four-dc-item">
                                <div class="four-dc-icon">
                                    <span><i class="fa-solid fa-bag-shopping"></i></span>
                                </div>
                                <p>Collection From: @{{ collection_from }}</p>
                            </div>
                            <div class="four-dc-item">
                                <div class="four-dc-icon">
                                    <span><i class="fa-solid fa-clock"></i></span>
                                </div>
                                <p>
                                    Delivery: {{\App\Services\GlobalSettingService::key('estimated_delivery_duration_text') ?? '0'}}</p>
                            </div>
                            <div class="four-dc-item">
                                <div class="four-dc-icon">
                                    <span><i class="fa-solid fa-user-clock"></i></span>
                                </div>
                                <p>
                                    Collection: {{\App\Services\GlobalSettingService::key('estimated_collection_duration_text') ?? '0'}}</p>
                            </div>
                        </div>

                        <div class="product-offer-box" v-if="discount_products.length">
                            <div class="po-box-header">
                                <h5><span><i class="fa-solid fa-gift"></i></span>Offers</h5>
                            </div>
                            <div class="po-box-body">
                                <p v-for="val in discount_products">@{{ val.description }}</p>
                            </div>
                        </div>

                        {{-- Cart --}}
                        <div class="product-busket">
                            <div class="product-busket-heading">
                                <div class="busket-title">
                                    <h5><span><i class="fa-solid fa-basket-shopping"></i></span> Your Basket</h5>
                                </div>
                                <div class="busket-item">
                                    <div class="busket-item-box">
                                        @{{ cart?.length }}
                                    </div>
                                </div>
                            </div>

                            <div v-if="cart?.length" class="product-busket-body">

                                <div class="product-busket-heightcontrol">
                                    <div v-for="(val, index) in cart" class="busket-product-item">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="busket-productitem-title">
                                                    <h3>@{{ val.product.short_name || '' }}</h3>

                                                    <div>
                                                        <p v-if="val.selected_components_N.length"
                                                           v-for="component in val.selected_components_N">
                                                            <small>- @{{ component.short_name }}</small>
                                                            <small v-if="component.sub_components[0]?.uuid">
                                                                (@{{ component.sub_components[0].short_name ||
                                                                '' }})
                                                            </small>
                                                        </p>

                                                        <p v-if="val.selected_components.length"
                                                           v-for="component in val.selected_components">
                                                            <small
                                                                v-show="!['None'].includes(component.short_name)">-
                                                                @{{ component.short_name }}
                                                            </small>
                                                            <br>
                                                            <small v-if="component?.selected_sub_components">
                                                                <small v-for="sub_component in component.selected_sub_components">
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
                                            <div class="col-md-12">
                                                <div class="busket-productitem-comment">
                                                    <input type="text"
                                                           class="form-control form-control-sm busket-comment-form-control"
                                                           :value="cart[index].comment"
                                                           @keyup="updateCartComment(index, $event.target.value)"
                                                           placeholder="Enter comment(if any)">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="busket-productitem-action">
                                                    <div class="busket-product-quantity">
                                                        <div class="quantityincrease">
                                                            <button @click="updateCartUnit('DECREASE', index)"
                                                                    class="btn mainbtn-primary quantitybtn text-white"><span><i
                                                                        class="fa-solid fa-minus"></i></span></button>
                                                            <input type="number" class="form-control quantityfield"
                                                                   :value="val.unit"
                                                                   placeholder="0" readonly>
                                                            <button @click="updateCartUnit('INCREASE', index)"
                                                                    class="btn mainbtn-primary quantitybtn text-white"><span><i
                                                                        class="fa-solid fa-plus"></i></span></button>
                                                        </div>
                                                    </div>
                                                    <div class="busket-product-action">
                                                        <div class="busket-product-price">
                                                            {{config('app.currency')}}@{{ val.total_price || 0.00 }}
                                                        </div>
                                                        <div class="p-action">
                                                            <a href="#" @click.prevent="removeCart(index)"><i
                                                                    class="fa-solid fa-trash text-white"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="busket-subtotal">
                                    <div class="subtotal-amount">
                                        <p>Sub Total : <span>{{config('app.currency')}}@{{ cart_total }}</span></p>
                                    </div>
                                    <div class="busket-product-commentbox">
                                        <label><span><i class="fa-solid fa-comment"></i></span>Comment</label>
                                        <textarea name="" id="" cols="30" rows="3"
                                                  class="form-control comment-textarea-formcontrol"
                                                  placeholder="Write your comment here (if any)"
                                                  v-model="full_cart_comment">@{{ full_cart_comment }}</textarea>
                                    </div>
                                    <div class="checkout-button">
                                        <a href="/checkout"
                                           class="btn mainbtn-primary busketcheckoutbtn">Checkout to @{{ branch_name
                                            }}</a>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="product-busket-body">
                                <div class="row ">
                                    <div class="col-md-12 m-1">
                                        <p class="text-center">
                                            <small>
                                                Your Cart is empty...!
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--MOBILE--}}
        <div class="our-menus-mobilecontent mobile-device" v-cloak>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {{--<div data-bs-spy="scroll" data-bs-target="#mobileMenuSlide" data-bs-offset="50"
                             class="scrollspy-example" tabindex="0">
                        </div>--}}

                        <div class="accordion allaccordion-menu-items mb-3" v-for="(category, index) in categories"
                             :id="'mobileAccordionExample'+ category.key">
                            <div v-for="(sub_category, index) in category.sub_categories">
                                <div class="accordion-item main-menu-all-item" :id="'cat'+ sub_category.key">
                                    <h2 class="accordion-header category-accordion-header">
                                        <button class="accordion-button category-accordionbutton-mobile collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                :data-bs-target="'#mobilecollapse'+sub_category.key"
                                                aria-expanded="false"
                                                :aria-controls="'mobilecollapse'+sub_category.key"
                                                @click="scrollToTop('mobilecollapse'+sub_category.key)"
                                        >
                                            @{{ sub_category.name }}
                                        </button>
                                        <span v-if="sub_category.short_description">@{{ sub_category.short_description }}</span>
                                    </h2>
                                    <div :id="'mobilecollapse'+sub_category.key" class="accordion-collapse collapse"
                                         :data-bs-parent="'#mobileAccordionExample'+ category.key"
                                    >
                                        <div class="accordion-body mobilefood-accordion-body">
                                            <div class="row align-items-start mobile-fooditem-row clickable-modal"
                                                 v-for="product in sub_category.products" @click="showProduct(product)">
                                                <div class="col-9 col-md-9">
                                                    <div class="food-item-name">
                                                        <h3>@{{ product.short_name }}</h3>
                                                        <p v-html="product.property?.short_description"
                                                           class="food-description"></p>
                                                        <div class="food-item-price">
                                                            <p><span
                                                                    v-if="product.sub_products.length">from </span> {{config('app.currency')}}
                                                                @{{ getProductPrice(product) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3 col-md-3">
                                                    <div class="food-item-image">
                                                        <img v-if="product.files?.length"
                                                             :src="api_project_url + '/files/products/' + product.files[0]?.file_name"
                                                             alt="">
                                                    </div>
                                                    <!-- <div class="food-item-addtocart">
                                                        <button type="button" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#subItemModal"
                                                                class="btn mainbtn-primary menuitem-add-btn">Add
                                                        </button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="four-delivery-content" id="mobileBasket">
                                    <div class="four-dc-item">
                                        <div class="four-dc-icon">
                                            <span><i class="fa-solid fa-bicycle"></i></span>
                                        </div>
                                        <p>Delivery From: @{{ delivery_from }}</p>
                                    </div>
                                    <div class="four-dc-item">
                                        <div class="four-dc-icon">
                                            <span><i class="fa-solid fa-bag-shopping"></i></span>
                                        </div>
                                        <p>Collection From: @{{ collection_from }}</p>
                                    </div>
                                    <div class="four-dc-item">
                                        <div class="four-dc-icon">
                                            <span><i class="fa-solid fa-clock"></i></span>
                                        </div>
                                        <p>
                                            Delivery: {{\App\Services\GlobalSettingService::key('estimated_delivery_duration_text') ?? '0'}}</p>
                                    </div>
                                    <div class="four-dc-item">
                                        <div class="four-dc-icon">
                                            <span><i class="fa-solid fa-user-clock"></i></span>
                                        </div>
                                        <p>
                                            Collection: {{\App\Services\GlobalSettingService::key('estimated_collection_duration_text') ?? '0'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="product-offer-box" v-if="discount_products.length">
                                <div class="po-box-header">
                                    <h5><span><i class="fa-solid fa-gift"></i></span>Offers</h5>
                                </div>
                                <div class="po-box-body">
                                    <p v-for="val in discount_products">@{{ val.description }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="product-busket mobile-product-busket">
                                <div class="product-busket-heading">
                                    <div class="busket-title">
                                        <h5><span><i class="fa-solid fa-basket-shopping"></i></span> Your Basket</h5>
                                    </div>
                                    <div class="busket-item">
                                        <div class="busket-item-box">
                                            @{{ cart?.length }}
                                        </div>
                                    </div>
                                </div>
                                <div v-if="cart?.length" class="product-busket-body">

                                    <div v-for="(val, index) in cart" class="busket-product-item">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="busket-productitem-title">
                                                    <h3>@{{ val.product.short_name || '' }}</h3>
                                                    <div>
                                                        <p v-if="val.selected_components_N.length"
                                                           v-for="component in val.selected_components_N">
                                                            <small>- @{{ component.short_name }} x @{{ component.unit
                                                                }}</small>
                                                        </p>

                                                        <p v-if="val.selected_components.length"
                                                           v-for="component in val.selected_components">
                                                            <small
                                                                v-show="!['None'].includes(component.short_name)">-
                                                                @{{ component.short_name }}
                                                            </small>
                                                            <small v-if="component.selected_sub_components[0]?.uuid">
                                                                (@{{ component.selected_sub_components[0].short_name ||
                                                                '' }})
                                                            </small>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="busket-productitem-comment">
                                                    <input type="text" class="form-control product-comment-formcontrol"
                                                           v-model="cart[index].comment"
                                                           @keyup="updateCartComment(index, $event.target.value)"
                                                           placeholder="Enter comment(if any)">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="busket-productitem-action">
                                                    <div class="busket-product-quantity">
                                                        <div class="quantityincrease">
                                                            <button @click="updateCartUnit('DECREASE', index)"
                                                                    class="btn mainbtn-primary quantitybtn"><span><i
                                                                        class="fa-solid fa-minus"></i></span></button>
                                                            <input type="number" class="form-control quantityfield"
                                                                   :value="val.unit"
                                                                   placeholder="0">
                                                            <button @click="updateCartUnit('INCREASE', index)"
                                                                    class="btn mainbtn-primary quantitybtn"><span><i
                                                                        class="fa-solid fa-plus"></i></span></button>
                                                        </div>
                                                    </div>
                                                    <div class="busket-product-action">
                                                        <div class="busket-product-price">
                                                            {{config('app.currency')}}@{{ val.total_price || 0.00 }}
                                                        </div>
                                                        <div class="p-action">
                                                            <span @click.prevent="removeCart(index)"><i
                                                                    class="fa-solid fa-trash"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="busket-subtotal">
                                        <div class="subtotal-amount">
                                            <p>Sub Total : <span>{{config('app.currency')}}@{{ cart_total }}</span></p>
                                        </div>
                                    </div>
                                    <div class="busket-product-commentbox">
                                        <label><span><i class="fa-solid fa-comment"></i></span>Comment</label>
                                        <textarea name="" id="" cols="30" rows="3"
                                                  class="form-control comment-textarea-formcontrol"
                                                  placeholder="Write your comment here (if any)"
                                                  v-model="full_cart_comment">@{{ full_cart_comment }}</textarea>
                                    </div>
                                    <div class="checkout-button text-center mt-0 pb-3">
                                        <a href="/checkout#checkoutAllContent"
                                           class="btn mainbtn-primary busketcheckoutbtn">Checkout to @{{ branch_name
                                            }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mobile-cart-checkout">
                                <div class="mobile-cart-checkout-hold">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                        <!-- <div class="mobile-basket-button">
                                                <a href="#mobileBasket">View Basket (@{{ cart.length }}) {{config('app.currency')}}@{{ cart_total }}</a>
                                            </div> -->
                                            <a href="#mobileBasket">
                                                <div class="mobile-basket-button">
                                                    <div class="mobilebusket-icon">
                                                        <div class="mobile-basket-buttonicon"><i
                                                                class="fa-solid fa-basket-shopping"></i></div>
                                                        <span class="busket-totalitem">@{{ cart.length }}</span>
                                                    </div>
                                                    <div class="mobilebusket-amount">
                                                        <p>{{config('app.currency')}}@{{ cart_total }}</p>
                                                        <p><small>View Basket</small></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <div class="mobile-checkout-button">
                                                <a href="/checkout#checkoutAllContent">Go to Checkout <i
                                                        class="fa-solid fa-arrow-right mt-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mobile-separator"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <div class="modal fade" id="subItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="subItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content food-subItem-content" v-if="product">
                <div class="modal-header foodsubitem-modal-header">
                    <h1 class="modal-title" id="subItemModalLabel">@{{ product.short_name }}</h1>
                    <button type="button" class="btn-close subitem-modal-closebtn" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body foodsubitem-modal-body subitem-modal-body">

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <p class="m-auto ps-3 pe-3 text-center">
                                <small>@{{ product.property?.short_description ?? '' }}</small>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-6 col-md-4 m-auto">
                                    <div class="foodsubitem-modal-image">
                                        <img v-if="product.files?.length"
                                             :src="api_project_url + '/files/products/' + product.files[0]?.file_name"
                                             alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-10 col-md-9 m-auto text-center">
                                    <div class="foodsubitem-price">
                                        <p>
                                            <span
                                                v-if="product.sub_products.length">from </span> {{config('app.currency')}}
                                            @{{ getProductPrice(product) }}
                                        </p>
                                    </div>
                                    <div class="foodsubitem-description">
                                        <div v-html="product.description"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--One OF relation--}}
                    <div class="row" v-for="(one_of, index) in ONE_OF_components">
                        <div class="col-12">
                            <div class="fooditem-modal-header">
                                <h3>@{{ one_of[0] }}</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row foodsubitem-content-row">
                                <div class="col-12">
                                    <div class="d-grid items-parent">
                                        <div class="items-grid position-relative" v-for="(component, k) in one_of[1]">
                                            <input class="form-check-input sub-item-selectcheck" type="radio"
                                                   :name="one_of[0]" :id="component.product?.uuid"
                                                   v-model="selected_components[index].uuid"
                                                   :value="component.product?.uuid"
                                                   @click="updateSelectedComponent(index, component)"
                                            >
                                            <label :for="component.product?.uuid"
                                                   class="d-flex flex-wrap justify-content-center small h-100 w-100 align-items-center text-center p-3 border border-2">
                                                <span class="me-1">@{{ component.product?.short_name }}</span>

                                                <span class="small" v-if="component.price">
                                                    +{{config('app.currency')}}@{{ component.price.toFixed(2)}}
                                                </span>
                                            </label>
                                            <span v-if="component.product?.sub_products.length"
                                                  class="exists-sub-product"><i class="fa-solid fa-plus"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 subcomponent-selected-item"
                                     v-if="selected_components[index].selected_sub_components.length">
                                    <span class="me-2"
                                          v-for="ssc in selected_components[index].selected_sub_components">@{{ ssc.short_name || '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--N relation--}}
                    <div class="row" v-for="(n, index) in N_components">
                        <div class="col-12 mt-2">
                            <div class="fooditem-modal-header">
                                <h3>@{{ n[0] }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 foodextra-col" v-for="(component, k) in n[1]">
                            <div class="sub-item-extra-content">
                                <div class="form-check d-flex align-items-center justify-content-between">
                                    <div>
                                        <input class="form-check-input form-extraitem-check" type="checkbox"
                                               :value="component.product?.uuid"
                                               :name="component.product.uuid"
                                               :id="'chk_'+component.product.uuid"
                                               {{--:checked="selected_components_N[k]?.checked"--}}
                                               @click="updateSelectedComponentN($event, component)"
                                        >
                                        <label class="form-check-label form-extraitem-label"
                                               :for="'chk_'+component.product?.uuid">
                                            @{{ component.product?.short_name }}
                                        </label>
                                    </div>

                                    <div class="subcomponent-selected-item"
                                         v-if="getSelectedComponentNSelectedSubComponent(component)">
                                        <span>@{{ getSelectedComponentNSelectedSubComponent(component) }}</span>
                                    </div>

                                    <div>
                                        <p v-if="component?.price">+@{{ component?.price }}</p>
                                    </div>
                                </div>
                                {{--<div class="quantityincrease mobile-extraitem-quantity">
                                    <button class="btn mainbtn-primary quantitybtn"
                                            @click="updateQtySelectedComponentN('DECREASE', component)"><span><i
                                                class="fa-solid fa-minus"></i></span></button>
                                    <input type="number" class="form-control quantityfield" placeholder="0" step="1"
                                           min="0" max="10"
                                           :id="'unit_'+component.product.uuid"
                                           :value="selected_components_N[getSelectedComponentNIndex(component)]?.unit"
                                           readonly>
                                    <button class="btn mainbtn-primary quantitybtn"
                                            @click="updateQtySelectedComponentN('INCREASE', component)"><span><i
                                                class="fa-solid fa-plus"></i></span></button>
                                </div>--}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="comment-area">
                                <textarea class="form-control modal-text-form-control" cols="30" rows="3"
                                          v-model="comment"
                                          placeholder="Special instructions (if any)"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer sub-item-modal-footer foodsubitem-modal-footer">

                    <div class="row justify-content-center mt-3">
                        <div class="col-md-12 text-center mb-3">

                            <p v-if="error.max_unit_from_N_component">
                                <small class="text-danger">
                                    @{{ error.max_unit_from_N_component }}
                                </small>
                            </p>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-3 col-3 text-end">
                                    <button type="button" class="btn btn-secondary me-2"
                                            @click="updateUnit('DECREASE')"><i class="fa fa-minus"></i></button>
                                </div>
                                <div class="col-md-3 col-3">
                                    <input type="number" readonly v-model="unit" class="form-control"
                                           style="border: 0px; font-size: xx-large; text-align: center">
                                </div>
                                <div class="col-md-3 col-3 text-start">
                                    <button type="button" class="btn btn-secondary me-2"
                                            @click="updateUnit('INCREASE')"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 text-center">
                            {{--<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>--}}
                            <button type="button" class="btn mainbtn-primary pointer-event subitem-cartadd-btn"
                                    @click.prevent="addToCart()">{{config('app.currency')}}@{{ per_item_total }} Add to
                                Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade subcomponent-modal" id="subComponentModal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="subComponentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content food-subItem-content food-subcomponent-content">
                <div class="modal-header foodsubitem-modal-header">
                    <h1 class="modal-title" id="subComponentModalLabel">@{{ product?.short_name }} > @{{
                        selected_component?.product?.short_name }}</h1>
                    <button type="button" class="btn-close subitem-modal-closebtn" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body foodsubitem-modal-body"
                     style="height: 70vh; overflow-x: hidden; overflow-y: auto">

                    {{--One OF relation--}}
                    <div class="row mb-3" v-if="sub_components?.length" v-for="(components, index) in sub_components">
                        <div class="col-12">
                            <div class="fooditem-modal-header">
                                <h3>@{{ components[0] }}</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row foodsubitem-content-row">
                                <div class="col-12">
                                    <div class="d-grid items-parent">
                                        <div class="items-grid position-relative"
                                             v-for="(component, k) in components[1]">
                                            <input class="form-check-input sub-item-selectcheck" type="radio"
                                                   :name="'sub_component_'+components[0]" :id="component.product?.uuid"
                                                   v-model="selected_sub_components[index].uuid"
                                                   :value="component.product?.uuid"
                                                   @click="updateSelectedSubComponent(index, component)"
                                            >
                                            <label :for="component.product?.uuid"
                                                   class="d-flex flex-wrap justify-content-center small h-100 w-100 align-items-center text-center p-3 border border-2">
                                                <span class="me-1">@{{ component.product?.short_name }}</span>

                                                <span class="small" v-if="component?.price">
                                                    +{{config('app.currency')}}@{{ component.price.toFixed(2)}}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-if="Object.keys(sub_components_N2).length">
                        <div class="col-md-12">
                            <div v-if="selected_component" class="text-center border-bottom">
                                Maximum unit @{{ selected_component.max_unit }} <br>
                                Selected unit @{{ selectedNComponentTotalSelectedUnit }} <br>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="Object.keys(sub_components_N2).length"
                         v-for="(sub_components, index) in sub_components_N2">
                        <div class="col-12 mt-2">
                            <div class="fooditem-modal-header">
                                <h3>@{{ index }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 foodextra-col" v-for="(component, k) in sub_components">
                            <div class="sub-item-extra-content">
                                <div class="form-check d-flex align-items-center justify-content-between">
                                    <div style="width: 70%">
                                        <input class="form-check-input form-extraitem-check" type="checkbox"
                                               :value="component.product?.uuid"
                                               :name="component.product?.uuid"
                                               :id="'chk_'+component.product?.uuid"
                                               {{--:checked="selected_components_N[k]?.checked"--}}
                                               @click="select3rdLevelComponentN($event, component)"
                                        >
                                        <label class="form-check-label form-extraitem-label"
                                               :for="'chk_'+component.product?.uuid">
                                            @{{ component.product?.short_name }} <span v-if="component?.price">+{{config('app.currency')}}@{{ component?.price }}</span>
                                        </label>
                                    </div>

                                    <div class="quantityincrease mobile-extraitem-quantity">
                                        <button class="btn mainbtn-primary quantitybtn"
                                                @click="updateQty3rdLevelComponentN('DECREASE', component)"><span><i
                                                    class="fa-solid fa-minus"></i></span></button>
                                        <input type="number" class="form-control quantityfield" placeholder="1" step="1"
                                               min="0" max="10"
                                               :id="'unit_'+component.product?.id"
                                               readonly>
                                        <button class="btn mainbtn-primary quantitybtn"
                                                @click="updateQty3rdLevelComponentN('INCREASE', component)"><span><i
                                                    class="fa-solid fa-plus"></i></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer sub-item-modal-footer">
                    <div class="row w-100">
                        <div class="col-6">
                            <button type="button" class="btn w-100 btn-warning px-4" data-bs-dismiss="modal">Ok</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn w-100 btn-danger px-4" data-bs-dismiss="modal">Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade subcomponent-modal" id="subComponentNModal" data-bs-backdrop="static"
         data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="subComponentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered subComponentNModal modal-dialog-scrollable">
            <div class="modal-content food-subItem-content food-subcomponent-content">
                <div class="modal-header foodsubitem-modal-header">
                    <h1 class="modal-title" id="subComponentModalLabel">@{{ product?.short_name }} > @{{
                        selected_component?.product?.short_name }}</h1>
                    <button type="button" class="btn-close subitem-modal-closebtn" data-bs-dismiss="modal"
                            aria-label="Close" @click="clear3rdLevelNComponent()"></button>
                </div>

                <div v-if="selected_component" class="text-center border-bottom">
                    Maximum unit @{{ selected_component.max_unit }} <br>
                    Selected unit @{{ selectedNComponentTotalSelectedUnit }} <br>
                </div>

                <div class="modal-body foodsubitem-modal-body"
                     style="height: 70vh; overflow-x: hidden; overflow-y: auto">

                    {{--N relation--}}
                    <div class="row" v-if="Object.keys(sub_components_N2).length"
                         v-for="(sub_components, index) in sub_components_N2">
                        <div class="col-12 mt-2">
                            <div class="fooditem-modal-header">
                                <h3>@{{ index }}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 foodextra-col" v-for="(component, k) in sub_components">
                            <div class="sub-item-extra-content">
                                <div class="form-check d-flex align-items-center justify-content-between">
                                    <div style="width: 70%">
                                        <input class="form-check-input form-extraitem-check" type="checkbox"
                                               :value="component.product?.uuid"
                                               :name="component.product?.uuid"
                                               :id="'chk_'+component.product?.uuid"
                                               {{--:checked="selected_components_N[k]?.checked"--}}
                                               @click="select3rdLevelComponentN($event, component)"
                                        >
                                        <label class="form-check-label form-extraitem-label"
                                               :for="'chk_'+component.product?.uuid">
                                            @{{ component.product?.short_name }} <span v-if="component?.price">+{{config('app.currency')}}@{{ component?.price }}</span>
                                        </label>
                                    </div>

                                    <div class="quantityincrease mobile-extraitem-quantity">
                                        <button class="btn mainbtn-primary quantitybtn"
                                                @click="updateQty3rdLevelComponentN('DECREASE', component)"><span><i
                                                    class="fa-solid fa-minus"></i></span></button>
                                        <input type="number" class="form-control quantityfield" placeholder="1" step="1"
                                               min="0" max="10"
                                               :id="'unit_'+component.product?.id"
                                               readonly>
                                        <button class="btn mainbtn-primary quantitybtn"
                                                @click="updateQty3rdLevelComponentN('INCREASE', component)"><span><i
                                                    class="fa-solid fa-plus"></i></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer sub-item-modal-footer">
                    <div class="row w-100">
                        <div class="col-6">
                            <button type="button" class="btn w-100 btn-warning px-4" @click="add3rdLevelNComponent">Ok
                            </button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn w-100 btn-danger px-4" @click="clear3rdLevelNComponent"
                                    data-bs-dismiss="modal">Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade subcomponentN-modal" id="subComponentForNComponentModal" data-bs-backdrop="static"
         data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="subComponentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content food-subItem-content food-subcomponent-content" v-if="sub_components_N?.length">
                <div class="modal-header foodsubitem-modal-header">
                    <h1 class="modal-title" id="subComponentModalLabel">@{{ product.short_name }}</h1>
                    <button type="button" class="btn-close subitem-modal-closebtn" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body foodsubitem-modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="fooditem-modal-header">
                                <h3>Options</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row foodsubitem-content-row">
                                <div class="col-6 col-md-4" v-for="(component, index) in sub_components_N">
                                    <div class="sub-item-content">
                                        <div class="sub-item-formcheck">
                                            <input class="form-check-input sub-item-selectcheck" type="radio"
                                                   :name="component.product?.uuid" :id="component.product?.uuid"
                                                   v-model="selected_sub_component_N.uuid"
                                                   :value="component.product?.uuid"
                                                   @click="updateSelectedSubComponentN(index, component)"
                                            >
                                            <label class="subitem-label"
                                                   :for="component.product?.uuid">
                                                <p>@{{ component.product?.short_name }}</p>
                                                <br>
                                                <div>
                                                    <small
                                                        v-if="component.product?.price?.price">+{{config('app.currency')}}
                                                        @{{ component.product?.price?.price }}</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer sub-item-modal-footer">
                    <div class="row w-100">
                        <div class="col-6">
                            <button type="button" class="btn w-100 btn-warning px-4" data-bs-dismiss="modal">Ok</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn w-100 btn-danger px-4" data-bs-dismiss="modal">Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="shopModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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
                                        <a href="/{{$branch->value}}/menu" class="btn mainbtn-primary me-2"
                                           @click.prevent="update_branch('{{$branch->value}}')"> {{$branch->name?? ''}} </a>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--Splash Screen--}}
    <div class="modal fade splashScreenModal" id="splashScreenModal"
         tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0" v-if="advertise_splash_screen">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{config('app.name')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img :src="api_project_url + '/images/splash_screen/1.jpg'"
                         alt="{{config('app.name')}} Splash screen image" style="width: 100%">
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
                    message: 'Hello Vue!',

                    branches: @json(cache('branches')),
                    branch: '{{session('branch')}}',
                    branch_name: '{{\App\Services\BranchService::currentName(\App\Services\BranchService::current())}}',

                    api_url: '{{config('api.apiUrl')}}',
                    api_project_url: '{{config('api.apiProjectUrl')}}',

                    categories: @json($categories ?? []),
                    cached_products: @json($products ?? []),

                    discount_products: @json($discount_products ?? []),

                    products: [],

                    cart: JSON.parse(localStorage.getItem('cart')) || [],
                    full_cart_comment: localStorage.getItem('fullCartComment') || '',

                    selected_component: null,

                    product: null,
                    unit: 1,
                    N_components: [],
                    ONE_OF_components: [],
                    selected_components: [
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            price: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            price: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            price: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            price: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            price: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                    ],
                    selected_components_N: [],
                    comment: '',

                    sub_components: [],
                    sub_components_N: [],
                    sub_components_N2: [],
                    selected_sub_components: [
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                        }, {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                        }, {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                        }, {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                        }, {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                        },
                    ],
                    selected_sub_component: {
                        uuid: '',
                        short_name: '',
                        relation_group: '',
                        relation_type: '',
                        unit: 0
                    },
                    selected_sub_component_N: {
                        uuid: '',
                        short_name: '',
                        relation_group: '',
                        relation_type: '',
                        unit: 0,
                        parent_index: ''
                    },

                    gs: @json(\App\Services\GlobalSettingService::all() ?? []),
                    delivery_from: '',
                    collection_from: '',

                    advertise_splash_screen: false,

                    selected_3rd_level_N: [],

                    error: {
                        max_unit_from_N_component: ''
                    }

                }
            },
            mounted() {
                const self = this;

                // for mobile device top slider
                var owl = $(".owl-carousel");

                owl.owlCarousel({
                    loop: false,
                    margin: 25,
                    autoWidth: true,
                    autoplay: false,
                    autoplayTimeout: 15000,
                    stagePadding: 0,
                    nav: false,
                    dots: false,
                    center: false,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        1000: {
                            items: 3
                        }
                    }
                });

                // Fix position of slider
                $(window).scroll(function (e) {
                    var $el = $('.mobile-menu-list-item');
                    var isPositionFixed = ($el.css('position') == 'fixed');
                    if ($(this).scrollTop() > 150 && !isPositionFixed) {
                        $el.css({
                            'position': 'fixed',
                            'top': '51px',
                            'margin-bottom': '30px',
                            'border-radius': '0px',
                            'border-top': '2px solid #fff'
                        });
                    }
                    if ($(this).scrollTop() < 150 && isPositionFixed) {
                        $el.css({
                            'position': 'static',
                            'top': '0px',
                            'margin-bottom': '0px',
                            'border-radius': '5px'
                        });
                    }
                });

                // active the selected category: from mobile sldider
                $('.mobile-menu-list-item .owl-item a').on('click', function () {
                    $(this).addClass('active-item').siblings().removeClass('active-item');
                });

                // Gap on the top when select category
                $(".mobile-menu-list-item").on('click', 'a', function (event) {
                    event.preventDefault();
                    var screen_width = screen.width;
                    var gap = $(".mobile-header-menu").outerHeight(true);
                    if (screen_width > 767) {
                        gap = 21;
                    } else {
                        gap = 100;
                    }
                    var o = $($(this).attr("href")).offset();
                    var sT = o.top - gap; // get the fixedbar height
                    // compute the correct offset and scroll to it.
                    window.scrollTo(0, sT);
                });

                // Gap on top of basket
                $(".mobile-basket-button").on('click', 'a', function (event) {
                    event.preventDefault();
                    var screen_width = screen.width;
                    var gap = $(".mobile-header-menu").outerHeight(true);
                    if (screen_width > 767) {
                        gap = 21;
                    } else {
                        gap = 100;
                    }
                    var o = $($(this).attr("href")).offset();
                    var sT = o.top - gap; // get the fixedbar height
                    // compute the correct offset and scroll to it.
                    window.scrollTo(0, sT);
                });


                // Gap on the top when select category For Large
                $(".menu-list-item").on('click', 'a', function (event) {
                    event.preventDefault();
                    var screen_width = screen.width;
                    var gap = $(".header-large-device").outerHeight(true);
                    if (screen_width > 767) {
                        gap = 5;
                    } else {
                        gap = 50;
                    }
                    var o = $($(this).attr("href")).offset();
                    var sT = o.top - gap; // get the fixedbar height
                    // compute the correct offset and scroll to it.
                    window.scrollTo(0, sT);
                });

                // mobile top category slide
                /*$(document).ready(function () {
                    var sectionIds = $('.cat-menu-item');

                    $(document).scroll(function () {
                        sectionIds.each(function () {

                            var container = $(this).attr('href');
                            var containerOffset = $(container).offset().top;
                            var containerHeight = $(container).outerHeight();
                            var containerBottom = containerOffset + containerHeight;
                            var scrollPosition = $(document).scrollTop();
                            if (scrollPosition < containerBottom - 80 && scrollPosition >= containerOffset - 110) {

                                var activeItemIndex = $(this).parent().parent().index();

                                owl.trigger('to.owl.carousel', activeItemIndex);

                                $(this).addClass('active-item').siblings().removeClass('active-item');
                            } else {
                                $(this).removeClass('active-item');
                            }

                        });
                    });
                });*/

                // filter discount_products
                self.discount_products = self.discount_products.filter(function (dp) {
                    var is_coupon = dp.property?.is_coupon || null;
                    if(is_coupon) {
                        return is_coupon === 'FALSE'
                    }else{
                        return true
                    }
                })
            },

            created() {
                const self = this;

                const result = {};

                if (self.cached_products.length > 0) {

                    // add products under category
                    self.categories.forEach(function (category, index) {
                        category.sub_categories.forEach(function (sub_category, i) {

                            /*self.cached_products.forEach(function (item, key) {
                                var category = item.property ? item.property?.category : 'Unknown Category';
                                if (!result[category]) {
                                    result[category] = [];
                                }
                                result[category].push(item);
                            });*/

                            var products = self.cached_products.filter(function (p) {
                                return p.property?.category === sub_category.key
                            })
                            products = products.sort((a, b) => a.sort_order - b.sort_order);

                            sub_category.products = products;
                        });
                    });

                    //self.products = result

                }

                var date = moment().format('dddd');
                date = date.toLocaleLowerCase(); // sunday
                var delivery_from_key = 'delivery_from_' + date;
                var delivery_from = self.gs[delivery_from_key] || null;
                if (delivery_from) {
                    self.delivery_from = moment(delivery_from, "HH:mm:ss").format('HH:mm')
                }
                var collection_from_key = 'collection_from_' + date;
                var collection_from = self.gs[collection_from_key] || null;
                if (delivery_from) {
                    self.collection_from = moment(collection_from, "HH:mm:ss").format('HH:mm')
                }

                if (self.branches.length > 1 && !self.branch) {
                    setTimeout(function () {
                        $("#shopModal").modal('show');
                    }, 500);
                }

                // advertise_splash_screen
                var advertise_splash_screen = self.gs?.advertise_splash_screen ?? 'FALSE';
                if (advertise_splash_screen === 'TRUE') {

                    self.advertise_splash_screen = true;

                    self.check_advertise_time();

                    var advertise_shown = localStorage.getItem('advertise_shown');
                    if (!advertise_shown || advertise_shown === '0') {
                        setTimeout(function () {
                            localStorage.setItem('advertise_shown', 1);
                            localStorage.setItem('advertise_expire_time', moment().add(2, 'hours').format('YYYY-MM-DD HH:mm:ss'));
                            $("#splashScreenModal").modal('show');
                        }, 1000);
                    }

                }

            },
            methods: {
                groupBy: function (arr, key) {
                    return arr.reduce((acc, curr) => {
                        (acc[curr[key]] = acc[curr[key]] || []).push(curr);
                        return acc;
                    }, {});
                },

                getCategoryName: function (value) {
                    var self = this;
                    if (value) {
                        var category = self.categories[0]?.sub_categories.find(function (val) {
                            return val.key === value;
                        })
                        return category?.name || 'Unknown';
                    } else {
                        return 'Unknown';
                    }
                },
                getCategoryDescription: function (value) {
                    var self = this;
                    if (value) {
                        var category = self.categories[0]?.sub_categories.find(function (val) {
                            return val.key === value;
                        })
                        return category?.description || '';
                    } else {
                        return '';
                    }
                },

                showProduct: function (product = null) {
                    var self = this;

                    self.product = product;
                    self.unit = 1;

                    // Clear all selected components
                    self.selected_components = [
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: [],
                            selected_sub_components: [],
                        },
                    ];

                    // Clear all selected components N
                    self.selected_components_N = [];

                    // Clear all sub components
                    self.sub_components = [];

                    // Clear selected subcomponents
                    self.selected_sub_component = {
                        uuid: '',
                        short_name: '',
                        relation_group: '',
                        relation_type: '',
                        unit: 0,
                        parent_index: null,
                    };

                    // all components
                    var components = product.sub_products || [];

                    components.sort(function (a, b) {
                        return a.sort_order_group - b.sort_order_group;
                    });

                    var result = {};
                    var result_N = {};
                    var result_ONE_OF = {};

                    // grouping by relation group
                    components.forEach(function (item, key) {
                        if (!result[item.relation_group]) {
                            result[item.relation_group] = [];
                        }
                        result[item.relation_group].push(item);

                        if (item.relation_type === 'ONE_OF') {
                            if (!result_ONE_OF[item.relation_group]) {
                                result_ONE_OF[item.relation_group] = [];
                            }
                            result_ONE_OF[item.relation_group].push(item);
                        }
                        if (item.relation_type === 'N') {
                            if (!result_N[item.relation_group]) {
                                result_N[item.relation_group] = [];
                            }
                            result_N[item.relation_group].push(item);
                        }
                    })

                    // sort by order inside the groups
                    for (var group in result_ONE_OF) {
                        result_ONE_OF[group].sort(function (a, b) {
                            return a.sort_order - b.sort_order;
                        });
                    }

                    for (var groupN in result_N) {
                        result_N[groupN].sort(function (a, b) {
                            return a.sort_order - b.sort_order;
                        });
                    }

                    // for (var key in result_ONE_OF) {
                    //     if (result_ONE_OF.hasOwnProperty(key)) {
                    //         for (var key1 in result_ONE_OF[key]) {
                    //             if (result_ONE_OF[key].hasOwnProperty(key1)) {
                    //                 result_ONE_OF[key].sort(function (a, b) {
                    //                     return parseFloat(a.sort_order ? a.sort_order : 0) - parseFloat(b.sort_order ? b.sort_order : 0);
                    //                 });
                    //             }
                    //         }
                    //     }
                    // }
                    // for (var key in result_N) {
                    //     if (result_N.hasOwnProperty(key)) {
                    //         for (var key1 in result_N[key]) {
                    //             if (result_N[key].hasOwnProperty(key1)) {
                    //                 result_N[key].sort(function (a, b) {
                    //                     return parseFloat(a.sort_order ? a.sort_order : 0) - parseFloat(b.sort_order ? b.sort_order : 0);
                    //                 });
                    //             }
                    //         }
                    //     }
                    // }

                    // sorting by group names
                    result_N = Object.entries(result_N);
                    result_ONE_OF = Object.entries(result_ONE_OF);
                    self.N_components = result_N;
                    self.ONE_OF_components = result_ONE_OF;

                    Object.entries(self.selected_components).forEach(([key, val]) => {
                        var index = /[^_]*$/.exec(key)[0];
                        if (Object.keys(self.ONE_OF_components).length > 0 && self.ONE_OF_components[index]) {

                            self.selected_components[key].uuid = self.ONE_OF_components[index][1][0].product.uuid;
                            self.selected_components[key].short_name = self.ONE_OF_components[index][1][0].product.short_name;
                            self.selected_components[key].relation_group = self.ONE_OF_components[index][1][0].relation_group;
                            self.selected_components[key].relation_type = self.ONE_OF_components[index][1][0].relation_type;
                            self.selected_components[key].unit = 1

                            // if selected component has sub component
                            var sub_components = self.ONE_OF_components[index][1][0].product?.sub_products;

                            if (sub_components.length) {

                                var result_3rd = {};
                                var result_N_3rd = {};
                                var result_ONE_OF_3rd = {};

                                // grouping by relation group
                                sub_components.forEach(function (item, key) {
                                    if (!result_3rd[item.relation_group]) {
                                        result_3rd[item.relation_group] = [];
                                    }
                                    result_3rd[item.relation_group].push(item);

                                    if (item.relation_type === 'ONE_OF') {
                                        if (!result_ONE_OF_3rd[item.relation_group]) {
                                            result_ONE_OF_3rd[item.relation_group] = [];
                                        }
                                        result_ONE_OF_3rd[item.relation_group].push(item);
                                    }
                                    if (item.relation_type === 'N') {
                                        if (!result_N_3rd[item.relation_group]) {
                                            result_N_3rd[item.relation_group] = [];
                                        }
                                        result_N_3rd[item.relation_group].push(item);
                                    }
                                })

                                // console.log(result_ONE_OF_3rd)
                                // console.log(Object.keys(result_ONE_OF_3rd).length)
                                // console.log(self.ONE_OF_components[index][1][0].product?.sub_products[0])

                                self.sub_components = Object.entries(result_ONE_OF_3rd);
                                self.sub_components_N2 = Object.entries(result_N_3rd);

                                // select first subcomponent
                                self.sub_components.forEach(function (value, k) {
                                    if (value[1].length) {
                                        value[1].forEach(function (val, i) {
                                            if (i === 0) {
                                                var selected_sub_component = {
                                                    uuid: val.product.uuid,
                                                    short_name: val.product.short_name,
                                                    relation_group: val.relation_group,
                                                    relation_type: val.relation_type,
                                                    unit: 1,
                                                    price: val.price,
                                                }
                                                self.selected_components[key].selected_sub_components.push(selected_sub_component);
                                            }
                                        })
                                    }
                                });
                            }

                        }
                    });

                    // Show the modal
                    $("#subItemModal").modal('show');

                    // Uncheck all checkboxes under #subItemModal
                    $("#subItemModal input[type='checkbox']").prop("checked", false);

                },
                updateUnit: function (type) {
                    var self = this;
                    if (type === 'INCREASE') {
                        self.unit++
                    } else {

                        if (self.unit === 1) {
                            return false;
                        }
                        self.unit--
                    }
                },
                getProductPrice: function (product) {
                    var self = this;

                    var sub_products = product.sub_products ?? [];
                    sub_products = sub_products.filter(function (sp) {
                        return sp.relation_type === 'ONE_OF';
                    });

                    var price = product.price?.price || 0.00;
                    price = parseFloat(price);

                    if (sub_products.length) {
                        // get the minimum price from the components to show as product price
                        const groupedData = self.groupByRelationGroup(sub_products);
                        const groupedArray = Object.entries(groupedData).map(([key, value]) => ({
                            relation_group: key,
                            items: value
                        }));

                        if (groupedArray.length) {
                            groupedArray.forEach(function (arr) {
                                var min_price = self.findMinimumPrice(arr.items) || 0.00;
                                price += min_price;
                            })
                        }

                        return price ? price.toFixed(2) : 0.00;
                    } else {
                        return product.price?.price || 0.00;
                    }

                },

                groupByRelationGroup: function (data) {
                    const groupedData = {};
                    data.forEach(item => {
                        const group = item.relation_group;
                        if (!groupedData[group]) {
                            groupedData[group] = [];
                        }
                        groupedData[group].push(item);
                    });
                    return groupedData;
                },
                findMinimumPrice: function (data) {
                    if (data.length === 0) return null; // Return null if array is empty
                    let minPrice = data[0].price; // Initialize minPrice with the first item's price
                    for (let i = 1; i < data.length; i++) {
                        if (data[i].price < minPrice) {
                            minPrice = data[i].price; // Update minPrice if a lower price is found
                        }
                    }
                    return minPrice;
                },

                updateSelectedComponentN: function (event, component) {
                    var self = this;
                    var checked = event.target.checked;
                    var product = component.product;
                    self.sub_components = [];

                    // check the max unit
                    const max_unit = component.max_unit || 10;
                    console.log(max_unit)
                    var taken_components = self.selected_components_N.filter(function (scN) {
                        return scN.relation_group === component.relation_group
                    });

                    self.error.max_unit_from_N_component = '';

                    if(event.target.checked) {
                        if(taken_components.length === max_unit) {
                            event.target.checked = false;
                            self.error.max_unit_from_N_component = 'Maximum unit has been choosen.';
                            return false;
                        }
                    }

                    console.log(taken_components)

                    var exist = self.selected_components_N.find(function (com) {
                        return com.uuid === product.uuid;
                    })
                    var existIndex = self.selected_components_N.findIndex(function (com) {
                        return com.uuid === product.uuid;
                    })

                    if (checked) {

                        if (!exist) {
                            self.selected_components_N.push({
                                price: component.price || 0,
                                uuid: product.uuid,
                                short_name: product.short_name,
                                relation_group: component.relation_group,
                                relation_type: component.relation_type,
                                unit: 1,
                                checked: true,
                                sub_components: product.sub_products ?? [],
                                selected_sub_components: [],
                            })

                            var newIndex = self.selected_components_N.findIndex(function (com) {
                                return com.uuid === product.uuid;
                            })

                            var selected_sub_component = {
                                uuid: product.sub_products[0]?.product?.uuid,
                                short_name: product.sub_products[0]?.product?.short_name,
                                relation_group: product.sub_products[0]?.relation_group,
                                relation_type: product.sub_products[0]?.relation_type,
                                unit: 1,
                                parent_index: newIndex,
                            };

                            self.sub_components_N = product.sub_products ?? [];
                            self.selected_components_N[newIndex].selected_sub_components.push(selected_sub_component)
                            self.selected_sub_component_N = selected_sub_component
                        }

                        if (self.sub_components_N.length) {
                            $('#subComponentForNComponentModal').modal('show');
                        }

                    } else {

                        if (exist) {
                            self.selected_components_N.splice(existIndex, 1)
                        }

                    }

                },
                updateQtySelectedComponentN: function (type, component) {
                    var self = this;
                    var index = self.selected_components_N.findIndex(function (val) {
                        return val.uuid === component.product.uuid
                    });

                    if (index < 0) return false;
                    if (!self.selected_components_N[index]) return false;

                    if (type === 'INCREASE') {
                        if (self.selected_components_N[index].unit === 10) {
                            return;
                        }
                        self.selected_components_N[index].unit = parseInt(self.selected_components_N[index].unit) + 1;
                    } else if (type === 'DECREASE') {
                        if (self.selected_components_N[index].unit === 1) {
                            return;
                        }
                        self.selected_components_N[index].unit = parseInt(self.selected_components_N[index].unit) - 1;
                    }
                },
                getSelectedComponentNIndex: function (component) {
                    var self = this;

                    var index = self.selected_components_N.findIndex(function (val) {
                        return val.uuid === component.product.uuid
                    });

                    return index;
                },
                getSelectedComponentNSelectedSubComponent: function (component) {
                    var self = this;

                    var index = self.selected_components_N.findIndex(function (val) {
                        return val.uuid === component.product.uuid
                    });

                    return self.selected_components_N[index]?.selected_sub_components[0].short_name ?? '';
                },
                updateSelectedComponent: function (index, component) {

                    var self = this;

                    // update selected component
                    self.selected_components[index].short_name = component.product?.short_name;
                    self.selected_components[index].relation_group = component.relation_group;
                    self.selected_components[index].relation_type = component.relation_type;
                    self.selected_components[index].unit = 1;
                    self.selected_components[index].price = component.price || 0;
                    self.selected_components[index].sub_components = [];
                    self.selected_components[index].sub_components_N = [];
                    self.selected_components[index].selected_sub_components = [];
                    self.selected_components[index].selected_sub_components_N = [];

                    self.selected_component = component;

                    var sub_components = component.product?.sub_products || [];

                    if (!sub_components.length) {
                        return;
                    }

                    // load sub components
                    sub_components.forEach(function (value, k) {
                        self.sub_components.push(value)
                    });

                    // sort sub components
                    self.sub_components.sort(function (a, b) {
                        return parseFloat(a.sort_order ? a.sort_order : 0) - parseFloat(b.sort_order ? b.sort_order : 0);
                    });

                    self.selected_3rd_level_N = [];
                    // Uncheck all checkboxes under #subItemModal
                    $("#subComponentModal input[type='checkbox']").prop("checked", false);
                    // remove all quantity form modal
                    $("#subComponentModal input[type='number']").val(1);



                    var result_3rd = {};
                    var result_N_3rd = {};
                    var result_ONE_OF_3rd = {};

                    // grouping by relation group
                    sub_components.forEach(function (item, key) {
                        if (!result_3rd[item.relation_group]) {
                            result_3rd[item.relation_group] = [];
                        }
                        result_3rd[item.relation_group].push(item);

                        if (item.relation_type === 'ONE_OF') {
                            if (!result_ONE_OF_3rd[item.relation_group]) {
                                result_ONE_OF_3rd[item.relation_group] = [];
                            }
                            result_ONE_OF_3rd[item.relation_group].push(item);
                        }
                        if (item.relation_type === 'N') {
                            if (!result_N_3rd[item.relation_group]) {
                                result_N_3rd[item.relation_group] = [];
                            }
                            result_N_3rd[item.relation_group].push(item);
                        }
                    })

                    self.sub_components = [];

                    self.sub_components = Object.entries(result_ONE_OF_3rd);
                    self.sub_components_N2 = Object.entries(result_N_3rd);

                    // console.log(self.sub_components)
                    // console.log(self.sub_components_N2)

                    if (self.sub_components.length) {

                        // select first subcomponent
                        self.sub_components.forEach(function (value, k) {
                            if (value[1].length) {
                                value[1].forEach(function (val, i) {
                                    if (i === 0) {
                                        var selected_sub_component = {
                                            uuid: val.product.uuid,
                                            short_name: val.product.short_name,
                                            relation_group: val.relation_group,
                                            relation_type: val.relation_type,
                                            unit: 1,
                                            price: val.price,
                                            parent_index: index,
                                        }
                                        self.selected_components[index].selected_sub_components.push(selected_sub_component);
                                        self.selected_sub_components[k] = selected_sub_component
                                    }
                                })
                            }
                        });

                    }

                    if (Object.keys(result_N_3rd).length) {

                        const selected_3rd_level_N = self.selected_3rd_level_N || [];

                        self.selected_components[index].sub_components_N = component.product?.sub_products || [];
                        self.selected_components[index].selected_sub_components_N = selected_3rd_level_N;
                        self.sub_components_N2 = result_N_3rd;

                    }

                    if (self.sub_components.length || Object.keys(self.sub_components_N2).length) {
                        $('#subComponentModal').modal('show');
                    }
                },

                updateSelectedSubComponent: function (index, component) {
                    var self = this;

                    var selected_sub_component = self.selected_sub_components[index];

                    var parent_index = selected_sub_component.parent_index;

                    var obj = {
                        uuid: component.product.uuid,
                        short_name: component.product.short_name,
                        relation_group: component.relation_group,
                        relation_type: component.relation_type,
                        unit: 1,
                        price: component.price,
                        parent_index: parent_index,
                    }

                    self.selected_sub_components[index] = obj;

                    // remove all selected sub component
                    self.selected_components[parent_index].selected_sub_components = []

                    // only selected data
                    var selected_sub_components = self.selected_sub_components.filter(function (ssc) {
                        return ssc.uuid
                    })

                    // add inside selected component
                    self.selected_components[parent_index].selected_sub_components = selected_sub_components

                    // console.log(self.selected_components[parent_index]);

                },
                updateSelectedSubComponentN: function (index, component) {
                    var self = this;

                    var sub = self.sub_components_N[index];
                    var parent_index = self.selected_sub_component_N.parent_index;

                    var selected_sub_component = {
                        uuid: component.product.uuid,
                        short_name: component.product.short_name,
                        relation_group: component.relation_group,
                        relation_type: component.relation_type,
                        unit: 1,
                        parent_index: parent_index,
                    }

                    // remove all selected sub component
                    self.selected_components_N[parent_index].selected_sub_components = []

                    // add new subcomponent
                    self.selected_components_N[parent_index].selected_sub_components.push(selected_sub_component)

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
                    if (business_weekly_off_day && business_weekly_off_day === current_date_name.toUpperCase()) return false;

                    return true;

                },

                select3rdLevelComponentN: function (event, component) {
                    var self = this;
                    var checked = event.target.checked;

                    if (checked) {

                        var component_name = self.selected_component.product.short_name;
                        var max_unit = self.selected_component.max_unit;

                        if (self.selectedNComponentTotalSelectedUnit + 1 > max_unit) {
                            swal('Maximum unit limit for ' + component_name + ' is ' + max_unit, {
                                icon: "warning",
                            })
                            event.target.checked = false;
                            return false;
                        }

                        self.selected_3rd_level_N.push({
                            product: component.product,
                            price: component.price || 0.00,
                            short_name: component.product.short_name,
                            relation_group: component.relation_group,
                            relation_type: component.relation_type,
                            unit: 1,
                            checked: true,
                        })
                    } else {

                        var existIndex = self.selected_3rd_level_N.findIndex(function (com) {
                            return com.product.id === component.product.id;
                        })

                        $("#unit_" + self.selected_3rd_level_N[existIndex].product.id).val('');

                        self.selected_3rd_level_N.splice(existIndex, 1)
                    }
                },
                updateQty3rdLevelComponentN: function (type, component) {
                    var self = this;
                    var index = self.selected_3rd_level_N.findIndex(function (val) {
                        return val.product.id === component.product.id
                    });

                    if (index < 0) return false;

                    var component_name = self.selected_component.product.short_name;
                    var max_unit = self.selected_component.max_unit;

                    if (type === 'INCREASE') {

                        if (self.selectedNComponentTotalSelectedUnit + 1 > max_unit) {
                            swal('Maximum unit limit for ' + component_name + ' is ' + max_unit, {
                                icon: "warning",
                            })
                            return false;
                        }

                        if (self.selected_3rd_level_N[index].unit === 10) {
                            return;
                        }
                        self.selected_3rd_level_N[index].unit = parseInt(self.selected_3rd_level_N[index].unit) + 1;

                        $("#unit_" + component.product.id).val(self.selected_3rd_level_N[index].unit);

                    } else if (type === 'DECREASE') {
                        if (self.selected_3rd_level_N[index].unit === 1) {
                            return;
                        }
                        self.selected_3rd_level_N[index].unit = parseInt(self.selected_3rd_level_N[index].unit) - 1;
                        $("#unit_" + component.product.id).val(self.selected_3rd_level_N[index].unit);
                    }
                },
                add3rdLevelNComponent: function () {
                    // check selected 3rd level components to store
                    const self = this;
                    var total_unit = 0;
                    self.selected_3rd_level_N.forEach(function (c) {
                        total_unit += c.unit
                    })

                    if (total_unit > self.selected_component.max_unit) {

                        var component_name = self.selected_component.product.short_name;
                        var max_unit = self.selected_component.max_unit;

                        swal('Maximum unit limit for ' + component_name + ' is ' + max_unit, {
                            icon: "warning",
                        })
                        return false;
                    }

                    $("#subComponentNModal").modal('hide');

                },
                clear3rdLevelNComponent: function () {
                    const self = this;
                    self.selected_3rd_level_N = [];
                    $("#subComponentNModal input[type='checkbox']").prop("checked", false);

                },

                addToCart: function () {
                    const self = this;

                    if (!self.checkBusinessStatus()) {
                        swal("Online order is not available today", {
                            icon: "warning"
                        })
                        return false;
                    }

                    var total_price = 0;
                    var product = self.product;
                    total_price = self.product_total;

                    var components = [];
                    var object_components = {};

                    self.selected_components.forEach(function (val) {
                        if (val.uuid) {
                            object_components = {
                                uuid: val.uuid,
                                short_name: val.short_name,
                                relation_group: val.relation_group,
                                relation_type: val.relation_type,
                                unit: val.unit,
                                price: val.price,
                                //sub_components: val.sub_components,
                                selected_sub_components: val.selected_sub_components,
                                selected_sub_components_N: val.selected_sub_components_N
                            };
                            components.push(object_components);
                        }
                    });

                    var components_N = [];
                    var object_components_N = {};
                    self.selected_components_N.forEach(function (val) {
                        if (val.uuid) {
                            object_components_N = {
                                price: val.price,
                                uuid: val.uuid,
                                short_name: val.short_name,
                                relation_group: val.relation_group,
                                relation_type: val.relation_type,
                                unit: val.unit,
                                //sub_components: val.sub_components,
                                sub_components: val.selected_sub_components
                            };
                            components_N.push(object_components_N);
                        }
                    });

                    // check if same item already exists
                    var matched = 0;
                    var matched_at = 0;
                    self.cart.forEach(function (cart, index) {
                        if (cart.product.uuid === product.uuid) {

                            var selected_components = self.selected_components;

                            selected_components.forEach(function (sc) {
                                if (sc.uuid && !sc.sub_components?.length) {
                                    delete sc.sub_components;
                                }
                                if (sc.uuid && sc.sub_components_N?.length) {
                                    delete sc.sub_components_N;
                                }
                            })

                            var cart_selected_components = cart.selected_components ? cart.selected_components.filter(word => word.uuid !== '') : [];
                            var self_selected_components = selected_components ? selected_components.filter(word => word.uuid !== '') : [];
                            var cart_selected_components_N = cart.selected_components_N ? cart.selected_components_N.filter(word => word.uuid !== '') : [];
                            var self_selected_components_N = self.selected_components_N ? self.selected_components_N.filter(word => word.uuid !== '') : [];

                            if (JSON.stringify(cart_selected_components) === JSON.stringify(self_selected_components)) {
                                matched = 1;
                                matched_at = index;
                                if (cart_selected_components_N && self_selected_components_N) {
                                    if (JSON.stringify(cart_selected_components_N) === JSON.stringify(self_selected_components_N)) {
                                        matched = 1;
                                        return false;
                                    } else {
                                        matched = 0;
                                    }
                                } else {
                                    return false;
                                }
                            } else {
                                console.log('not matched at ' + index)
                            }
                        }
                    });

                    if (matched > 0) {

                        // update cart item
                        self.cart[matched_at].unit += 1;
                        var tp = parseFloat(self.cart[matched_at].total_price) + parseFloat(self.cart[matched_at].unit_price);
                        self.cart[matched_at].total_price = parseFloat(tp.toFixed(2));

                    } else {

                        var net_total = total_price * self.unit;

                        // add cart item
                        var obj = {
                            product: product,
                            selected_components: components,
                            selected_components_N: components_N,
                            unit: self.unit,
                            price: product.current_price || product.price?.price || 0,
                            unit_price: total_price,
                            component_price: 0,
                            total_price: net_total.toFixed(2),
                            comment: self.comment
                        }

                        self.cart.push(obj);
                    }


                    // Clear cart
                    localStorage.removeItem('cart');

                    // Add cart
                    localStorage.setItem('cart', JSON.stringify(self.cart));

                    $("#subItemModal").modal('hide');

                    // clear the comment
                    self.comment = '';

                    // set cart expiry date
                    localStorage.setItem('cart_expire_at', moment().add(1, 'day').format('YYYY-MM-DD HH:mm:ss'));

                    /*swal("Success! Added to cart", {
                        icon: 'success'
                    })*/
                },
                updateCartUnit: function (type, index) {
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
                updateCartComment: function (index, value) {
                    var self = this;

                    self.cart[index].comment = value;

                    localStorage.setItem('cart', JSON.stringify(self.cart));
                },
                removeCart: function (index) {
                    var self = this;
                    self.cart.splice(index, 1);
                    localStorage.setItem('cart', JSON.stringify(self.cart));
                },

                openBranchModal: function () {
                    $("#shopModal").modal('show');
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

                                } else {
                                    self.branch = '{{\App\Services\BranchService::current()}}';
                                }
                            });
                    } else {
                        window.location = '/' + branch + '/menu';

                    }

                },

                // Floating Button
                floatingButton() {
                    var floatButton = document.getElementById('flotingButtonDiv');
                    var icon = document.getElementById('floatingArrowIcon');
                    if (floatButton.classList.contains("floating-buttonVisible")) {
                        floatButton.classList.remove("floating-buttonVisible");
                        floatButton.classList.add("floating-orderButtonHidden");
                        icon.innerHTML = '<i class="fa-solid fa-angle-left"></i>';
                    } else {
                        floatButton.classList.remove("floating-orderButtonHidden");
                        floatButton.classList.add("floating-buttonVisible");
                        icon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                    }
                },

                // Splash screen
                check_advertise_time: function () {
                    var now = moment().format('YYYY-MM-DD HH:mm:ss');
                    var advertise_shown_end_time = localStorage.getItem('advertise_expire_time');

                    if (advertise_shown_end_time && now > advertise_shown_end_time) {
                        localStorage.setItem('advertise_shown', 0);
                    }
                },

                scrollToTop: function (id) {
                    var self = this;

                    setTimeout(function () {

                        //window.location = '#'+id;
                        //setTimeout(function () {
                        var targetDiv = document.getElementById(id);
                        //targetDiv.scrollIntoView({ behavior: 'smooth', block: 'start', inline: 'nearest' });

                        // Add an additional offset from the top (50px in this case)
                        window.scroll({
                            top: targetDiv.offsetTop - 20,
                            left: 0,
                            behavior: 'smooth'
                        });
                        //}, 500)
                    }, 500)
                }
            },
            computed: {
                cart_total: function () {
                    var self = this;

                    var total_price = 0;
                    self.cart.forEach(function (val, key) {
                        total_price += (val.unit_price * val.unit);
                    });

                    return parseFloat(total_price).toFixed(2);
                },
                product_total: function () {
                    var self = this;
                    if (!self.product) return 0;

                    var price = parseFloat(self.product?.price?.price) || 0;
                    var component_price = 0;
                    var sub_component_price = 0;

                    var sub_products =  self.product.sub_products || [];
                    if(!sub_products.length) {
                        return price.toFixed(2);
                    }

                    self.selected_components.forEach(function (value, index) {
                        if (!value.uuid) {
                            return;
                        }

                        var product_uuid = value.uuid;
                        var sub_components = value.selected_sub_components || [];
                        var sub_components_N = value.selected_sub_components_N ?? [];
                        var selected_component = null;

                        if (sub_products) {
                            selected_component = sub_products.find(function (item) {
                                return item.product.uuid === product_uuid;
                            });
                        }

                        if (selected_component) {
                            component_price += parseFloat(selected_component.price) || 0;
                        }

                        if (sub_components.length > 0) {
                            sub_components.forEach(function (val) {
                                sub_component_price += val.price * val.unit;
                            })
                        }

                        if (sub_components_N.length > 0) {
                            sub_components_N.forEach(function (val) {
                                sub_component_price += val.price * val.unit
                            })
                        }
                    })

                    var component_price_n = 0;
                    self.selected_components_N.forEach(function (value) {
                        if (value.uuid) {
                            var selected_component_n = self.product.sub_products.find(function (item) {
                                return item.product.uuid === value.uuid;
                            });
                            if (selected_component_n) {
                                const price = value.price || 0;
                                component_price_n += price * value.unit;
                            }
                        }
                    });

                    var total_component_price = (component_price + component_price_n + sub_component_price);
                    var total_price = price + total_component_price;

                    return total_price.toFixed(2);
                },
                per_item_total: function () {
                    var self = this;

                    var total_price = parseFloat(self.product_total) * self.unit;

                    return total_price.toFixed(2);
                },
                selectedNComponentTotalSelectedUnit: function () {
                    const self = this;
                    var total_unit = 0;
                    self.selected_3rd_level_N.forEach(function (c) {
                        total_unit += c.unit
                    })

                    return total_unit
                },
            },

            watch: {
                "selected_sub_component.uuid": function (val) {
                    const self = this;
                    var sub_component = self.sub_components.find(function (sub) {
                        return sub.product.uuid === val;
                    })
                    if (sub_component) {
                        self.selected_sub_component.short_name = sub_component.product.short_name;
                        self.selected_sub_component.relation_group = sub_component.relation_group;
                        self.selected_sub_component.relation_type = sub_component.relation_type;
                        self.selected_sub_component.unit = 1;
                    }
                },

                full_cart_comment: function (val) {
                    var self = this;
                    localStorage.setItem('fullCartComment', val);
                },
            }
        }).mount('#app')

    </script>
@endpush
