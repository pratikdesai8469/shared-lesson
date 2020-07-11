<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta charset="utf-8">
  <title>Shared Lessons</title>

  <!-- mobile responsive meta -->
  @php
    $meta = metaData();
  @endphp
  
  <meta name="description" content="{{!empty($meta->description) ? $meta->description : null}}">
  <meta name="keywords" content="{{!empty($meta->keywords) ? $meta->keywords : null}}">
  <meta name="author" content="{{!empty($meta->author) ? $meta->author : null}}">
  <meta name="subject" content="{{!empty($meta->subject) ? $meta->subject : null}}">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <!-- Bootstrap -->
  {{-- <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css"> --}}
  <link rel="stylesheet" href="{{ asset('public/website/plugins/bootstrap/bootstrap.min.css') }}">

  
  <!-- magnific popup -->
  {{-- <link rel="stylesheet" href="plugins/magnific-popup/magnific-popup.css"> --}}
  <link rel="stylesheet" href="{{ asset('public/website/plugins/magnific-popup/magnific-popup.css') }}">


  <!-- Slick Carousel -->
  {{-- <link rel="stylesheet" href="plugins/slick/slick.css"> --}}
  <link rel="stylesheet" href="{{ asset('public/website/plugins/slick/slick.css') }}">


  {{-- <link rel="stylesheet" href="plugins/slick/slick-theme.css"> --}}
  <link rel="stylesheet" href="{{ asset('public/website/plugins/slick/slick-theme.css') }}">

  <!-- themify icon -->
  {{-- <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css"> --}}
  <link rel="stylesheet" href="{{ asset('public/website/plugins/themify-icons/themify-icons.css') }}">

  <!-- animate -->
  {{-- <link rel="stylesheet" href="plugins/animate/animate.css"> --}}
  <link rel="stylesheet" href="{{ asset('public/website/plugins/animate/animate.css') }}">
  
  <!-- Aos -->
  {{-- <link rel="stylesheet" href="plugins/aos/aos.css"> --}}
  <link rel="stylesheet" href="{{ asset('public/website/plugins/aos/aos.css') }}">

  <!-- Stylesheets -->
  {{-- <link href="css/style.css" rel="stylesheet"> --}}
  <link href="{{ asset('public/website/css/style.css') }}" rel="stylesheet">
  
  {{-- <link rel="stylesheet" href="{{ asset('public/website/plugins/selectize/selectize.css') }}"> --}}

  
  {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" rel="stylesheet">
   --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.min.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
  
  <!--Favicon-->
  {{-- <link rel="shortcut icon" href="images/dog-logo.png" type="image/x-icon"> --}}
  <link rel="shortcut icon" href="{{ asset('public/website/images/logo1.png') }}" type="image/x-icon">
 
  {{-- <link rel="icon" href="images/dog-logo.png" type="image/x-icon"> --}}
  <link rel="icon" href="{{ asset('public/website/images/logo1.png') }}" type="image/x-icon">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-169943680-1"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-169919188-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-169919188-1');
  </script>
  @yield('css')
</head>

<body>
  
<!-- preloader start -->
<div class="preloader">
    <img src="{{ asset('public/website/images/preloader.gif') }}" alt="preloader">
</div>
<!-- preloader end -->

@include('includes.website.header')

@yield('content')

@include('includes.website.footer')

<!-- jQuery -->
{{-- <script src="plugins/jQuery/jquery.min.js"></script> --}}
<script src="{{ asset('public/website/plugins/jQuery/jquery.min.js') }}"></script>

<!-- Bootstrap JS -->
{{-- <script src="plugins/bootstrap/bootstrap.min.js"></script> --}}
<script src="{{ asset('public/website/plugins/bootstrap/bootstrap.min.js') }}"></script>

<!-- magnific popup -->
{{-- <script src="plugins/magnific-popup/jquery.magnific.popup.min.js"></script> --}}
<script src="{{ asset('public/website/plugins/magnific-popup/jquery.magnific.popup.min.js') }}"></script>

<!-- slick slider -->
{{-- <script src="plugins/slick/slick.min.js"></script> --}}
<script src="{{ asset('public/website/plugins/slick/slick.min.js') }}"></script>

<!-- mixitup filter -->
{{-- <script src="plugins/mixitup/mixitup.min.js"></script> --}}
<script src="{{ asset('public/website/plugins/mixitup/mixitup.min.js') }}"></script>

<!-- Syo Timer -->
{{-- <script src="plugins/syotimer/jquery.syotimer.js"></script> --}}
<script src="{{ asset('public/website/plugins/syotimer/jquery.syotimer.js') }}"></script>

<!-- aos -->
{{-- <script src="plugins/aos/aos.js"></script> --}}
<script src="{{ asset('public/website/plugins/aos/aos.js') }}"></script>


<!-- Main Script -->
{{-- <script src="js/script.js"></script> --}}
<script src="{{ asset('public/website/js/script.js') }}"></script>


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/selectize.min.js"></script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

{{-- <script src="{{ asset('public/website/plugins/selectize/selectize.js') }}"></script> --}}
@yield('script')
</body>
</html>