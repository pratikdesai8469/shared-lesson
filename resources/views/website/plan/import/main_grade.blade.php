@extends('layouts.website.main')

@section('css')
<style>
.form-control::-webkit-input-placeholder {
    color: #bbb;
}
</style>
@endsection
@section('content')


<section class="page-title overlay" style="background-image: url({{ asset('public/website/images/background/page-title.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="text-white font-weight-bold">Import Excel Sheet</h2>
                <ol class="breadcrumb">
                    <li>Grade Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- contact -->
<section class="section">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <!-- form -->
            <div class="col-lg-9 col-md-9">
                @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{$message}}</strong>
                    </div>
                @endif
                <div class="p-5 rounded box-shadow">
                    {{Form::open(['url'=>'import-main-grade','method'=>'post','files'=>'true'])}}
                        <div class="col-lg-12">
                            <h3>Import Excel Sheet</h3>
                            <div class="row">
                                <div class="col-lg-4 mt-3">
                                    <label for="s_date">Choose Sheet</label>
                                    {{Form::file('upload')}}
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-8">
                                    @if(Session::has('upload_error'))
                                        <div class="form-error text-danger">{{Session::get('upload_error')}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-5">
                            <button class="btn btn-primary save1"  value="1" data-id="1">Upload</button>
                            <a href="{{URL::to('plan')}}" class="btn btn-info">Cancel</a>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('script')

<script type="text/javascript">
    $('#grade').selectize({
        create: true,
        sortField: 'text'
    });
</script>
@endsection



