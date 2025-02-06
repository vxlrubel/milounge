@extends('layouts.app')

@section('title')
    {{$product->short_name ?? 'N/A'}}
@endsection

@push('meta')
    <meta property="og:title" content="{{$product->short_name ?? ''}}"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:description" content="{{$product->property->short_description ?? "N/A"}}"/>
    <meta property="og:type" content="article"/>
    <meta property="article:author" content="{{$product->short_name ?? ''}}"/>
    <meta property="og:url" content="{{request()->fullUrl()}}"/>

    @if(count($product->files ?? []))
        <meta property="og:image"
              content="{{config('api.apiUrl')}}/products/image/{{$product->files[0]->file_name ?? '#'}}">
    @else
        <meta property="og:image" content="/assets/images/placeholder.jpg">
    @endif

    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
@endpush

@push('style')
    <!-- Slick Carousal CDN -->
    <link rel="stylesheet" type="text/css" href="/assets/css/slick.css"/>
    <link rel="stylesheet" href="/assets/css/product.css"/>
@endpush

@section('content')
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-list">
                        <ul>
                            <li class="breadcrumb-item"><a aria-current="page" href="/"><i
                                        class="fa-solid fa-house"></i></a></li>
                            <li><span> <i class="fa-solid fa-angle-right"></i> </span></li>
                            <li><a href="#">{{$product->short_name ?? 'N/A'}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="singleproduct-section">
        <div class="product-price-addcart">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-4">
                        <div class="product-gallery">
                            @if(count($product->files ?? []))
                                <div class="spSliderGallery">

                                    @foreach($product->files as $file)
                                        <div>
                                            <img
                                                src="{{config('api.apiUrl')}}/products/image/{{$file->file_name ?? '#'}}"
                                                alt="{{$product->short_name ?? ''}}"
                                            />
                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div class="spSliderGallery">
                                    <div>
                                        <img
                                            src="/assets/images/placeholder.jpg"
                                            alt="{{$product->short_name ?? ''}}">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 col-lg-8">
                        <div class="product-price-content">
                            <div class="product-title">
                                <h1>{{$product->short_name ?? '#'}}</h1>
                                <h3>
                                    £{{$product->price->price ?? '0'}}
                                    {{--<span><del>£95.00</del></span>--}}
                                </h3>
                            </div>
                            <div class="product-rating">
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                <span><i class="fa-solid fa-star"></i></span>
                                (@{{ product_ratings.length }} Reviews)
                            </div>
                            <div class="p-details">
                                <p>
                                    {{$product->property->short_description ?? ''}}
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 col-md-11 col-lg-7">

                                    <form action="" @submit.prevent="getStarted()">
                                        <div class="product-color-option" v-for="(component, index) in components">
                                            <p>@{{ component[0] }}</p>

                                            <div class="product-color-content" v-if="component[0] === 'Color'">
                                                <div v-for="(val, k) in component[1]">
                                                    <input v-model="selected_components[index].uuid"
                                                           class="form-check-input color-box-input" type="radio"
                                                           name="productColor" :id="'color'+k"
                                                           @click="updateSelectedComponent(index, val.product?.uuid)"
                                                           :value="val.product?.uuid" required>
                                                    <label class="form-check-label color-box"
                                                           :style="'background-color:' + val.product.property?.color"
                                                           :for="'color'+k">
                                                        <span class="icon-color"><i
                                                                class="fa-solid fa-check"></i></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="product-color-content" v-else-if="component[0] === 'Size'">
                                                <div v-for="(val, k) in component[1]">
                                                    <input v-model="selected_components[index].uuid"
                                                           class="form-check-input size-box-input" type="radio"
                                                           name="productSize" :id="'size'+k"
                                                           @click="updateSelectedComponent(index, val.product?.uuid)"
                                                           :value="val.product?.uuid" required>
                                                    <label class="form-check-label size-box" :for="'size'+k">
                                                        <span
                                                            class="select-size">@{{ val.product.short_name || '' }}</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="" v-else>
                                                <div class="mt-4">
                                                    <select name="" id="" class="form-control"
                                                            v-model="selected_components[index].uuid">
                                                        <option v-for="(val, k) in component[1]"
                                                                :value="val.product.uuid">
                                                            @{{ val.product.short_name }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="product-quantity-cart">

                                            <div class="quantity-cart">
                                                <div class="product-quantity">
                                                    <button type="button" class="btn btn-in-dec"
                                                            @click="updateQty('DECREASE')"><i
                                                            class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <div class="product-quantity-field">
                                                        <input
                                                            type="number"
                                                            class="form-control quantity-field"
                                                            placeholder="Quantity"
                                                            min="1"
                                                            v-model="qty"
                                                        />
                                                    </div>
                                                    <button type="button" class="btn btn-in-dec"
                                                            @click="updateQty('INCREASE')"><i
                                                            class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="product-addtocart-button">
                                                    <input
                                                        type="submit"
                                                        class="btn addtocart-btn"
                                                        value="Add to cart"
                                                    />
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="product-desctab-mobile">
                <div class="accordion" id="accordionExample">
                    @if($product->description ?? null)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button productdetail-accordionbtn collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#productDescription"
                                        aria-expanded="true"
                                        aria-controls="collapseOne">
                                    Description
                                </button>
                            </h2>
                            <div id="productDescription" class="accordion-collapse collapse"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body productdetails-accordionbody">
                                    <div>
                                        <div class="product-details-list">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    {!! $product->description ?? '' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button productdetail-accordionbtn collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#productReview" aria-expanded="false"
                                    aria-controls="collapseThree">
                                Reviews
                            </button>
                        </h2>
                        <div id="productReview" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div>
                                    <div class="reviews-all-content">

                                        <div>
                                            @consumer
                                            <div class="client-review-form">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="bar-bg bar-mobilebg">
                                                            <h5>Give your review Here</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="review-form-allcontent">
                                                    <form action="" @submit.prevent="review()">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group clientReview-input">
                                                                    <div class="starRating-input">
                                                                        <div
                                                                            class="clientReview-formTitle clientReview-mobileformTitle">
                                                                            <h5>Rating</h5>
                                                                        </div>
                                                                        <a href="javascript:void(0)"
                                                                           @click="mobileStartRating(1)"><span
                                                                                id="mobilestar1"
                                                                                class="fa fa-star starRating-icon"></span></a>
                                                                        <a href="javascript:void(0)"
                                                                           @click="mobileStartRating(2)"><span
                                                                                id="mobilestar2"
                                                                                class="fa fa-star starRating-icon"></span></a>
                                                                        <a href="javascript:void(0)"
                                                                           @click="mobileStartRating(3)"><span
                                                                                id="mobilestar3"
                                                                                class="fa fa-star starRating-icon"></span></a>
                                                                        <a href="javascript:void(0)"
                                                                           @click="mobileStartRating(4)"><span
                                                                                id="mobilestar4"
                                                                                class="fa fa-star starRating-icon"></span></a>
                                                                        <a href="javascript:void(0)"
                                                                           @click="mobileStartRating(5)"><span
                                                                                id="mobilestar5"
                                                                                class="fa fa-star starRating-icon"></span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group clientReview-input">
                                                                    <div class="clientComment-input">
                                                                        <div
                                                                            class="clientReview-formTitle clientReview-mobileformTitle">
                                                                            <h5>Comment</h5>
                                                                        </div>
                                                                        <input type="text" class="form-control"
                                                                               placeholder="Enter your review here"
                                                                               v-model="comment">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="review-set-button">
                                                            <button type="submit"
                                                                    class="btn review-setbtn review-mobilesetbtn">
                                                                Review
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            @else
                                                <div class="client-review-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small>Please <a href="/auth/login">login</a> to give
                                                                feedback.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endconsumer

                                        </div>
                                        <div class="client-review-content"
                                             v-if="product_ratings && product_ratings.length > 0"
                                             v-for="rate in product_ratings">
                                            <div class="row">
                                                <div class="col-7 col-md-6">
                                                    <div class="client-rating-star">
                                                        <span v-for="val in rate.rate"><i class="fa-solid fa-star"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-5 col-md-6">
                                                    <div class="client-review-time">
                                                        <p>@{{ getHumanizeDiffDatetime(rate.created_at) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="client-name client-mobilename">
                                                        <h3>
                                              <span><i class="fa-solid fa-user"></i></span
                                              >@{{ rate.consumer?.name || '' }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="product-review product-mobilereview">
                                                        <h6>Comments</h6>
                                                        <p>"@{{ rate.comment }}"</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="divider"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="product-info py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="left-content">

                            <div class="product-desc-tabs large-device">
                                <div class="product-description-content">
                                    <div class="product-desc-title">
                                        <h4>Description</h4>
                                    </div>
                                    <div class="product-desc-body">
                                        <div class="product-details-list">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    {!! $product->description ?? 'No description found!' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">

                                        <button
                                            class="nav-link product-tab active"
                                            id="nav-description-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#nav-description"
                                            type="button"
                                            role="tab"
                                            aria-controls="nav-description"
                                            aria-selected="true"
                                        >
                                            Description
                                        </button>

                                        <button
                                            class="nav-link product-tab"
                                            id="nav-reviews-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#nav-reviews"
                                            type="button"
                                            role="tab"
                                            aria-controls="nav-reviews"
                                            aria-selected="false"
                                        >
                                            Reviews(2)
                                        </button>
                                    </div>
                                </nav>
                                <div class="tab-content p-tab-content" id="nav-tabContent">

                                    <div
                                        class="tab-pane fade show active"
                                        id="nav-description"
                                        role="tabpanel"
                                        aria-labelledby="nav-description-tab"
                                        tabindex="0"
                                    >
                                        <div class="product-details-list">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    {!! $product->description ?? 'No description found!' !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="tab-pane fade"
                                        id="nav-reviews"
                                        role="tabpanel"
                                        aria-labelledby="nav-reviews-tab"
                                        tabindex="0"
                                    >
                                        <div class="reviews-all-content">
                                            @consumer
                                            <div>
                                                <div class="client-review-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="bar-bg">
                                                                <h5>Give your review Here</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review-form-allcontent">
                                                        <form action="" @submit.prevent="review()">
                                                            <div class="row">
                                                                <div class="col-md-4 col-lg-3">
                                                                    <div class="form-group clientReview-input">
                                                                        <div class="starRating-input">
                                                                            <div class="clientReview-formTitle">
                                                                                <h5>Rating</h5>
                                                                            </div>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(1)"><span
                                                                                    id="star1"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(2)"><span
                                                                                    id="star2"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(3)"><span
                                                                                    id="star3"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(4)"><span
                                                                                    id="star4"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(5)"><span
                                                                                    id="star5"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <div class="form-group clientReview-input">
                                                                        <div class="clientComment-input">
                                                                            <div class="clientReview-formTitle">
                                                                                <h5>Comment</h5>
                                                                            </div>
                                                                            <input type="text" class="form-control"
                                                                                   placeholder="Enter your review here"
                                                                                   v-model="comment">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="review-set-button">
                                                                <button type="submit" class="btn review-setbtn">
                                                                    Review
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                                <div>
                                                    <div class="client-review-form">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <small>Please <a href="/auth/login">login</a> to give
                                                                    feedback.</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endconsumer

                                                <div class="client-review-content"
                                                     v-if="product_ratings && product_ratings.length > 0"
                                                     v-for="rate in product_ratings">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="client-rating-star">
                                                            <span v-for="val in rate.rate"><i
                                                                    class="fa-solid fa-star"></i></span>
                                                            </div>
                                                            <div class="client-name">
                                                                <h3><span><i class="fa-solid fa-user"></i></span> @{{
                                                                    rate.consumer?.name || '' }}
                                                                </h3>
                                                            </div>
                                                            <div class="client-review-time">
                                                                <p>@{{ getHumanizeDiffDatetime(rate.created_at) }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="product-review">
                                                                <h6>Comments</h6>
                                                                <p>"@{{ rate.comment }}"</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="divider"></div>

                                                </div>

                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="product-desc-tabs large-device">
                                <div class="product-review-content">
                                    <div class="product-desc-title">
                                        <h4>Reviews</h4>
                                    </div>
                                    <div class="product-desc-body">
                                        <div class="reviews-all-content">
                                            @consumer
                                            <div>
                                                <div class="client-review-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="bar-bg">
                                                                <h5>Give your review Here</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review-form-allcontent">
                                                        <form action="" @submit.prevent="review()">
                                                            <div class="row">
                                                                <div class="col-md-4 col-lg-3">
                                                                    <div class="form-group clientReview-input">
                                                                        <div class="starRating-input">
                                                                            <div class="clientReview-formTitle">
                                                                                <h5>Rating</h5>
                                                                            </div>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(1)"><span
                                                                                    id="star1"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(2)"><span
                                                                                    id="star2"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(3)"><span
                                                                                    id="star3"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(4)"><span
                                                                                    id="star4"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                            <a href="javascript:void(0)"
                                                                               @click="startRating(5)"><span
                                                                                    id="star5"
                                                                                    class="fa fa-star starRating-icon"></span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8 col-lg-9">
                                                                    <div class="form-group clientReview-input">
                                                                        <div class="clientComment-input">
                                                                            <div class="clientReview-formTitle">
                                                                                <h5>Comment</h5>
                                                                            </div>
                                                                            <input type="text" class="form-control"
                                                                                   placeholder="Enter your review here"
                                                                                   v-model="comment">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="review-set-button">
                                                                <button type="submit" class="btn review-setbtn">
                                                                    Review
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div>
                                                <div class="client-review-form">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <small>Please <a href="/auth/login">login</a> to give
                                                                feedback.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endconsumer
                                            <div class="client-review-content"
                                                    v-if="product_ratings && product_ratings.length > 0"
                                                    v-for="rate in product_ratings">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="client-rating-star">
                                                        <span v-for="val in rate.rate"><i
                                                                class="fa-solid fa-star"></i></span>
                                                        </div>
                                                        <div class="client-name">
                                                            <h3><span><i class="fa-solid fa-user"></i></span> @{{
                                                                rate.consumer?.name || '' }}
                                                            </h3>
                                                        </div>
                                                        <div class="client-review-time">
                                                            <p>@{{ getHumanizeDiffDatetime(rate.created_at) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="product-review">
                                                            <h6>Comments</h6>
                                                            <p>"@{{ rate.comment }}"</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="related-product-section" v-if="Object.keys(relevant_products).length">
                                <div class="related-product-title">
                                    <h1>Related Products</h1>
                                </div>
                                <div class="related-product-allcontent">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 col-lg-3"
                                             v-for="relevant_product in relevant_products">
                                            <div class="rp-item">
                                                <div class="rp-image">
                                                    <a :href="'/product/'+relevant_product.uuid">
                                                        <img v-if="relevant_product.files.length"
                                                             :src="'{{config('api.apiUrl')}}/products/image/'+relevant_product.files[0]?.file_name"
                                                             :alt="relevant_product.short_name"
                                                        />

                                                        <img v-else
                                                             src="/assets/images/placeholder.jpg"
                                                             :alt="relevant_product.short_name"/>
                                                    </a>
                                                </div>
                                                <div class="rp-category-contenthold rp-item-content">
                                                    <div class="rp-catcontent-hold">
                                                        <div class="rp-name">
                                                            <h6><a :href="'/product/'+relevant_product.uuid">@{{
                                                                    relevant_product.short_name || 'N/A' }}</a></h6>
                                                        </div>
                                                        <div class="rp-price">
                                                            <p>{{config('app.currency')}} @{{
                                                                relevant_product.price?.price
                                                                || 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="rp-relatedlink-hold">
                                                        <a :href="'/product/'+relevant_product.uuid"
                                                           class="relatedproduct-link">
                                                            <div class="relatedproduct-link-hold">
                                                                <span class="relatedproduct-linkicon"><i
                                                                        class="fa-solid fa-arrow-right"></i></span>
                                                            </div>
                                                        </a>
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

    <script type="text/javascript" src="/assets/js/slick.min.js"></script>

    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    api_url: '{{config('api.apiUrl')}}',
                    headers: {
                        "Authorization": "Bearer {{session('api_token')}}"
                    },
                    active_stock: '{{\App\Services\GlobalSettingService::key('active_stock') ?? '0'}}',

                    product_uuid: '{{$product_uuid ?? ''}}',
                    active_price_checker: null,
                    product: @json(json_decode($product_encoded)),
                    relevant_products: @json(json_decode($relevant_products)),
                    product_relation_price: @json(json_decode($product_relation_price_encoded)),
                    product_ratings: [],
                    components: {},

                    qty: 1,

                    selected_components: [
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: []
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: []
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: []
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: []
                        },
                        {
                            uuid: '',
                            short_name: '',
                            relation_group: '',
                            relation_type: '',
                            unit: 0,
                            sub_components: []
                        },
                    ],

                    cart_bk: [],
                    cart: JSON.parse(localStorage.getItem('cart')) || [],

                    // Rating
                    rating: 0,
                    comment: '',
                    product_review: '',
                    service_review: '',

                    stock_status: false,
                    stock_combinations: [],

                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

                var self = this;
                // self.price = self.product?.price?.price;
                self.active_price_checker = self.product?.property?.active_price_checker || null;

                var components = self.product.sub_products || [];

                var result = {};

                // grouping by relation group
                components.forEach(function (item, key) {
                    if (!result[item.relation_group]) {
                        result[item.relation_group] = [];
                    }
                    result[item.relation_group].push(item);
                })

                // sort by order inside the groups
                for (var key in result) {
                    if (result.hasOwnProperty(key)) {
                        for (var key1 in result[key]) {
                            if (result[key].hasOwnProperty(key1)) {
                                result[key].sort(function (a, b) {
                                    return parseFloat(a.product.sort_order ? a.product.sort_order : 0) - parseFloat(b.product.sort_order ? b.product.sort_order : 0);
                                });
                            }
                        }
                    }
                }

                // sorting by group names
                result = Object.entries(result).sort();
                self.components = result;

                Object.entries(self.selected_components).forEach(([key, val]) => {
                    var index = /[^_]*$/.exec(key)[0];
                    if (Object.keys(self.components).length > 0 && self.components[index]) {

                        self.selected_components[key].uuid = self.components[index][1][0].product.uuid;
                        self.selected_components[key].short_name = self.components[index][1][0].product.short_name;
                        self.selected_components[key].relation_group = self.components[index][1][0].relation_group;
                        self.selected_components[key].relation_type = self.components[index][1][0].relation_type;
                        self.selected_components[key].unit = 1

                    }
                });

                if(self.active_stock === '1') {
                    self.stock_combinations = self.product.stocks || [];

                    // check stock for combination

                }

                // rating
                self.getProductRatings();
            },
            mounted() {
                $('.spSliderGallery').slick({
                    autoplay: true,
                    arrows: true,
                    prevArrow: "<button type='button' class='slickPrevButton btn slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
                    nextArrow: "<button type='button' class='slickNextButton btn slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>"
                });
            },
            methods: {
                getHumanizeDiffDatetime: function (time) {
                    var datetime = moment(time);

                    return datetime.fromNow();
                },
                getProduct: function () {
                    var self = this;

                    axios.get(self.api_url + '/products/' + self.product_uuid)
                        .then(res => {
                            self.product = res.data;
                        })
                },

                groupBy: function (arr, key) {
                    return arr.reduce((acc, curr) => {
                        (acc[curr[key]] = acc[curr[key]] || []).push(curr);
                        return acc;
                    }, {});
                },

                updateSelectedComponent: async function (index, uuid) {
                    var self = this;
                    var component = await self.getComponent(uuid);
                    if (component) {
                        self.selected_components[index].short_name = component.product?.short_name;
                        self.selected_components[index].relation_group = component.relation_group;
                        self.selected_components[index].relation_type = component.relation_type;
                    }
                },

                getComponent: function (uuid) {
                    var self = this;
                    var selected_component = self.product.sub_products.find(function (item) {
                        return item.product.uuid === uuid;
                    });
                    return selected_component || null;
                },

                calculateRelationalPrice: function () {
                    var self = this;
                    var price = 0.00;
                    var combined_uuid = null;
                    var combined_uuid_arr = [self.product_uuid];
                    for (var key in self.selected_components) {
                        if (self.selected_components.hasOwnProperty(key)) {
                            var product_uuid = self.selected_components[key].uuid || null;
                            if (product_uuid) {
                                combined_uuid_arr.push(product_uuid);
                            }
                        }
                    }

                    combined_uuid = combined_uuid_arr.join('-');
                    var price_data = null;
                    if (combined_uuid) {
                        price_data = self.product_relation_price.find(function (value) {
                            return value.uuid === combined_uuid;
                        })
                    }
                    if (price_data) {
                        price = (price_data?.price).toFixed(2);
                    }
                    return price;
                },

                getStarted: function () {
                    var self = this;
                    self.addToCart();
                    //window.location = '/cart';
                },

                addToCart: function () {
                    const self = this;
                    if (!self.qty) return false;

                    // stock check
                    if(self.active_stock === '1') {
                        self.checkStock();
                        return false;
                    }
                    // stock check

                    var selected_components = self.selected_components.filter(val => val.uuid);
                    var obj = {
                        product: self.product,
                        qty: self.qty,
                        selected_components: selected_components,
                        unit_price: self.product.price?.price || 0,
                        price: parseFloat(self.price),
                    }

                    var index = self.cart.findIndex(function (val) {
                        return val.product.uuid === self.product.uuid;
                    })

                    if (index > -1) {
                        self.cart[index].qty += self.qty;
                        self.cart[index].price += parseFloat(self.price);
                        localStorage.setItem('cart', JSON.stringify(self.cart));
                    } else {
                        self.cart.push(obj);
                        localStorage.setItem('cart', JSON.stringify(self.cart));
                    }

                    app2.cart = self.cart;

                    swal("Success! Added to cart", {
                        icon: 'success'
                    })
                },

                updateQty: function (type) {
                    const self = this;

                    if (type === 'INCREASE') {
                        self.qty++;
                    } else {
                        if (self.qty === 1) {
                            return false;
                        }
                        self.qty--;
                    }
                },

                checkStock: function () {
                    const self = this;

                    var stock_combinations = [];
                    self.stock_combinations.forEach(function (stock) {
                        stock_combinations = stock.combination.split(',')
                    })

                    var selected_component_combinations = [];
                    self.selected_components.forEach(function (component) {
                        if(component.uuid) {
                            selected_component_combinations.push(component.uuid);
                        }
                    })

                    const result = self.matchArrays(stock_combinations, selected_component_combinations)

                },

                matchArrays: function(array1, array2) {
                    const set1 = new Set(array1);
                    const matchedValues = [];
                    for (const value of array2) {
                        if (set1.has(value)) {
                            matchedValues.push(value);
                        }
                    }
                    return matchedValues;
                },

                // Rating & Review
                mobileStartRating: function (number) {
                    const self = this;
                    self.rating = number;

                    // clear all the star
                    for (var i = 0; i < 5; i++) {
                        document.getElementById('mobilestar' + (i + 1)).style.color = "#b1b1b1";
                    }

                    // paint all the star
                    for (var k = 0; k < number; k++) {
                        document.getElementById('mobilestar' + (k + 1)).style.color = "#fdad2b";
                    }
                },

                // Rating & Review
                startRating: function (number) {
                    const self = this;
                    self.rating = number;

                    // clear all the star
                    for (var i = 0; i < 5; i++) {
                        document.getElementById('star' + (i + 1)).style.color = "#b1b1b1";
                    }

                    // paint all the star
                    for (var k = 0; k < number; k++) {
                        document.getElementById('star' + (k + 1)).style.color = "#fdad2b";
                    }
                },
                review: function () {
                    const self = this;

                    axios.post(self.api_url + '/products/rating', {
                        product_uuid: self.product_uuid,
                        rating: self.rating,
                        comment: self.comment,
                        product_review: self.product_review,
                        service_review: self.service_review
                    }, {
                        headers: self.headers
                    })
                        .then(res => {
                            swal("Review completed", {
                                icon: 'success'
                            })

                            self.getProductRatings();
                        })
                        .catch(err => {
                            console.log(err);
                        })
                },
                getProductRatings: function () {
                    var self = this;

                    axios.get(self.api_url + '/products/rating/' + self.product_uuid)
                        .then(res => {
                            self.product_ratings = res.data.data;
                        })
                },

            },

            computed: {
                price: function () {
                    var self = this;
                    var price = self.product?.price ? self.product.price?.price : 0;
                    var qty = self.qty;

                    if (self.active_price_checker === '1') {
                        return self.calculateRelationalPrice()
                    } else {
                        return (price * qty).toFixed(2);
                    }
                }
            }
        }).mount('#app')

    </script>
@endpush
