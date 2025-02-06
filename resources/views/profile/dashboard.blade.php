@extends('layouts.app')

@section('title') Single Category @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/consumerdashboard.css"/>
@endpush
@section('content')
    <section class="consumerdashboard-section">
        <div class="container">
            <div class="consumerdashboard-content">
                <div class="row">
                    <div class="col-md-3">
                        @include('profile.component.sidebar')
                    </div>
                    <div class="col-md-9">
                        Dashboard
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
                    message: 'Hello Vue!',
                }
            }
        }).mount('#app')

    </script>
@endpush
