@extends('layouts.app')

@section('title') Return Policy @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/about.css"/>
@endpush
@section('content')
    <!-- Breadcrumb List Section Start-->
    <section class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-list">
                        <ul>
                            <li class="breadcrumb-item">
                                <a aria-current="page" href="/"
                                ><i class="fa-solid fa-house"></i
                                    ></a>
                            </li>
                            <li><span> <i class="fa-solid fa-angle-right"></i> </span></li>
                            <li><a href="#"> Return Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Breadcrumb List Section End-->
    <!--About Us Section Start-->
    <section class="about-section text-start">
        <div class="container">
            <div class="about-all-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="about-left-item">
                            <div class="about-us-content text-start">

                                <div class="ms-3">
                                    <p>
                                        For reasons of safety, we cannot allow medicines to be returned once they have
                                        left the pharmacy. The pharmacy is not able to use returned medicines, so we are
                                        not able to process any refund on medication. If you have unwanted medicine,
                                        please contact our pharmacy team and we can arrange for you to safely send the
                                        medication back to us for disposal.
                                    </p>
                                    <p>
                                        For orders that are to be delivered by post, you can cancel an order for
                                        medicines up until the point when your medicine is dispatched. This can be done
                                        by sending an email to info@medinova.co.uk.
                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About Us Section End-->
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
