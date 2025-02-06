@extends('layouts.app')

@section('title') Product search @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/erectileDysfunction.css"/>
    <link rel="stylesheet" href="/assets/css/mediaqueryerectile.css"/>
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
                            <li><a href="#"> Product search</a></li>
                            <li><span><i class="fa-solid fa-angle-right"></i></span></li>
                            <li><a href="#"> "{{$q ?? null}}"</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="suffered-alteration-section jewellery-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="suffered-alteration-heading">
                        <h6>Search result for</h6>
                        <h1>"{{$q ?? null}}"</h1>
                    </div>
                </div>
            </div>
            <div class="suffered-alteration-content">
                <div class="row">
                    @forelse($products ?? [] as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="alteration-items">
                                @if($product->files)
                                    <div class="image-magnify">
                                        <div class="alteration-image allterimage2">
                                            <a href="/product/{{$product->uuid ?? '#'}}">
                                                <img id="{{$product->files[0]->file_name ?? '#'}}"
                                                     src="{{config('api.apiUrl')}}/products/image/{{$product->files[0]->file_name ?? '#'}}"
                                                     alt=""/>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="alteration-item-content">
                                    <div class="rate-goLink">
                                        <div class="ai-content-name">
                                            <a href="/product/{{$product->uuid ?? '#'}}">
                                                <h3 class="alteration-item-title">
                                                    {{$product->short_name ?? ''}}
                                                </h3>
                                            </a>
                                            <div class="alteration-rate">
                                                <h5><span>£ </span>{{$product->price->price ?? 0.00}}</h5>
                                            </div>
                                        </div>
                                        <div class="alteration-goLink-button">
                                            <a href="/product/{{$product->uuid ?? '#'}}" class="btn go-link-btn">
                                                <i class="fa-sharp fa-solid fa-circle-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                }
            }
        }).mount('#app')

    </script>
@endpush
