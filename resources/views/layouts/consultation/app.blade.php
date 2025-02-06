<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="/assets/css/all.min.css"/>
    <!-- Bootstrap CSS Link-->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <!-- Main CSS File -->
    <link rel="stylesheet" href="/assets/css/style.css"/>
    <link rel="stylesheet" href="/assets/css/mediaquery.css"/>
    <title> @yield('title') | {{config('app.name')}} | {{config('app.url')}}</title>

    @stack('style')
</head>
<body>

@include('layouts.consultation.header')

<div class="body-wrapper">

    @yield('content')

    @include('layouts.footer')

</div>
<!-- JS File Link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="/assets/js/slider.js"></script>
<script src="/assets/js/all.min.js"></script>
<script src="/assets/js/filtarable.js"></script>

@stack('script')

</body>
</html>
