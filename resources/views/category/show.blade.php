@extends('layouts.app')

@section('title') {{$category->name ?? ''}} @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/sareecategory.css"/>
@endpush
@section('content')

    <!-- Breadcrumb List Section Start-->
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-list">
                        <ul>
                            <li class="breadcrumb-item"><a aria-current="page" href="/"><i
                                        class="fa-solid fa-house"></i></a></li>
                            <li><span><i class="fa-solid fa-angle-right"></i></span></li>
                            <li><a href="#">{{$category->name ?? ''}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb List Section End-->
    <!-- Hero Section / Banner Section Start -->
    <section class="sareecat-hero-section">
        <div class="container">
            <div class="sareecat-hero-content">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-4 m-auto">
                        <div class="banner-image">
                            @if($category->image)
                                <img
                                    src="{{config('api.apiUrl')}}/category/image/{{$category->image ?? '#'}}"
                                    alt="{{$category->name ?? ''}}">
                            @else
                                <img
                                    src="/assets/images/placeholder.jpg"
                                    alt="{{$category->name ?? ''}}">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="banner-title">
                            <h1>{{$category->name ?? ''}}</h1>
                        </div>
                        <div class="banner-tagline">
                            <h5>
                                {{$category->short_description ?? ''}}
                            </h5>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Hero Section / Banner Section End -->
    <!-- Saree category gallery Section Start -->
    <section class="saree-gallery-section">
        <div class="container">
            <div class="row">
                @forelse($products ?? [] as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card cat-product-card">
                        <a class="card-heightcontrol" href="/product/{{$product->uuid ?? '#'}}">
                            @if($product->files)
                                <img
                                    src="{{config('api.apiUrl')}}/products/image/{{$product->files[0]->file_name ?? '#'}}"
                                    class="card-img-top"
                                    alt="{{$product->short_name ?? ''}}"
                                />
                            @else
                                <img
                                    src="/assets/images/placeholder.jpg"
                                    class="card-img-top"
                                    alt="{{$product->short_name ?? ''}}">
                            @endif
                        </a>
                        <div class="card-body cat-product-cardbody">
                            <div class="cat-product">
                                <div class="cat-product-details">
                                    <h5 class="card-title cat-product-cardtitle"><a href="/product/{{$product->uuid ?? '#'}}">{{$product->short_name ?? ''}}</a></h5>
                                    <p class="cat-product-price"><span>Price:</span> {{config('app.currency')}}{{$product->price->price ?? 0}}</p>
                                </div>
                                <a href="/product/{{$product->uuid ?? '#'}}" class="cat-singleproduct-link"><div class="catproduct-iconbox-hold"><span class="catproduct-icon-box"><i class="fa-solid fa-arrow-right"></i></span></div></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div>
                        <p>No products found!</p>
                    </div>
                @endforelse
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
                }
            }
        }).mount('#app')

    </script>
@endpush
