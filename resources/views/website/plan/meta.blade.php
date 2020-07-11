@extends('layouts.website.main')

@section('css')
<style>
.form-control::-webkit-input-placeholder {
    color: #bbb;
}
.add-btn{
   padding: 11px 30px !important;
}
</style>
@endsection
@section('content')


<section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">Meta</h2>
                <ol class="breadcrumb">
                    <li>Meta For SEO</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- contact -->
<section class="section ">
    <div class="container ">
        <div class="row align-items-center justify-content-center">
            <!-- form -->
            <div class="col-lg-9 col-md-9">
                @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <div class="p-5 rounded box-shadow">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Meta For SEO</h3>
                        </div>
                    </div>
                    <form action="{{url('seo')}}"  method="POST" class="row mt-4">
                        {{ csrf_field() }}
                        <div class="col-lg-12">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" value="{{!empty($seo->subject) ? $seo->subject : ''}}" id="subject" class="form-control" placeholder="Subject">
                        </div>
                        <div class="col-lg-12">
                            <label for="unit_topic">Description</label>
                            <input type="text" name="description" value="{{!empty($seo->description) ? $seo->description : ''}}" id="description" class="form-control" placeholder="Description">
                        </div>
                        <div class="col-lg-12">
                            <label for="l_name">Author</label>
                            <input type="text" name="author" value="{{!empty($seo->author) ? $seo->author : ''}}" id="author" class="form-control" placeholder="Author">
                        </div>
                        <div class="col-lg-12">
                            <label for="l_name">Keywords</label>
                            <input type="text" name="keywords" value="{{!empty($seo->keywords) ? $seo->keywords : ''}}" id="keywords" class="form-control" placeholder="Keywords">
                        </div>
                        <div class="col-lg-12">
                            <input class="btn btn-primary" type="submit" value="Add">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('script')

@endsection



