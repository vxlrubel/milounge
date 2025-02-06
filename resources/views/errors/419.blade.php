@extends('layouts.app')

@section('title') 419 @endsection

@section('content')

    <section class="filtarable-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-10 col-lg-10 text-center m-auto">
                    <div class="filtarable-galary-paragraph">
                        <div class="mt-3 mb-3">
                            <img src="/assets/images/404.png" alt="">
                        </div>

                        <div class="mb-3">
                            <a href="/"><u>Click here</u> </a> to go home.
                        </div>
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
                    countDown: 3
                }
            },
            created() {
                const self = this;
                //self.countDownTimer()
            },
            methods: {
                countDownTimer : function () {
                    const self = this;
                    if (self.countDown > 0) {
                        setTimeout(() => {
                            self.countDown -= 1
                            self.countDownTimer()
                        }, 1000)
                    }else{
                        window.location = '/'
                    }
                }
            }
        }).mount('#app')

    </script>
@endpush
