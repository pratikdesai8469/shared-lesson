@extends('layouts.website.main')

@section('css')
<style>
    .video-parent {
        border-bottom: 1px solid black;
        border-top: 1px solid black;
        border-left: 1px solid black;
    } 
</style>
@endsection

@section('content')

<section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">How To Use</h2>
            </div>
        </div>
    </div>
</section>

<!-- hero area -->
<section class="section " >
    {{-- <div class="container "> --}}
        <div class="row d-flex justify-content-around video-parent1">
            <video  controls autoplay muted loop  class="embed-responsive">
                <source src="{{asset('public/website/images/how_to_use.webm')}}" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        
        </div>
    {{-- </div> --}}
</section>
<!-- /hero-area -->
@endsection
