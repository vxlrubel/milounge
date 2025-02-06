@extends('layouts.app')

@section('title') Terms and Conditions @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/link-more.css"/>
@endpush
@section('content')
    <!--Refund Policy Section Start-->
    <section class="refund-section">
        <div class="container">
            <div class="refund-policy-allcontent">
                <div class="row">
                    <div class="col-md-10 m-auto text-center">
                        <div class="refund-policy-header">
                            <h1>Terms and Conditions</h1>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="refund-policy-content-details">
                            <h4>Content Coming Soon</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Refund Policy Section End-->
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
